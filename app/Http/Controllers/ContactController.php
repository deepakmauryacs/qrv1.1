<?php

namespace App\Http\Controllers;

// use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        // Save data using the save() method
        // $contact = new Contact();
        // $contact->name = $request->name;
        // $contact->email = $request->email;
        // $contact->message = $request->message;
        // $contact->save(); // Save to the database

        DB::table("contacts")->insert([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been received. We will get back to you soon!'
        ]);
    }
}
