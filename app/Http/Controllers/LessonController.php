<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\GoogleCalendarService;
use App\Events\LessonCreated;
use App\Events\LessonDeleted;
use App\Events\LessonUpdated;


class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::where('user_id', auth()->id())->get();
        return $lessons; //view('lessons.index', compact('lessons'));
    }

    public function create(Student $student)
    {
        $userSubjects = auth()->user()->subjects;
        return view('lessons.create', compact('student', 'userSubjects'));
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
        $lesson->subject_id = $request->subject_id ?? null;
        $lesson->giorno = $request->giorno;
        $lesson->ora_inizio = $request->ora_inizio;
        $lesson->ora_fine = $request->ora_fine;
        $lesson->luogo = $request->luogo;
        $lesson->argomento = $request->argomento;

        $lesson->save();

        event(new LessonCreated($lesson));

        return redirect()->route('students.show', $student)
                        ->with('success', 'Lezione aggiunta!');
    }


    public function show(Lesson $lesson)
    {
        //$this->authorize('view', $lesson);
        $lesson->load('subject');
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
        $userSubjects = auth()->user()->subjects;
        return view('lessons.edit', compact('lesson', 'userSubjects'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($request->all());

        event(new LessonUpdated($lesson));

        return redirect()->route('lessons.show', $lesson)->with('success', 'Lezione aggiornata');
    }

    public function destroy(Lesson $lesson)
    {
        //$this->authorize('delete', $lesson);

        $student = $lesson->student;

        event(new LessonDeleted($lesson));

        $lesson->delete();

        

        return redirect()->route('students.show', $student)->with('success', 'Lezione eliminata');
    }
}
