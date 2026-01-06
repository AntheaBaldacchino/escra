<?php

namespace App\Http\Controllers;

use App\Models\SavedIdea;
use App\Models\User;
use Illuminate\Http\Request;

class SavedIdeaController extends Controller
{
        public function index(string $code)
    {
        $user = User::where('user_code', $code)->firstOrFail();
        $ideas = SavedIdea::where('user_id', $user->id)->latest()->get();

        return view('saved-ideas', compact('user', 'ideas'));
    }

    public function store(Request $request, string $code)
    {
        $request->validate([
            'idea_text' => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('user_code', $code)->firstOrFail();

        SavedIdea::create([
            'user_id' => $user->id,
            'idea_text' => $request->idea_text,
        ]);

        return redirect()->route('ideas.index', ['code' => $code])
            ->with('status', 'Idea saved.');
    }

    public function update(Request $request, string $code, SavedIdea $idea)
    {
        $request->validate([
            'idea_text' => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('user_code', $code)->firstOrFail();

        // simple ownership check
        abort_unless($idea->user_id === $user->id, 403);

        $idea->update(['idea_text' => $request->idea_text]);

        return redirect()->route('ideas.index', ['code' => $code])
            ->with('status', 'Idea updated.');
    }

    public function destroy(string $code, SavedIdea $idea)
    {
        $user = User::where('user_code', $code)->firstOrFail();
        abort_unless($idea->user_id === $user->id, 403);

        $idea->delete();

        return redirect()->route('ideas.index', ['code' => $code])
            ->with('status', 'Idea deleted.');
    }
}
