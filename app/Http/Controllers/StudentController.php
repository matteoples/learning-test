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
        $student->load('lessons.subject');
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
            'tariffa_oraria' => 'required|numeric|min:0.01|max:999'
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
            'tariffa_oraria' => 'required|numeric|min:0.01|max:999'
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



    /**
     * Mostra il form di importazione
     */
    public function showImportForm()
    {
        return view('students.import');
    }

    /**
     * Importa uno studente completo da file JSON
     */
    public function importFromJson(Request $request)
    {
        $request->validate([
            'json_files'   => 'required',
            'json_files.*' => 'file|mimes:json,txt'
        ]);

        $files = $request->file('json_files');
        $userId = auth()->id();

        foreach ($files as $file) {

            $json = file_get_contents($file->getRealPath());
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['json_files' => 'File JSON non valido']);
            }

            if (!isset($data['studente']['nome'], $data['studente']['cognome'])) {
                return back()->withErrors(['json_files' => 'Struttura JSON non valida']);
            }

            // CREA / UPDATE STUDENTE
            $studente = Student::updateOrCreate(
                [
                    'nome'    => $data['studente']['nome'],
                    'cognome' => $data['studente']['cognome'],
                    'user_id' => $userId,
                ],
                [
                    'telefono'  => $data['studente']['telefono'] ?? null,
                    'tariffa_oraria'  => $data['studente']['tariffa_oraria'] ?? 0,
                    'classe'    => $data['studente']['classe'] ?? null,
                    'indirizzo' => $data['studente']['indirizzo'] ?? null,
                    'note'      => $data['studente']['note'] ?? null,
                ]
            );

            // LEZIONI
            if (!empty($data['lezioni'])) {
                foreach ($data['lezioni'] as $lezioneData) {
                    $studente->lessons()->updateOrCreate(
                        [
                            'user_id'    => $userId,
                            'giorno'     => $lezioneData['data'],
                            'ora_inizio' => $lezioneData['ora_inizio'],
                            'ora_fine'   => $lezioneData['ora_fine'],
                        ],
                        [
                            'materia'   => $lezioneData['materia'] ?? 'Non specificata',
                            'argomento' => $lezioneData['argomento'] ?? null,
                            'luogo'     => $lezioneData['luogo'] ?? 'online',
                        ]
                    );
                }
            }

            // PAGAMENTI
            if (!empty($data['pagamenti'])) {
                foreach ($data['pagamenti'] as $pagamentoData) {

                    $importo = str_replace(['.', ','], ['', '.'], $pagamentoData['importo']);

                    $studente->payments()->updateOrCreate(
                        [
                            'user_id' => $userId,
                            'data'    => $pagamentoData['data'],
                            'importo' => $importo,
                        ],
                        [
                            'modalita' => $pagamentoData['modalita'] ?? "Contanti", // <-- CORRETTO
                            'note'     => $pagamentoData['note'] ?? null,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('students.index')
            ->with('success', 'Importazione completata con successo!');
    }



}