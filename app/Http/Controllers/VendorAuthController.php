<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\VendorMenu;
use App\Models\QRScan;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Setting;


use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VendorAuthController extends Controller
{
    public function showLoginForm()
    {   
        if (Auth::guard('vendor')->check()) {
           return redirect()->route('vendor.dashboard');
        }
        return view('vendor.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if 'remember' is selected

        if (Auth::guard('vendor')->attempt($credentials, $remember)) {
            $time_zone_data = Setting::select('settings.timezone as timz_zone_id', 'timezones.timezone as time_zone_name')
                                ->where(['vendor_id' => Auth::id()])
                                ->join("timezones", "timezones.id", "=", "settings.timezone")
                                ->first();

            if(isset($time_zone_data->timz_zone_id) && !empty($time_zone_data->time_zone_name)){
                $timezone = $time_zone_data->time_zone_name;
            }else{
                $timezone = "Asia/Kolkata";
            }
            session([
                'time_zone' => $timezone,
            ]);
            
            return redirect()->route('vendor.dashboard'); // Redirect to admin dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // public function dashboard()
    // {   

    //     return view('vendor.dashboard');
    // }

   


    public function dashboard()
    {
     
        $vendorId = Auth::id(); // Assuming vendor is authenticated
        // Count Total Menu Items for the Vendor
        $totalMenuItems = VendorMenu::where('vendor_id', $vendorId)->count();

        // Count QR Scans for Today
        $qrScansToday = QRScan::where('vendor_id', $vendorId)
            ->whereDate('scanned_at', Carbon::today())
            ->count(); 

        // Count All-Time QR Scans
        $totalQrScans = QRScan::where('vendor_id', $vendorId)->count();
        
         // Count All-Time Total Feedback
        $totalFeedback = Feedback::where('vendor_id', $vendorId)->count();

        // Get QR scans for the last 7 days
        $qrScans = QRScan::select(
                DB::raw("DATE_FORMAT(scanned_at, '%a') as day"), // Get short day names (e.g., Sun, Mon)
                DB::raw('COUNT(*) as scan_count')
            )
            ->where('vendor_id', $vendorId)
            ->whereBetween('scanned_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->groupBy('day')
            ->orderByRaw("FIELD(day, 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')")
            ->get();

        // Prepare data for Chart.js
        $days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $scanData = array_fill(0, 7, 0); // Initialize with zeros

        foreach ($qrScans as $scan) {
            $index = array_search($scan->day, $days);
            if ($index !== false) {
                $scanData[$index] = $scan->scan_count;
            }
        }

        return view('vendor.dashboard', compact('totalMenuItems', 'qrScansToday', 'totalQrScans','totalFeedback','days', 'scanData'));
    }


    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }
}
