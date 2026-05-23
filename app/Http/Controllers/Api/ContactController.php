<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Store a new contact message (Public)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'isRead' => false,
        ]);

        return response()->json([
            'success' => true,
            'data' => $contact
        ], 201);
    }

    /**
     * Display a listing of messages (Admin)
     */
    public function index(Request $request)
    {
        $contacts = Contact::orderBy('createdAt', 'desc')->get();

        return response()->json($contacts);
    }
}
