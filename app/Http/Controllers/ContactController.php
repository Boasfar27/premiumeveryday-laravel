<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ContactController extends Controller
{
    public function index()
    {
        $agent = new Agent();
        $contacts = Contact::active()->get();
        
        return view(
            $agent->isMobile() ? 'pages.mobile.contact.index' : 'pages.desktop.contact.index',
            compact('contacts')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
} 