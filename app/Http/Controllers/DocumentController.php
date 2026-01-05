<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function showCodeForm()
    {
        return view('welcome');
    }

    public function enterCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:4'],
        ]);

        $code = $request->input('code');

        $user = User::firstOrCreate(['user_code' => $code]);

        Document::firstOrCreate(
            ['user_id' => $user->id],
            ['content' => '', 'google_doc_id' => null]
        );

        return redirect()->route('dashboard', ['code' => $code]);
    }

    public function dashboard(string $code)
    {
        $user = User::where('user_code', $code)->firstOrFail();
        $document = Document::where('user_id', $user->id)->firstOrFail();

        return view('dashboard', compact('user', 'document'));
    }

    public function update(Request $request, string $code)
    {
        $request->validate([
            'content' => ['nullable', 'string'],
        ]);

        $user = User::where('user_code', $code)->firstOrFail();
        $document = Document::where('user_id', $user->id)->firstOrFail();

        $document->update([
            'content' => $request->input('content', ''),
        ]);

        return redirect()->route('dashboard', ['code' => $code])
            ->with('status', 'Document saved.');
    }

    public function destroy(string $code)
    {
        $user = User::where('user_code', $code)->firstOrFail();

        $user->delete();

        return redirect()->route('code.form')->with('status', 'Workspace deleted.');
    }
}
