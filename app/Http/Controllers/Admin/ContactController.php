<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(string $locale)
    {
        $contacts = Contact::orderBy('order')->get();
        return view('admin.contact.index', compact('contacts', 'locale'));
    }

    public function store(Request $request, string $locale)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'icon_class' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'display_text' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);
        Contact::create($request->all());
        return redirect()->route('admin.contact.index', ['locale' => $locale])->with('success', 'Contact berhasil dibuat!');
    }

    public function update(Request $request, string $locale, $id)
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
        return redirect()->route('admin.contact.index', ['locale' => $locale])->with('success', 'Contact berhasil diupdate!');
    }

    public function destroy(string $locale, $id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contact.index', ['locale' => $locale])->with('success', 'Contact berhasil dihapus!');
    }

    public function toggleActive(string $locale, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['is_active' => !$contact->is_active]);
        return response()->json(['success' => true, 'is_active' => $contact->is_active]);
    }

    public function messagesIndex(string $locale)
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('admin.contact.messages.index', compact('messages', 'locale'));
    }

    public function messageDestroy(string $locale, $id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->route('admin.contact.messages.index', ['locale' => $locale])->with('success', 'Pesan berhasil dihapus!');
    }

    public function messageToggleRead(string $locale, $id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => !$message->is_read]);
        return response()->json(['success' => true, 'is_read' => $message->is_read]);
    }
}
