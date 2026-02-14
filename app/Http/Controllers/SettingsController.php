<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $allSubjects = Subject::all();
        $userSubjects = auth()->user()->subjects()->pluck('subjects.id')->toArray();

        return view('settings', compact('allSubjects', 'userSubjects'));
    }

    public function updateSubjects(Request $request)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        auth()->user()->subjects()->sync($request->subjects ?? []);

        return redirect()->back()->with('success', 'Materie aggiornate con successo.');
    }
}
