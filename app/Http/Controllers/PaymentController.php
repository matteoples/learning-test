<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Lista pagamenti
    public function index()
    {
        // Solo pagamenti dell’utente loggato
        $payments = Payment::where('user_id', Auth::id())
            ->with('student')
            ->get();

        return view('payments.index', compact('payments'));
    }

    // Mostra singolo pagamento
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    // Form per creare pagamento
    public function create(Student $student)
    {
        // Studenti del tutor → dropdown nella form
        return view('payments.create', compact('student'));
    }

    // Salva pagamento
    public function store(Request $request, Student $student)
    {
        //dd($request->all());

        $request->validate([
            'data' => 'required|date',
            'modalita' => 'required|string|max:255',
            'importo' => 'required|numeric|min:0',
            'numero_ore' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Assegna automaticamente l’utente loggato
        $payment = new Payment();
        $payment->student_id = $student->id;
        $payment->user_id = auth()->id();
        $payment->data = $request->data;
        $payment->modalita = $request->modalita;
        $payment->importo = $request->importo;
        $payment->numero_ore = $request->numero_ore;
        $payment->note = $request->note ?? null;

        $payment->save();

        return redirect()->route('students.show', $student)
                        ->with('success', 'Pagamento registrato!');
    }

    // Form per modificare pagamento
    public function edit(Payment $payment)
    {
        $students = Auth::user()->students()->get();

        return view('payments.edit', compact('payment', 'students'));
    }

    // Aggiorna pagamento
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'data' => 'required|date',
            'modalita' => 'required|string|max:255',
            'importo' => 'required|numeric|min:0',
            'numero_ore' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $payment->update($request->all());

        return view('payments.show', compact('payment'))
            ->with('success', 'Pagamento aggiornato con successo.');
    }

    // Elimina pagamento
    public function destroy(Payment $payment)
    {
        
        $student = $payment->student;
        $payment->delete();
        return redirect()->route('students.show', $student)->with('success', 'Pagamento eliminato');
    }
}
