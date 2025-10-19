<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor\MenuRequest;
use App\Models\Vendor\MenuRequestDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class VendorMenuRequestController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        return view('admin.menu-request.index');
    }
    public function getMenuRequestData(Request $request)
    {
        $menuRequests = MenuRequest::with('documents')
                                ->select("menu_requests.*", "vendors.name as vendor_name")
                                ->join("vendors", "vendors.id", "=", "menu_requests.vendor_id")
                                ->orderBy("menu_requests.id", "desc")
                                ->get();

        return datatables()->of($menuRequests)
            ->addIndexColumn()
            ->editColumn('created_at', function($menuRequest) {
                // Format date
                return $menuRequest->created_at->format('d/m/Y');
            })
            ->editColumn('status', function($menuRequest) {
                // Format date
                // return array(1=>"Request Sent", 2=>"Request Updated", 3=>"Request Rejected")[$menuRequest->status];
                return '<span class="ticket-status" data-status="'.$menuRequest->status.'" data-id="'.$menuRequest->id.'">'.array(1=>"Request Sent", 2=>"Request Updated", 3=>"Request Rejected")[$menuRequest->status].'</span>';
            })
            ->addColumn('documents', function($menuRequest) {
                if ($menuRequest->documents->isEmpty()) {
                    return '<span class="text-muted">No Files</span>';
                }

                $links = '';
                foreach ($menuRequest->documents as $doc) {
                    $links .= '<a href="' . asset($doc->document) . '" target="_blank" class="badge bg-primary1 me-1">View</a>';
                }
                return $links;
            })
            ->rawColumns(['documents', 'status']) // Required to render HTML
            /*->addColumn('action', function($ticket) {
                $editUrl = route('vendor.tickets.edit', $ticket->id);
                $deleteUrl = route('vendor.tickets.destroy', $ticket->id);
                return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['action'])*/
            ->make(true);
    }

    public function updateMenuRequestStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1,2,3'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        $id = filter_var($request->input('id'), FILTER_SANITIZE_STRING);
        $status = filter_var($request->input('status'), FILTER_SANITIZE_STRING);

        // Find the existing menu item by ID
        $menuRequest = MenuRequest::findOrFail($id);
        $menuRequest->status = $status;
        $menuRequest->save(); // Save the updated menu item
        if($menuRequest->save()){
            return response()->json(['status' => 1, 'message' => 'Vendor menu request updated successfully!']);
        }else{
            return response()->json(['status' => 2, 'message' => 'Failed to updated Vendor menu request, Please try again later']);
        }
    }
}
