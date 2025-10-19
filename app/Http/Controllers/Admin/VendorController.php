<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Subscription;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VendorController extends Controller {

    public function index() {
        return view('admin.vendors.index');
    }

    public function getVendorsData_1(Request $request) {
        $vendors = Vendor::all();

        return datatables()->of($vendors)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $editUrl = route('admin.vendors.edit', $row->id);
                            $deleteUrl = route('admin.vendors.destroy', $row->id);
                            return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                        </form>';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function getVendorsData(Request $request)
    {
        $vendors = Vendor::all();  // Fetch all vendors
        $subscriptions = Subscription::all();  // Fetch all subscription plans

        return datatables()->of($vendors)
            ->addIndexColumn()
            ->addColumn('subscription_plan', function ($row) use ($subscriptions) {
                // Get the current active subscription for the vendor
                $currentSubscription = $row->subscriptions()->where('is_expired', 1)->first();  // Check for active subscription

                // Create the dropdown dynamically from subscriptions
                $dropdown = '<select class="form-control plan-dropdown" data-vendor-id="' . $row->id . '">
                                <option value="">Select Plan</option>';

                // Add subscription options to the dropdown
                foreach ($subscriptions as $subscription) {
                    // Set the selected attribute if the current subscription matches
                    $selected = ($currentSubscription && $currentSubscription->subscription_id == $subscription->id) ? 'selected' : '';
                    $dropdown .= '<option value="' . $subscription->id . '" ' . $selected . '>' . $subscription->plan_name . ' - ₹' . $subscription->amount . '</option>';
                }

                $dropdown .= '</select>';

                return $dropdown; // Return the dropdown to be rendered in this column
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.vendors.edit', $row->id);
                $deleteUrl = route('admin.vendors.destroy', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['action', 'subscription_plan'])  // Make both columns render the HTML
            ->make(true);
    }




    public function create() {
        return view('admin.vendors.create');
    }

    public function store(Request $request) {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
                    'code' => 'required|string|max:255|unique:vendors,code',
                    'name' => 'required|string|max:255',
                    'email' => 'nullable|email|unique:vendors,email',
                    'contact_number' => 'required|string|max:255',
                    'owner_name' => 'required|string|max:255',
                    'address' => 'nullable|string',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        // Sanitize input data
        $data = $request->only(['code', 'name', 'email', 'contact_number', 'owner_name', 'address', 'status']);

        // Create a new Vendor
        $vendor = new Vendor($data);
        $vendor->save();

        return response()->json(['status' => 1, 'message' => 'Vendor added successfully!']);
    }

    public function edit($id) {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'code' => 'required|string|max:255|unique:vendors,code,' . $id,
                    'name' => 'required|string|max:255',
                    'email' => 'nullable|email|unique:vendors,email,' . $id,
                    'contact_number' => 'required|string|max:255',
                    'owner_name' => 'required|string|max:255',
                    'address' => 'nullable|string',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        // Find the existing vendor
        $vendor = Vendor::findOrFail($id);

        // Sanitize input data
        $data = $request->only(['code', 'name', 'email', 'contact_number', 'owner_name', 'address', 'status']);

        // Update the vendor
        $vendor->update($data);

        return response()->json(['status' => 1, 'message' => 'Vendor updated successfully!']);
    }

    public function destroy($id) {
        // Delete vendor
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response()->json(['status' => 1, 'message' => 'Vendor deleted successfully!']);
    }

}
