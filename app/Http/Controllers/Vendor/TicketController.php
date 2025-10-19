<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor\Ticket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        $tickets = Ticket::all();
        return view('vendor.ticket.index', compact('tickets'));
    }
    public function getTicketData(Request $request)
    {
        $tickets = Ticket::where("vendor_id", Auth::id())->orderBy("id", "desc")->get();

        return datatables()->of($tickets)
            ->addIndexColumn()
            ->editColumn('created_at', function($ticket) {
                // Format date
                return $ticket->created_at->format('d/m/Y');
            })
            ->editColumn('status', function($ticket) {
                // Format date
                return array(1=>"Ticket Generated", 2=>"Ticket Resolving", 3=>"Ticket Closed")[$ticket->status];
            })
            ->editColumn('document', function($ticket) {
                // Format date
                if(empty($ticket->document)){
                    return "No File";
                }
                return '<a href="' . asset($ticket->document) . '" target="_blank" class="badge bg-primary1 me-1">View</a>';
            })
            ->addColumn('action', function($ticket) {
                $deleteUrl = route('vendor.tickets.destroy', $ticket->id);
                return '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            
            ->rawColumns(['document', 'action'])
            ->make(true);
    }
    public function create()
    {
        return view('vendor.ticket.create');
    }

    // Store a new category
    public function store(Request $request)
    {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|string|min:5|max:15|regex:/^[0-9]+$/',
            'message' => 'required|string|max:1000',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return JSON with validation errors
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        try {
            // Sanitize the input data
            $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
            $email = filter_var(trim($request->input('email')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
            $mobile = filter_var(trim($request->input('mobile')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
            $message = filter_var(trim($request->input('message')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters

            // If you want to remove HTML tags, you can use:
            $name = strip_tags($name);
            $email = strip_tags($email);
            $mobile = strip_tags($mobile);
            $message = strip_tags($message);

            $vendor_id = Auth::id();

            // Create a new category and assign sanitized data
            $category = new Ticket();
            $category->vendor_id = $vendor_id;
            $category->ticket_id = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            
            $category->name = $name;
            $category->email = $email;
            $category->mobile = $mobile;
            $category->message = $message;
            if ($request->hasFile('document')) {
                // Get the current year
                $currentYear = Carbon::now()->year;

                // Create the target directory for the current year
                $directory = public_path('uploads/ticket/' . $currentYear);

                // Ensure the directory exists
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true); // Create the directory if it doesn't exist
                }

                // Move the uploaded file to the desired directory
                $imagePath = $request->file('document')->move($directory, $request->file('document')->getClientOriginalName());

                // Store the relative path to the database
                $imagePath = 'uploads/ticket/' . $currentYear . '/' . $request->file('document')->getClientOriginalName();
                $category->document = $imagePath;
            }
            $category->save();

            // here send notification to admin
            return response()->json(['status' => 1, 'message' => 'Ticket generated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to generate Ticket']);
        }
    }
    
    public function destroy($id)
    {
        // Find the ticket item by its ID
        $ticket = Ticket::findOrFail($id);

        // Delete the ticket item
        $ticket->delete();

        // Return a success response
        return response()->json([
            'status' => 1,
            'message' => 'Ticket deleted successfully!'
        ]);
    }
}
