<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::where('user_id', auth()->id())->get();
        return view('lessons.index', compact('lessons'));
    }

    public function create(Student $student)
    {
        return view('lessons.create', compact('student'));
    }

    public function store(Request $request, Student $student)
    {
        $request->validate([
            'giorno' => 'required|date',
            'ora_inizio' => 'required|date_format:H:i',
            'ora_fine' => 'required|date_format:H:i|after:ora_inizio',
        ]);

        $lesson = new Lesson();
        $lesson->student_id = $student->id;
        $lesson->user_id = auth()->id();
        $lesson->giorno = $request->giorno;
        $lesson->ora_inizio = $request->ora_inizio;
        $lesson->ora_fine = $request->ora_fine;
        $lesson->luogo = $request->luogo;
        $lesson->argomento = $request->argomento;
        $lesson->materia = $request->materia ?? null; 

        $lesson->save(); 

        return redirect()->route('students.show', $student)
                        ->with('success', 'Lezione aggiunta!');
    }


    public function show(Lesson $lesson)
    {
        //$this->authorize('view', $lesson);
        return view('lessons.show', compact('lesson'));
    }

    public function showByDate(Request $request)
    {
        $date = $request->input('date'); // formato YYYY-MM-DD
        $userId = auth()->id();

        // Recupera le lezioni del giorno solo per l'utente loggato
        $lessons = Lesson::where('giorno', $date)
            ->where('user_id', $userId)
            ->get();

        // Restituisce JSON
        return response()->json([
            'date' => $date,
            'lessons' => $lessons
        ]);
    }


    public function edit(Lesson $lesson)
    {
        //$this->authorize('update', $lesson);
        return view('lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        //$this->authorize('update', $lesson);

        $lesson->update($request->all());

        return redirect()->route('lessons.show', $lesson)->with('success', 'Lezione aggiornata');
    }

    public function destroy(Lesson $lesson)
    {
        //$this->authorize('delete', $lesson);

        $student = $lesson->student;
        $lesson->delete();
        return redirect()->route('students.show', $student)->with('success', 'Lezione eliminata');
    }
}
