<?php

namespace App\Http\Controllers;

use App\Models\DiningOrder;
use App\Models\DiningOrderItem;
use App\Models\MenuCategory;
use App\Models\Setting;
use App\Models\Vendor;
use App\Models\VendorMenu;
use App\Models\VendorUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderAppController extends Controller
{
    /**
     * Resolve the vendor and settings for the provided code.
     */
    protected function loadVendorContext(string $code): array
    {
        $vendor = Vendor::where('code', $code)->firstOrFail();
        $settings = Setting::where('vendor_id', $vendor->id)->first();

        return [$vendor, $settings];
    }

    /**
     * Display the landing page for the ordering experience.
     */
    public function index(string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        return view('order.index', compact('vendor', 'settings'));
    }

    /**
     * Show the item listing page.
     */
    public function items(string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        return view('order.item-list', compact('vendor', 'settings'));
    }

    /**
     * Show the checkout page.
     */
    public function checkout(Request $request, string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        $guard = Auth::guard('vendor_user');

        if (!$guard->check() || $guard->user()->vendor_id !== $vendor->id) {
            if ($guard->check() && $guard->user()->vendor_id !== $vendor->id) {
                $guard->logout();
            }

            $request->session()->put('order.return_url', route('order.checkout', ['code' => $vendor->code]));

            return redirect()->route('order.login', ['code' => $vendor->code]);
        }

        return view('order.checkout', compact('vendor', 'settings'));
    }

    /**
     * Show the profile and order history page.
     */
    public function profile(Request $request, string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        $guard = Auth::guard('vendor_user');

        if (!$guard->check() || $guard->user()->vendor_id !== $vendor->id) {
            if ($guard->check() && $guard->user()->vendor_id !== $vendor->id) {
                $guard->logout();
            }

            $request->session()->put('order.return_url', route('order.profile', ['code' => $vendor->code]));

            return redirect()->route('order.login', ['code' => $vendor->code]);
        }

        return view('order.profile', compact('vendor', 'settings'));
    }

    /**
     * Show the login form.
     */
    public function login(Request $request, string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        $guard = Auth::guard('vendor_user');

        if ($guard->check()) {
            if ($guard->user()->vendor_id === $vendor->id) {
                $target = $request->session()->pull('order.return_url')
                    ?? route('order.checkout', ['code' => $vendor->code]);

                return redirect()->to($target);
            }

            $guard->logout();
        }

        return view('order.login', compact('vendor', 'settings'));
    }

    /**
     * Show the sign up form.
     */
    public function signup(Request $request, string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        $guard = Auth::guard('vendor_user');

        if ($guard->check()) {
            if ($guard->user()->vendor_id === $vendor->id) {
                $target = $request->session()->pull('order.return_url')
                    ?? route('order.checkout', ['code' => $vendor->code]);

                return redirect()->to($target);
            }

            $guard->logout();
        }

        return view('order.signup', compact('vendor', 'settings'));
    }

    /**
     * Handle login submission for vendor users.
     */
    public function authenticate(Request $request, string $code)
    {
        [$vendor] = $this->loadVendorContext($code);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $remember = $request->boolean('remember');
        $guard = Auth::guard('vendor_user');

        if ($guard->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'vendor_id' => $vendor->id,
        ], $remember)) {
            $request->session()->regenerate();

            $redirectTo = $request->session()->pull('order.return_url')
                ?? route('order.checkout', ['code' => $vendor->code]);

            return redirect()->to($redirectTo)->with('status', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email', 'remember');
    }

    /**
     * Handle signup submission for vendor users.
     */
    public function register(Request $request, string $code)
    {
        [$vendor] = $this->loadVendorContext($code);

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'You must accept the terms & conditions to continue.',
        ]);

        $existing = VendorUser::where('vendor_id', $vendor->id)
            ->where('email', $data['email'])
            ->exists();

        if ($existing) {
            return back()->withErrors([
                'email' => 'An account with this email already exists for this restaurant.',
            ])->withInput();
        }

        $user = VendorUser::create([
            'vendor_id' => $vendor->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('vendor_user')->login($user);
        $request->session()->regenerate();

        $redirectTo = $request->session()->pull('order.return_url')
            ?? route('order.checkout', ['code' => $vendor->code]);

        return redirect()->to($redirectTo)->with('status', 'Account created successfully.');
    }

    /**
     * Logout the active vendor user session.
     */
    public function logout(Request $request, string $code)
    {
        [$vendor] = $this->loadVendorContext($code);

        Auth::guard('vendor_user')->logout();

        $request->session()->forget('order.return_url');
        $request->session()->regenerateToken();

        return redirect()->route('order.login', ['code' => $vendor->code])
            ->with('status', 'You have been signed out successfully.');
    }

    /**
     * Provide menu and vendor data for the order application.
     */
    public function menu(string $code)
    {
        [$vendor, $settings] = $this->loadVendorContext($code);

        $categories = MenuCategory::query()
            ->whereHas('vendorMenus', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id)->where('status', 1);
            })
            ->with(['vendorMenus' => function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id)
                    ->where('status', 1)
                    ->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $categoryPayload = $categories->map(function (MenuCategory $category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'items' => $category->vendorMenus->map(function (VendorMenu $menu) {
                    $priceFull = is_null($menu->price_full) ? null : (float) $menu->price_full;
                    $priceHalf = is_null($menu->price_half) ? null : (float) $menu->price_half;

                    $displayPrice = $priceFull ?? $priceHalf ?? 0;
                    $preferredVariant = !is_null($priceFull) ? 'full' : (!is_null($priceHalf) ? 'half' : null);

                    return [
                        'id' => $menu->id,
                        'name' => $menu->name,
                        'description' => $menu->description,
                        'price_full' => $priceFull,
                        'price_half' => $priceHalf,
                        'display_price' => $displayPrice,
                        'default_variant' => $preferredVariant,
                        'image_url' => $menu->image ? asset($menu->image) : null,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json([
            'vendor' => [
                'name' => $settings->store_name ?? $vendor->name,
                'address' => $settings->store_address ?? null,
                'contact' => $settings->store_contact ?? null,
                'email' => $settings->store_email ?? null,
                'logo' => $settings && $settings->menu_logo ? asset($settings->menu_logo) : null,
            ],
            'categories' => $categoryPayload,
        ]);
    }

    /**
     * Store a new dining or pickup order submitted from the order application.
     */
    public function store(Request $request, string $code)
    {
        $vendor = Vendor::where('code', $code)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'order_type' => ['required', Rule::in(['dine-in', 'pickup'])],
            'customer_name' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'table_number' => ['nullable', 'string', 'max:50'],
            'special_request' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['nullable', 'integer'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.variant' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $payload = $validator->validated();
        $orderType = $payload['order_type'];
        $tableNumber = $payload['table_number'] ?? null;

        if ($orderType === 'dine-in' && empty($tableNumber)) {
            return response()->json([
                'status' => 0,
                'errors' => ['Table number is required for dine-in orders.'],
            ], 422);
        }

        if ($orderType === 'pickup') {
            $tableNumber = $tableNumber ?: 'PICKUP';
        }

        $items = collect($payload['items'])->map(function (array $item) {
            $quantity = (int) $item['quantity'];
            $price = (float) $item['price'];

            return [
                'id' => $item['id'] ?? null,
                'name' => $item['name'],
                'quantity' => $quantity,
                'price' => $price,
                'variant' => $item['variant'] ?? null,
                'total' => round($quantity * $price, 2),
            ];
        });

        if ($items->contains(function ($item) {
            return $item['price'] <= 0;
        })) {
            return response()->json([
                'status' => 0,
                'errors' => ['All items must have a valid price.'],
            ], 422);
        }

        $totalAmount = $items->sum('total');

        $orderId = $this->generateOrderId();
        $now = Carbon::now();

        $order = DB::transaction(function () use ($vendor, $payload, $orderId, $tableNumber, $totalAmount, $items, $now) {
            $order = DiningOrder::create([
                'vendor_id' => $vendor->id,
                'order_id' => $orderId,
                'customer_name' => $payload['customer_name'],
                'order_type' => $payload['order_type'],
                'contact_no' => $payload['contact_no'],
                'email' => $payload['email'] ?? null,
                'table_number' => $tableNumber,
                'order_date' => $now->toDateString(),
                'order_time' => $now->format('H:i:s'),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => null,
                'special_request' => $payload['special_request'] ?? null,
            ]);

            foreach ($items as $item) {
                DiningOrderItem::create([
                    'dining_order_id' => $order->id,
                    'vendor_menu_id' => $item['id'],
                    'item_name' => $item['name'],
                    'variant' => $item['variant'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['total'],
                ]);
            }

            return $order;
        });

        return response()->json([
            'status' => 1,
            'message' => 'Order placed successfully.',
            'data' => [
                'order_id' => $order->order_id,
                'order_type' => $order->order_type,
                'total_amount' => (float) $order->total_amount,
            ],
        ]);
    }

    /**
     * Retrieve the order history for a customer based on contact details.
     */
    public function history(Request $request, string $code)
    {
        $vendor = Vendor::where('code', $code)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'contact' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $payload = $validator->validated();

        $query = DiningOrder::with('items')
            ->where('vendor_id', $vendor->id)
            ->where('contact_no', $payload['contact']);

        if (!empty($payload['email'])) {
            $query->where('email', $payload['email']);
        }

        $orders = $query->orderByDesc('created_at')->limit(20)->get();

        return response()->json([
            'status' => 1,
            'orders' => $orders->map(function (DiningOrder $order) {
                $orderDate = $order->order_date instanceof \DateTimeInterface
                    ? $order->order_date->format('Y-m-d')
                    : ($order->order_date ?? '');

                $orderTime = $order->order_time instanceof \DateTimeInterface
                    ? $order->order_time->format('H:i:s')
                    : ($order->order_time ?? '');

                return [
                    'order_id' => $order->order_id,
                    'order_type' => $order->order_type,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'table_number' => $order->table_number,
                    'total_amount' => (float) $order->total_amount,
                    'order_date' => $orderDate,
                    'order_time' => $orderTime,
                    'created_at' => optional($order->created_at)->toDateTimeString(),
                    'items' => $order->items->map(function (DiningOrderItem $item) {
                        return [
                            'name' => $item->item_name,
                            'variant' => $item->variant,
                            'quantity' => $item->quantity,
                            'unit_price' => (float) $item->unit_price,
                            'total_price' => (float) $item->total_price,
                        ];
                    })->values(),
                ];
            })->values(),
        ]);
    }

    /**
     * Generate a unique order identifier.
     */
    protected function generateOrderId(): string
    {
        do {
            $orderId = 'ORD' . strtoupper(Str::random(6));
        } while (DiningOrder::where('order_id', $orderId)->exists());

        return $orderId;
    }
}
