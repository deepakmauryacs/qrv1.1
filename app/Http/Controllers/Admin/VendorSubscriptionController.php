<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorsSubscription;
use Illuminate\Http\Request;

class VendorSubscriptionController extends Controller
{
    /**
     * Store a newly created subscription for a vendor.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        // Set the month to 3
        $month = 3;

        // Set the start date to today's date
        $startDate = now();

        // Set the end date to 3 months from today
        $endDate = now()->addMonths(3);

        // Check if the vendor already has an active subscription
        $existingSubscription = VendorsSubscription::where('vendor_id', $request->vendor_id)
                                                    ->where('is_expired', 1)  // Check if there's an active subscription
                                                    ->first();

        // If there's an active subscription, expire it first
        if ($existingSubscription) {
            // Mark the existing subscription as expired
            $existingSubscription->update([
                'is_expired' => 2,  // Set the old subscription to expired
                'end_date' => now(),  // Set the end date to now (expired)
            ]);
        }

        // Create a new subscription for the vendor
        $subscription = VendorsSubscription::create([
            'vendor_id' => $request->vendor_id,
            'subscription_id' => $request->subscription_id,
            'month' => $month,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_expired' => 1,  // New subscription is not expired
        ]);

        // Return a response
        return response()->json([
            'status' => 1,
            'message' => 'Subscription added successfully!',
            'data' => $subscription  // Optionally, return the created subscription data
        ]);
    }


}
