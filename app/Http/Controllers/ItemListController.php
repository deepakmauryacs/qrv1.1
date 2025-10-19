<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Setting;
use App\Models\MenuCategory;
use App\Models\VendorMenu;
use App\Models\QRScan;
use App\Models\VendorContact;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;




class ItemListController extends Controller
{
    


    public function index1($vendor_code)
    {
        // Fetch the vendor ID based on vendor code
        $vendor = Vendor::where('code', $vendor_code)->first();

        if (!$vendor) {
            abort(404, 'Vendor not found');
        }

        // Fetch unique menu categories from the menus table for the vendor
        $menuCategories = VendorMenu::where('vendor_id', $vendor->id)
            ->where('status', 1)
            ->select('menu_category_id')
            ->distinct()
            ->pluck('menu_category_id');

        // Fetch menu items grouped by category
        $menuItems = [];
        foreach ($menuCategories as $categoryId) {
            $menuItems[$categoryId] = VendorMenu::where('vendor_id', $vendor->id)
                ->where('menu_category_id', $categoryId)
                ->where('status', 1)
                ->get();
        }

        return view('vendor.item_list1', compact('menuItems', 'vendor'));
    }

    public function index($vendor_code)
    {
        // Fetch the vendor by vendor code
        $vendor = Vendor::where('code', $vendor_code)->first();

        if (!$vendor) {
            abort(404, 'Vendor not found');
        }

        // Fetch vendor settings
        $settings = Setting::where('vendor_id', $vendor->id)->first();

        // Log QR Scan (Insert into `qr_scans` table)
        QRScan::create([
            'vendor_id' => $vendor->id, // Assuming `restaurant_id` is the vendor ID
            'qr_code' => $vendor_code, // Store QR code (vendor code in this case)
            'user_ip' => request()->ip(), // Get user IP address correctly
            'scanned_at' => now(), // Current timestamp
        ]);

        // Fetch menu categories that have at least one menu item for the vendor
        $menuCategories = MenuCategory::whereHas('vendorMenus', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id)->where('status', 1);
        })->with(['vendorMenus' => function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id)->where('status', 1);
        }])->get();

  

        return view('webapp.item_list1', compact('menuCategories', 'vendor','settings'));
    }
    
    public function contact($vendor_code){
        // Fetch the vendor by vendor code
        $vendor = Vendor::where('code', $vendor_code)->first();
        if (!$vendor) {
            abort(404, 'Vendor not found');
        }
        // Fetch vendor settings
        $settings = Setting::where('vendor_id', $vendor->id)->first();
        return view('webapp.contact', compact('vendor','settings'));
    }
    
    public function save_contact(Request $request)
    {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return JSON with validation errors
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

     
            // Sanitize the input data
            $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING);
            $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL);
            $subject = filter_var(trim($request->input('subject')), FILTER_SANITIZE_STRING);
            $message = filter_var(trim($request->input('message')), FILTER_SANITIZE_STRING);

            // If you want to remove HTML tags, use:
            $name = strip_tags($name);
            $email = strip_tags($email);
            $subject = strip_tags($subject);
            $message = strip_tags($message);

            // Create a new VendorContact record
            $contact = new VendorContact();
            $contact->name = $name;
            $contact->email = $email;
            $contact->subject = $subject;
            $contact->message = $message;
            $contact->save();

            return response()->json(['status' => 1, 'message' => 'Message sent successfully']);
       
    }



}
