<?php

namespace App\Http\Controllers\Vendor;
use App\Models\Setting;
use App\Models\Country;
use App\Models\State;
use App\Models\Timezone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Don't forget to import Carbon if it's not already imported

class VendorSettingController extends Controller
{
    /**
     * Display a listing of the setting.
     */
    public function index(Request $request)
    {   
        
        // You might get the vendor_id from authenticated vendor details or request input.
        // For this example, we assume it comes via the request or is defined.
        $vendor_id = Auth::id();
        
        // Retrieve the setting record for this vendor (if exists)
        $setting = Setting::where('vendor_id', $vendor_id)->first();
        
        // Fetch all countries from the `countries` table
        $countries = Country::orderBy('name', 'asc')->get(); // Assuming there is a `name` column

        // Fetch all Timezone from the `timezone` table
        $timezones = Timezone::where('status', 1)->get();
        
        // Pass the setting (or null) to the form view.
        return view('vendor.settings.form', compact('setting', 'countries', 'timezones'));
    }
    
    public function socialmedia(Request $request){

        // For this example, we assume it comes via the request or is defined.
        $vendor_id = Auth::id();
        
        // Retrieve the setting record for this vendor (if exists)
        $setting = Setting::where('vendor_id', $vendor_id)->first();
        
        // Pass the setting (or null) to the form view.
        return view('vendor.settings.socialmedia', compact('setting'));
    }


    public function saveOrUpdate(Request $request)
    {   
        // Remove spaces from store_contact
        $request->merge([
            'store_contact' => preg_replace('/\s+/', '', $request->store_contact)
        ]);
    
        // Validate input data.
        $validator = Validator::make($request->all(), [
            'store_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'store_name'    => 'required|string|max:255',
            'country'       => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'store_address' => 'required|string|max:255',
            'store_lat'     => 'nullable|numeric',
            'store_long'    => 'nullable|numeric',
            'dine_in'       => 'required|integer|in:1,2',
            'store_email'   => 'nullable|email',
            'country_code'  => 'required|string|max:5', // e.g., +91, +1, +971
            'store_contact' => 'required|numeric|digits_between:5,15',
            'opening_time'  => 'required|date_format:H:i',
            'closing_time'  => 'required|date_format:H:i|after:opening_time',
            'timezone'      => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->all(),
            ]);
        }
    
        $vendor_id = Auth::id();
    
        // Retrieve the existing setting or create a new one
        $setting = Setting::firstOrNew(['vendor_id' => $vendor_id]);
    
        // Handle file upload for store_logo
        if ($request->hasFile('store_logo')) {
            $currentYear = Carbon::now()->year;
            $directory = public_path("uploads/vendor_profile/{$currentYear}");
    
            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
    
            // Generate a unique file name
            $imageName = time() . '_' . $request->file('store_logo')->getClientOriginalName();
            $imagePath = "uploads/vendor_profile/{$currentYear}/{$imageName}";
    
            // Move the uploaded file
            $request->file('store_logo')->move($directory, $imageName);
    
            // Assign image path to the setting model
            $setting->store_logo = $imagePath;
        }
    
        // Assign other form fields
        $setting->store_name    = $request->store_name;
        $setting->country       = $request->country;
        $setting->state         = $request->state;
        $setting->city          = $request->city;
        $setting->store_address = $request->store_address;
        $setting->store_lat     = $request->store_lat;
        $setting->store_long    = $request->store_long;
        $setting->dine_in       = $request->dine_in;
        $setting->store_email   = $request->store_email;
        $setting->country_code  = $request->country_code;
        $setting->store_contact = $request->store_contact;
        $setting->opening_time  = $request->opening_time;
        $setting->closing_time  = $request->closing_time;
        $setting->timezone  = $request->timezone;
    
        // Save the settings
        $setting->save();

        if(!empty($request->timezone)){
            $time_zone = Timezone::where('status', 1)->where('id', $request->timezone)->first();
            if(!empty($time_zone) && !empty($time_zone->timezone)){
                session()->put('time_zone', $time_zone->timezone);
            }
        }
    
        return response()->json([
            'status'  => 1,
            'message' => $setting->wasRecentlyCreated ? 'Setting saved successfully.' : 'Setting updated successfully.',
        ]);
    }
    
    public function saveOrUpdateSocialMedia(Request $request)
    {   
        
    
        $vendor_id = Auth::id();
    
        // Retrieve the existing setting or create a new one
        $setting = Setting::firstOrNew(['vendor_id' => $vendor_id]);

        $setting->facebook    = $request->facebook;
        $setting->instagram       = $request->instagram;
        $setting->twitter         = $request->twitter;
    
        // Save the settings
        $setting->save();
    
        return response()->json([
            'status'  => 1,
            'message' => $setting->wasRecentlyCreated ? 'Setting saved successfully.' : 'Setting updated successfully.',
        ]);
    }


    /**
     * Show the menu customization page.
     */
    public function customizeQrcode()
    {
        return view('vendor.settings.customizeqrcode', [
            'qrCode' => \QrCode::size(150)->generate(url('/menu-items/' . Auth::user()->code))
        ]);
    }
    
    public function getStatesByCountryName(Request $request)
    {
        $country = Country::where('name', $request->country_name)->first();

        if ($country) {
            $states = State::where('country_id', $country->id)->orderBy('name', 'asc')->get();
            return response()->json($states);
        } else {
            return response()->json([]);
        }
    }
    
    public function changepassword()
    {
        return view('vendor.settings.change-password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $vendor = Auth::guard('vendor')->user(); // Get logged-in vendor

        // Check if the current password matches
        if (!Hash::check($request->current_password, $vendor->password)) {
            return response()->json(['status' => 0, 'message' => 'Current password is incorrect.'], 422);
        }

        // Update the password
        $vendor->password = Hash::make($request->new_password);
        $vendor->save();

        return response()->json(['status' => 1, 'message' => 'Password updated successfully!']);
    }

    public function updateProfile(Request $request)
    {
     
        $vendorId = Auth::id(); // Assuming vendor is authenticated
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendorId,
            'contact_number' => 'required|string|max:15|min:10',
            'owner_name' => 'required|string|max:255',
            // 'address' => 'required|string|max:1000',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL);
        $contact_number = filter_var(trim($request->input('contact_number')), FILTER_SANITIZE_STRING);
        $owner_name = filter_var(trim($request->input('owner_name')), FILTER_SANITIZE_STRING);
        // $address = filter_var(trim($request->input('address')), FILTER_SANITIZE_STRING);
        // $password = $request->input('password'); // Password input

        // $password = Hash::make($password);

        // Remove HTML tags for safety
        $name = strip_tags($name);
        $email = strip_tags($email);
        $contact_number = strip_tags($contact_number);
        $owner_name = strip_tags($owner_name);
        // $address = strip_tags($address);

        // Create a new vendor and assign sanitized data
        $vendor = Auth::guard('vendor')->user(); // Get logged-in vendor

        $vendor->name = $name;
        $vendor->email = $email;
        // $vendor->password = $password;
        $vendor->contact_number = $contact_number;
        $vendor->owner_name = $owner_name;
        // $vendor->address = $address;

        if($vendor->save()){
            return response()->json(['status' => 1, 'message' => 'Vendor Profile updated successfully!']);
        }else{
            return response()->json(['status' => 2, 'message' => 'Failed to update Vendor Profile, please try again later...']);
        }
    }
}
