<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Ticket;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        // $tickets = Ticket::all();
        return view('admin.ticket.index');
    }
    public function getTicketData(Request $request)
    {
        $tickets = Ticket::select("tickets.*", "vendors.name as vendor_name")
                        ->join("vendors", "vendors.id", "=", "tickets.vendor_id")
                        ->orderBy("tickets.id", "desc")
                        ->get();

        return datatables()->of($tickets)
            ->addIndexColumn()
            ->editColumn('created_at', function($ticket) {
                // Format date
                return $ticket->created_at->format('d/m/Y');
            })
            ->editColumn('status', function($ticket) {
                // Format date
                return '<span class="ticket-status" data-status="'.$ticket->status.'" data-id="'.$ticket->id.'">'.array(1=>"Ticket Generated", 2=>"Ticket Resolving", 3=>"Ticket Closed")[$ticket->status].'</span>';
            })
            ->editColumn('document', function($ticket) {
                // Format date
                if(empty($ticket->document)){
                    return "No File";
                }
                return '<a href="' . asset($ticket->document) . '" target="_blank" class="badge bg-primary1 me-1">View</a>';
            })
            /*->addColumn('action', function($ticket) {
                $editUrl = route('vendor.tickets.edit', $ticket->id);
                $deleteUrl = route('vendor.tickets.destroy', $ticket->id);
                return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })*/
            ->rawColumns(['status', 'document'])
            ->make(true);
    }
    public function updateTicketStatus(Request $request) {
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
        $ticket = Ticket::findOrFail($id);
        $ticket->status = $status;
        $ticket->save(); // Save the updated menu item
        if($ticket->save()){
            return response()->json(['status' => 1, 'message' => 'Ticket status updated successfully!']);
        }else{
            return response()->json(['status' => 2, 'message' => 'Failed to updated Ticket status, Please try again later']);
        }
    }
}
