<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Lista studenti
    public function index()
    {
        $students = Auth::user()->students()->get(); // solo studenti del tutor loggato
        return view('students.index', compact('students'));
    }


    public function show(Student $student)
    {
        // Restituisce la vista con il singolo studente
        return view('students.show', compact('student'));
    }

    // Form per creare
    public function create()
    {
        return view('students.create');
    }

    // Salva nuovo studente
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
        ]);

        Auth::user()->students()->create($request->all());

        return redirect()->route('students.index')->with('success', 'Studente creato con successo.');
    }

    // Form per modificare
    public function edit(Student $student)
    {
        //$this->authorize('update', $student); // opzionale se vuoi policy
        return view('students.edit', compact('student'));
    }

    // Aggiorna studente
    public function update(Request $request, Student $student)
    {
/*         $this->authorize('update', $student); // opzionale
 */        $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
        ]);

        $student->update($request->all());

        return view('students.show', compact('student'))->with('success', 'Studente aggiornato con successo.');
    }

    // Elimina studente
    public function destroy(Student $student)
    {
        //$this->authorize('delete', $student); // opzionale
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Studente eliminato.');
    }
}
