<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\VendorCategory;
use App\Models\VendorMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VendorPosController extends Controller
{
    public function index()
    {
        $vendorId = auth()->id();

        $categories = VendorCategory::query()
            ->where('vendor_id', $vendorId)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('vendor.pos.index', [
            'categories' => $categories,
        ]);
    }

    public function products(Request $request)
    {
        $vendorId = auth()->id();

        $query = VendorMenu::query()
            ->where('vendor_id', $vendorId)
            ->where('status', 1);

        if ($request->filled('category_id')) {
            $query->where('menu_category_id', $request->integer('category_id'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->get()->map(function (VendorMenu $menu) {
            $priceFull = is_null($menu->price_full) ? null : (float) $menu->price_full;
            $priceHalf = is_null($menu->price_half) ? null : (float) $menu->price_half;
            $displayPrice = $priceFull ?? $priceHalf ?? 0;

            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'description' => $menu->description,
                'price_full' => $priceFull,
                'price_half' => $priceHalf,
                'price' => $displayPrice,
                'image_url' => $menu->image ? asset($menu->image) : null,
                'category_id' => $menu->menu_category_id,
            ];
        })->values();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_contact' => ['required', 'string', 'max:30'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price_type' => ['nullable', Rule::in(['full', 'half'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $vendorId = auth()->id();
        $discount = (float) ($request->input('discount_amount', 0));
        $itemPayload = collect($request->input('items', []));

        $menuRecords = VendorMenu::query()
            ->where('vendor_id', $vendorId)
            ->whereIn('id', $itemPayload->pluck('id'))
            ->get()
            ->keyBy('id');

        if ($menuRecords->count() !== $itemPayload->count()) {
            return response()->json([
                'status' => 0,
                'errors' => ['One or more menu items could not be found.'],
            ], 422);
        }

        $subtotal = 0;
        $items = [];

        $errors = [];

        foreach ($itemPayload as $item) {
            $menu = $menuRecords->get($item['id']);
            $quantity = (int) $item['quantity'];
            $priceType = $item['price_type'] ?? null;
            $unitPrice = 0;
            $nameSuffix = '';

            if ($priceType === 'full') {
                if (is_null($menu->price_full)) {
                    $errors[] = "Full price is not available for {$menu->name}.";
                    continue;
                }
                $unitPrice = (float) $menu->price_full;
                $nameSuffix = ' (Full)';
            } elseif ($priceType === 'half') {
                if (is_null($menu->price_half)) {
                    $errors[] = "Half price is not available for {$menu->name}.";
                    continue;
                }
                $unitPrice = (float) $menu->price_half;
                $nameSuffix = ' (Half)';
            } else {
                if (!is_null($menu->price_full)) {
                    $unitPrice = (float) $menu->price_full;
                    $priceType = 'full';
                    $nameSuffix = ' (Full)';
                } elseif (!is_null($menu->price_half)) {
                    $unitPrice = (float) $menu->price_half;
                    $priceType = 'half';
                    $nameSuffix = ' (Half)';
                } else {
                    $errors[] = "Price is not configured for {$menu->name}.";
                    continue;
                }
            }

            if ($unitPrice <= 0) {
                $errors[] = "Price is not available for {$menu->name}.";
                continue;
            }

            $lineTotal = $unitPrice * $quantity;
            $subtotal += $lineTotal;

            $items[] = [
                'vendor_menu_id' => $menu->id,
                'item_name' => $menu->name . $nameSuffix,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => 0,
                'errors' => $errors,
            ], 422);
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $total = $subtotal - $discount;

        $order = null;

        DB::transaction(function () use (&$order, $vendorId, $request, $subtotal, $discount, $total, $items) {
            $order = PosOrder::create([
                'vendor_id' => $vendorId,
                'customer_name' => $request->input('customer_name'),
                'customer_email' => $request->input('customer_email'),
                'customer_contact' => $request->input('customer_contact'),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'total_amount' => $total,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
        });

        return response()->json([
            'status' => 1,
            'message' => 'Order created successfully.',
            'order_id' => $order->id,
            'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
        ]);
    }

    public function orders()
    {
        return view('vendor.pos.orders');
    }

    public function ordersList()
    {
        $vendorId = auth()->id();

        $orders = PosOrder::query()
            ->where('vendor_id', $vendorId)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get()
            ->map(function (PosOrder $order) {
                return [
                    'id' => $order->id,
                    'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                    'customer_contact' => $order->customer_contact,
                    'total_amount' => (float) $order->total_amount,
                    'created_at' => $order->created_at->toDateTimeString(),
                ];
            })->values();

        return response()->json([
            'data' => $orders,
        ]);
    }

    public function show(PosOrder $order)
    {
        if ($order->vendor_id !== auth()->id()) {
            abort(404);
        }

        $order->load('items');

        return response()->json([
            'id' => $order->id,
            'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_contact' => $order->customer_contact,
            'subtotal' => (float) $order->subtotal,
            'discount_amount' => (float) $order->discount_amount,
            'total_amount' => (float) $order->total_amount,
            'created_at' => $order->created_at->toDateTimeString(),
            'items' => $order->items->map(function (PosOrderItem $item) {
                return [
                    'id' => $item->id,
                    'item_name' => $item->item_name,
                    'unit_price' => (float) $item->unit_price,
                    'quantity' => $item->quantity,
                    'line_total' => (float) $item->line_total,
                ];
            })->values(),
        ]);
    }

    public function print(PosOrder $order)
    {
        if ($order->vendor_id !== auth()->id()) {
            abort(404);
        }

        $order->load('items');

        $vendor = auth()->user();

        return view('vendor.pos.print', [
            'order' => $order,
            'vendor' => $vendor,
        ]);
    }
}
