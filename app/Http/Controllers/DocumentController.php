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
        // Validate code input
        $request->validate([
            'code' => ['required', 'digits:4'],
        ]);

        $code = $request->input('code');

        $user = User::firstOrCreate(['user_code' => $code]);

        // Ensure document exists for user
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

        // Update document fields
        $document->update([
            'content' => $request->input('content', ''),
            'chapter' => $request->input('chapter'),
            'subtitle' => $request->input('subtitle'),
            
        ]);

        return redirect()->route('dashboard', ['code' => $code])
            ->with('status', 'Document saved.');
    }

    // Destroy
    public function destroy(string $code)
    {
        $user = User::where('user_code', $code)->firstOrFail();

        $user->delete();

        return redirect()->route('code.form')->with('status', 'Workspace deleted.');
    }
}
