<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\PosSetting;
use App\Models\VendorCategory;
use App\Models\VendorMenu;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

        $posSetting = $this->getPosSetting($vendorId);

        return view('vendor.pos.index', [
            'categories' => $categories,
            'posSetting' => $posSetting,
        ]);
    }

    public function categories()
    {
        $vendorId = auth()->id();

        $categories = VendorCategory::query()
            ->where('vendor_id', $vendorId)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'data' => $categories,
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
        $status = $request->input('status', 'completed');
        if (!in_array($status, ['draft', 'completed'], true)) {
            $status = 'completed';
        }

        $contactRules = ['nullable', 'string', 'max:30'];
        if ($status !== 'draft') {
            array_unshift($contactRules, 'required');
        }

        $validator = Validator::make($request->all(), [
            'status' => ['nullable', Rule::in(['draft', 'completed'])],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_contact' => $contactRules,
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

        $payload = $validator->validated();

        $status = $payload['status'] ?? $status;

        $vendorId = auth()->id();
        $discount = (float) ($payload['discount_amount'] ?? 0);
        $itemPayload = collect($payload['items'] ?? []);
        $customerName = $payload['customer_name'];
        $customerEmail = $payload['customer_email'] ?? null;
        $customerContact = $payload['customer_contact'] ?? null;

        if (is_string($customerContact) && trim($customerContact) === '') {
            $customerContact = null;
        }
        if (is_string($customerEmail) && trim($customerEmail) === '') {
            $customerEmail = null;
        }

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

        DB::transaction(function () use (&$order, $vendorId, $customerName, $customerEmail, $customerContact, $subtotal, $discount, $total, $items, $status) {
            $order = PosOrder::create([
                'vendor_id' => $vendorId,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_contact' => $customerContact ?? '',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'total_amount' => $total,
                'status' => $status,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
        });

        return response()->json([
            'status' => 1,
            'message' => $status === 'draft' ? 'Order saved as draft.' : 'Order created successfully.',
            'order_id' => $order->id,
            'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            'order_status' => $status,
        ]);
    }

    public function orders()
    {
        $vendorId = auth()->id();
        $posSetting = $this->getPosSetting($vendorId);

        return view('vendor.pos.orders', [
            'posSetting' => $posSetting,
        ]);
    }

    public function ordersList(Request $request)
    {
        $vendorId = auth()->id();

        $posSetting = $this->getPosSetting($vendorId);
        $timezone = $posSetting->timezone ?: config('app.timezone');

        $query = PosOrder::query()
            ->where('vendor_id', $vendorId);

        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $exception) {
                // Ignore invalid dates and continue without applying the filter
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $exception) {
                // Ignore invalid dates and continue without applying the filter
            }
        }

        $orders = $query
            ->orderByDesc('created_at')
            ->limit(50)
            ->get()
            ->map(function (PosOrder $order) use ($timezone) {
                $createdAt = $order->created_at->copy()->timezone($timezone)->format('d M Y H:i');
                return [
                    'id' => $order->id,
                    'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
                    'customer_name' => $order->customer_name,
                    'customer_contact' => $order->customer_contact,
                    'total_amount' => (float) $order->total_amount,
                    'status' => $order->status,
                    'created_at' => sprintf('%s (%s)', $createdAt, $timezone),
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

        $posSetting = $this->getPosSetting($order->vendor_id);
        $timezone = $posSetting->timezone ?: config('app.timezone');

        $createdAt = $order->created_at->copy()->timezone($timezone)->format('d M Y H:i');

        return response()->json([
            'id' => $order->id,
            'reference' => str_pad((string) $order->id, 6, '0', STR_PAD_LEFT),
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_contact' => $order->customer_contact,
            'subtotal' => (float) $order->subtotal,
            'discount_amount' => (float) $order->discount_amount,
            'total_amount' => (float) $order->total_amount,
            'status' => $order->status,
            'created_at' => sprintf('%s (%s)', $createdAt, $timezone),
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

    public function print(Request $request, PosOrder $order)
    {
        if ($order->vendor_id !== auth()->id()) {
            abort(404);
        }

        $order->load('items');

        $vendor = auth()->user();

        $posSetting = $this->getPosSetting($order->vendor_id);
        $timezone = $posSetting->timezone ?: config('app.timezone');
        $receiptTime = $order->created_at->copy()->timezone($timezone);

        $format = strtolower($request->input('format', '80mm'));
        if (!in_array($format, ['80mm', 'a4'], true)) {
            $format = '80mm';
        }

        return view('vendor.pos.print', [
            'order' => $order,
            'vendor' => $vendor,
            'format' => $format,
            'posSetting' => $posSetting,
            'receiptTime' => $receiptTime,
        ]);
    }

    protected function getPosSetting(int $vendorId): PosSetting
    {
        return PosSetting::firstOrNew(
            ['vendor_id' => $vendorId],
            [
                'currency' => '₹',
                'timezone' => 'Asia/Kolkata',
                'default_customer_name' => 'Walk-in Customer',
                'default_contact_number' => '',
            ]
        );
    }

    public function update(Request $request, PosOrder $order)
    {
        if ($order->vendor_id !== auth()->id()) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['draft', 'completed'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $status = $validator->validated()['status'];

        if ($order->status === $status) {
            return response()->json([
                'status' => 1,
                'message' => 'Order status is already up to date.',
            ]);
        }

        $order->update(['status' => $status]);

        return response()->json([
            'status' => 1,
            'message' => $status === 'draft' ? 'Order moved back to draft.' : 'Order confirmed successfully.',
            'order_status' => $status,
        ]);
    }
}
