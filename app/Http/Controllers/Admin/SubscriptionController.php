<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SubscriptionController extends Controller {

    public function index() {
        return view('admin.subscriptions.index');
    }

    public function getSubscriptionsData(Request $request) {
        $subscriptions = Subscription::all();

        return datatables()->of($subscriptions)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $editUrl = route('admin.subscriptions.edit', $row->id);
                            $deleteUrl = route('admin.subscriptions.destroy', $row->id);
                            return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                                    ';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function create() {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request) {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
                    'plan_name' => 'required|string|max:255',
                    'amount' => 'required|numeric',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        // Sanitize input data
        $plan_name = filter_var(trim($request->input('plan_name')), FILTER_SANITIZE_STRING);
        $amount = filter_var($request->input('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $status = filter_var($request->input('status'), FILTER_SANITIZE_NUMBER_INT);

        // Create a new Subscription item and assign sanitized data
        $subscription = new Subscription();
        $subscription->plan_name = $plan_name;
        $subscription->amount = $amount;
        $subscription->status = $status;

        $subscription->save();

        return response()->json(['status' => 1, 'message' => 'Subscription plan added successfully!']);
    }

    public function edit($id) {
        $subscription = Subscription::findOrFail($id);
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'plan_name' => 'required|string|max:255',
                    'amount' => 'required|numeric',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        // Find the existing subscription by ID
        $subscription = Subscription::findOrFail($id);

        // Sanitize input data
        $plan_name = filter_var(trim($request->input('plan_name')), FILTER_SANITIZE_STRING);
        $amount = filter_var($request->input('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $status = filter_var($request->input('status'), FILTER_SANITIZE_NUMBER_INT);

        // Update the existing Subscription item with sanitized data
        $subscription->plan_name = $plan_name;
        $subscription->amount = $amount;
        $subscription->status = $status;

        $subscription->save();

        return response()->json(['status' => 1, 'message' => 'Subscription plan updated successfully!']);
    }

    public function destroy($id) {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json(['status' => 1, 'message' => 'Subscription plan deleted successfully!']);
    }
}
