<?php

namespace App\Http\Controllers\Vendor;

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

class MenuRequestController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        // $tickets = MenuRequest::all();
        return view('vendor.menu-request.index');
    }
    public function getMenuRequestData(Request $request)
    {
        $menuRequests = MenuRequest::with('documents')->where("vendor_id", Auth::id())->orderBy("id", "desc")->get();

        return datatables()->of($menuRequests)
            ->addIndexColumn()
            ->editColumn('created_at', function($menuRequest) {
                // Format date
                return $menuRequest->created_at->format('d/m/Y');
            })
            ->editColumn('status', function($menuRequest) {
                // Format date
                return array(1=>"Request Sent", 2=>"Request Updated", 3=>"Request Rejected")[$menuRequest->status];
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
            ->addColumn('action', function($menuRequest) {
                $deleteUrl = route('vendor.menu-request.destroy', $menuRequest->id);
                return '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['documents', 'action']) // Required to render HTML
            ->make(true);
    }
    public function create()
    {
        return view('vendor.menu-request.create');
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
            'documents' => 'required|array|max:5', // Ensure it's an array and max 10 files
            'documents.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:10240', // Validate each file
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
            $menuRequest = new MenuRequest();
            $menuRequest->vendor_id = $vendor_id;
            $menuRequest->request_id = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            
            $menuRequest->name = $name;
            $menuRequest->email = $email;
            $menuRequest->mobile = $mobile;
            $menuRequest->message = $message;
            
            if ($request->hasFile('documents')) {
                $currentYear = Carbon::now()->year;
                $directory = public_path('uploads/menu-request/' . $currentYear);

                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                foreach ($request->file('documents') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move($directory, $filename);
                    $filePath = 'uploads/menu-request/' . $currentYear . '/' . $filename;

                    // Save each document in the mapping table
                    MenuRequestDocument::create([
                        'request_id' => $menuRequest->request_id,
                        'vendor_id' => $vendor_id,
                        'document' => $filePath
                    ]);
                }
            }
            
            $menuRequest->save();

            // here send notification to admin
            return response()->json(['status' => 1, 'message' => 'Menu Request Sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to add Menu Request']);
        }
    }

    public function destroy($id)
    {
        // Find the menuRequest item by its ID
        $menuRequest = MenuRequest::with("documents")->findOrFail($id);
        
        // First delete all related items
        $menuRequest->documents()->delete();

        // Delete the menuRequest item
        $menuRequest->delete();

        // Return a success response
        return response()->json([
            'status' => 1,
            'message' => 'Menu Request deleted successfully!'
        ]);
    }
}
