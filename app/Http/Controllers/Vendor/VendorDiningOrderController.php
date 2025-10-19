<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiningOrder;

class VendorDiningOrderController extends Controller
{
   public function index(Request $request)
   {
        $vendorId = auth()->id(); // Assuming vendor is authenticated

        $query = DiningOrder::where('vendor_id', $vendorId);

        // Search filter (by customer name or table number)
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_no', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('vendor.dining_orders.index', compact('orders'));
   }

    public function updateStatus(Request $request)
    {
        $order = DiningOrder::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully!']);
    }




}
