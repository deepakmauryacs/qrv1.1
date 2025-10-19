<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor\VendorInvoice;
use App\Models\Vendor\VendorInvoiceItem;
use App\Models\VendorMenu;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        return view('vendor.invoice.index');
    }
    public function getVendorInvoiceData(Request $request)
    {
        $menuRequests = VendorInvoice::where("vendor_id", Auth::id())->orderBy("id", "desc")->get();

        return datatables()->of($menuRequests)
            ->addIndexColumn()
            ->editColumn('created_at', function($menuRequest) {
                // Format date
                return $menuRequest->created_at->format('d/m/Y');
            })
            ->addColumn('action', function ($row) {
                $deleteUrl = route('vendor.invoice.destroy', $row->id);
                return '<a href="'.route('vendor.invoice.print-pos-invoice', $row->invoice_id).'" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-printer"></i> 80MM </a>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')" ><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getVendorMenuItem(Request $request)
    {
        $item_search = filter_var(trim($request->input('item_search')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
        $item_search = strip_tags($item_search);

        if(empty($item_search)){
            return response()->json(['status' => 2, 'items' => array()]);
        }

        $vendorMenu = VendorMenu::select('id', 'name', 'price_half', 'price_full')
                            ->where('vendor_id', Auth::id())
                            ->where('name', 'LIKE', "%$item_search%")
                            ->get();

        return response()->json(['status' => 1, 'items' => $vendorMenu]);        
    }
    public function create()
    {
        $vendorMenu = VendorMenu::select('id', 'name', 'price_half', 'price_full')
                            ->where('vendor_id', Auth::id())
                            ->get();

        return view('vendor.invoice.create-dropdown', compact('vendorMenu'));
    }
    /*public function print_a4_size(Request $request, $invoice_id)
    {
        $invoice = VendorInvoice::with("items")->where("vendor_id", Auth::id())->where("invoice_id", $invoice_id)->get();
        if(count($invoice)==0){
            return redirect(route('vendor.invoice.index'));
        }
        // echo "<pre>";
        // print_r($invoice);die;
        return view('vendor.invoice.print-a4-size', compact('invoice'));
    }*/

    public function posInvoice(Request $request, $invoice_id)
    {
        $invoice = VendorInvoice::with("items")->where("vendor_id", Auth::id())->where("invoice_id", $invoice_id)->first();
        if(empty($invoice)){
            return redirect(route('vendor.invoice.index'));
        }
        $profile = Setting::where(['vendor_id' => Auth::id()])->first();
        
        return view('vendor.invoice.pos-invoice', compact('invoice', 'profile'));
    }

    // Store a new category
    public function store(Request $request)
    {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|max:255',
            'mobile' => 'required|string|min:5|max:15|regex:/^[0-9]+$/',
            // 'message' => 'required|string|max:1000',
            'item' => 'required',
            'qty' => 'required',
            'price' => 'required',
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
            $item = $request->input('item');
            $item_id = $request->input('item_id');
            $qty = $request->input('qty');
            $type = $request->input('type');
            $price = $request->input('price');
            $discount = filter_var(trim($request->input('discount')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
            $tax = filter_var(trim($request->input('tax')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters

            // If you want to remove HTML tags, you can use:
            $name = strip_tags($name);
            $email = strip_tags($email);
            $mobile = strip_tags($mobile);
            $message = strip_tags($message);
            // $item = strip_tags($item);
            // $item_id = strip_tags($item_id);
            // $qty = strip_tags($qty);
            // $type = strip_tags($type);
            // $price = strip_tags($price);
            $discount = strip_tags($discount);
            $tax = strip_tags($tax);

            if(empty($discount)){
                $discount = 0.00;
            }
            if(empty($tax)){
                $tax = 0.00;
            }

            $vendor_id = Auth::id();

            $invoice_id = $this->generateInvoiceId();
            // print_r($invoice_id);die;

            // Create a new category and assign sanitized data
            $vendorInvoice = new VendorInvoice();
            $vendorInvoice->vendor_id = $vendor_id;
            $vendorInvoice->invoice_id = $invoice_id;
            
            $vendorInvoice->name = $name;
            $vendorInvoice->email = $email;
            $vendorInvoice->mobile = $mobile;
            $vendorInvoice->message = $message;
            $vendorInvoice->discount = $discount;
            $vendorInvoice->tax = $tax;
            $vendorInvoice->total_amount = 0;
            
            if($vendorInvoice->save()){
                $batch_item = array();
                $subTotal = 0;
                foreach ($item as $key => $value) {
                    $batch_item[] = array(
                        'invoice_id'=>$invoice_id,
                        'item_id'=>$item_id[$key],
                        'item_name'=>$item[$key],
                        'type'=>$type[$key],
                        'price'=>$price[$key],
                        'quantity'=>$qty[$key]
                    );
                    $subTotal += $price[$key] * $qty[$key];
                }
                if(count($batch_item)>0){
                    VendorInvoiceItem::insert($batch_item);

                    // Calculate Discount Amount
                    $discountAmount = 0;
                    if($discount){
                        $discountAmount = ($subTotal * $discount) / 100;
                    }

                    // Calculate Grand Total
                    $grandDiscountTotal = $subTotal - $discountAmount;

                    // Calculate GST Amount
                    $gstAmount = 0;
                    if($tax){
                        $gstAmount = ($grandDiscountTotal * $tax) / 100;
                    }
                    $grandTotal = $grandDiscountTotal + $gstAmount;

                    VendorInvoice::where("invoice_id", $invoice_id)->where("vendor_id", $vendor_id)->update(['total_amount'=>$grandTotal]);
                }
            }

            return response()->json(['status' => 1, 'message' => 'Invoice created successfully', 'print_url'=> route('vendor.invoice.print-pos-invoice', $invoice_id)]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to create Invoice']);
        }
    }

    private function generateInvoiceId()
    {
        $length = 12;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);

        // $lastInvoice = VendorInvoice::where('vendor_id', Auth::id())->max('invoice_id'); // Get last invoice ID

        // if ($lastInvoice) {
        //     $nextInvoiceId = str_pad($lastInvoice + 1, 8, '0', STR_PAD_LEFT); // Format to 8 digits
        // } else {
        //     $nextInvoiceId = '00000001'; // First invoice
        // }
        // return $nextInvoiceId;
    }

    public function destroy($id)
    {
        // Find the invoice item by its ID
        $invoice = VendorInvoice::with("items")->findOrFail($id);
        
        // First delete all related items
        $invoice->items()->delete();

        // Delete the invoice item
        $invoice->delete();

        // Return a success response
        return response()->json([
            'status' => 1,
            'message' => 'Invoice deleted successfully!'
        ]);
    }
}
