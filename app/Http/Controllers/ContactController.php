<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\Contact\StoreContactRequest;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contacts = Contact::all();
        return response()->json([
        'status' => "list of message",
        'contacts' => $contacts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        //
        try {

            $request->validated();

            $contact = Contact::create([
                'name'=>$request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

              return response()->json([
                'status'=>'send Information ',
                'contact' => $contact,
              ]);



        }
        catch(Throwable $th)
        {
            Log::debug($th);
            $e = Log::error($th->getMessage());

            return response()->json([
                'status' => 'error',
            ]);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $contact=contact::find($id);
        return response()->json([
            'status'=>'Show',
            'contact' =>$contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $contact=Contact::find($id);
        $contact->delete();
        return response()->json([

            'status' => 'delete'
        ]);
    }
}
