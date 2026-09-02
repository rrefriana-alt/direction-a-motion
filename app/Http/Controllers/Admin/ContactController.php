<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('order')->get();
        return view('admin.contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'icon_class' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'display_text' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);
        Contact::create($request->all());
        return redirect()->route('admin.contact.index')->with('success', 'Contact berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'icon_class' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'display_text' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('admin.contact.index')->with('success', 'Contact berhasil diupdate!');
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contact.index')->with('success', 'Contact berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['is_active' => !$contact->is_active]);
        return response()->json(['success' => true, 'is_active' => $contact->is_active]);
    }

    public function messagesIndex()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('admin.contact.messages.index', compact('messages'));
    }

    public function messageDestroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->route('admin.contact.messages.index')->with('success', 'Pesan berhasil dihapus!');
    }

    public function messageToggleRead($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => !$message->is_read]);
        return response()->json(['success' => true, 'is_read' => $message->is_read]);
    }
}
