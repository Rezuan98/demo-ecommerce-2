<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {

        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        try {
            Message::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    // Admin methods for managing messages
    public function index()
    {
        $message = Message::latest()->get();
        return view('back-end.message.index', compact('message'));
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('back-end.message.show_message', compact('message'));
    }

    public function destroy($id)
    {
        try {
            Message::findOrFail($id)->delete();
            return redirect()->route('messages.index')
                           ->with('success', 'Message deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete message');
        }
    }
}