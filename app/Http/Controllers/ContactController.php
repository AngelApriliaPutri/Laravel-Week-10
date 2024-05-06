<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ContactController extends Controller
{
    private function data()
    {
        if (!Cookie::has('contact'))
        {
            return [];
        }

        // Terima as JSON
        $data = Cookie::get('contact');
        $data = \json_decode($data);
        return $data;
    }

    public function View()
    {
        return \view('contact');
    }

    public function ActionContact(Request $request)
    {
        $data = $this->data();

        // Generate a unique ID for the new contact
        $newId = uniqid();

        $d = [
            "id" => $newId,
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "message" => $request->input('message'),
        ];

        $data[] = $d;

        $data = \json_encode($data);
        $c = Cookie::make("contact", $data, 60*24*30);
        Cookie::queue($c);

        // Redirect to the ContactList page after saving the data
        return redirect()->route('contact_list');
    }

    public function ContactList(Request $request)
    {
        $contacts = $this->data();

        return view('contact_list', compact('contacts'));
    }

    public function deleteContact($id)
    {
        $contacts = $this->data();
        $new = [];

        // Find the contact with the specified ID and remove it
        foreach ($contacts as $contact) {
            // Check if 'id' property exists before comparing
            if (isset($contact->id) && $contact->id != $id) {
                $new[] = $contact;
            }
        }
    
        // Save the data after deletion
        $data = \json_encode($new);
        $c = Cookie::make("contact", $data, 60*24*30);
        Cookie::queue($c);

        // Redirect back to the ContactList page
        return redirect()->route('contact_list');
    }


}
