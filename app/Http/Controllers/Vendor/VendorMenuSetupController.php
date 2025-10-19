<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\VendorMenuSetup;
use Auth;

class VendorMenuSetupController extends Controller
{   

    public function index()
    {
        return view('vendor.menus.menu_setup');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'discount' => 'required|integer|min:1|max:99',
        ]);

        $vendorId = Auth::id(); // Assuming vendor is authenticated

        $vendorSetup = VendorMenuSetup::updateOrCreate(
            ['vendor_id' => $vendorId], // Condition
            ['discount' => $request->discount] // Data to update
        );

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully!',
            'data' => $vendorSetup
        ]);
    }

    public function getDiscount()
    {
        $vendorId = Auth::id();
        $vendorSetup = VendorMenuSetup::where('vendor_id', $vendorId)->first();

        return response()->json([
            'success' => true,
            'discount' => $vendorSetup ? $vendorSetup->discount : null
        ]);
    }
}
