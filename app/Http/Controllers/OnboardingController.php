<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OnboardingController extends Controller
{
    // Show the vendor onboarding form
    public function index()
    {
        return view('onboarding');
    }

    // Handle the form submission and store vendor details
    public function store(Request $request)
    {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'contact_number' => 'required|string|max:15|min:10',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        // Generate a unique vendor code in the format: VEND-YYYY-RANDOM
        do {
            $vendorCode = 'VEND-' . date('Y') . '-' . Str::random(6); // Example: VEND-2025-ABC123
        } while (Vendor::where('code', $vendorCode)->exists()); // Ensure the code is unique

        // Sanitize inputs
        $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL);
        $contact_number = filter_var(trim($request->input('contact_number')), FILTER_SANITIZE_STRING);
        $owner_name = filter_var(trim($request->input('owner_name')), FILTER_SANITIZE_STRING);
        $address = filter_var(trim($request->input('address')), FILTER_SANITIZE_STRING);
        $password = $request->input('password'); // Password input

        $password = Hash::make($password);

        // Remove HTML tags for safety
        $name = strip_tags($name);
        $email = strip_tags($email);
        $contact_number = strip_tags($contact_number);
        $owner_name = strip_tags($owner_name);
        $address = strip_tags($address);

        // Create a new vendor and assign sanitized data
        $vendor = new Vendor();
        $vendor->code = $vendorCode; // Assign unique code
        $vendor->name = $name;
        $vendor->email = $email;
        $vendor->password = $password;
        $vendor->contact_number = $contact_number;
        $vendor->owner_name = $owner_name;
        $vendor->address = $address;



        $vendor->save();

        // Save the settings data
        $settings = new Setting();
        $settings->vendor_id = $vendor->id; // Link settings to the vendor
        $settings->store_logo = '';
        $settings->store_name = $name;
        $settings->country = 'India';
        $settings->state = '';
        $settings->city = '';
        $settings->store_address = $address;
        $settings->store_lat = '0.00';
        $settings->store_long = '0.00';
        $settings->dine_in = 0;
        $settings->store_email = $email;
        $settings->country_code = '91';
        $settings->store_contact = $contact_number;
        $settings->opening_time = '10:00';
        $settings->closing_time = '23:00';

        // Save the settings
        $settings->save();


        return response()->json(['status' => 1, 'message' => 'Vendor onboarded successfully!']);
    }

}
