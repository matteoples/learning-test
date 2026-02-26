@extends('layouts.app')

@php
    $studentName = $lesson->student->getNomeCognome();
    $giorno = \Carbon\Carbon::parse($lesson->giorno)->format('Y-m-d');
    $oraInizio = \Carbon\Carbon::parse($lesson->ora_inizio)->format('H:i');
    $oraFine = \Carbon\Carbon::parse($lesson->ora_fine)->format('H:i');
    $luoghi = ['Online', 'Casa Tutor', 'Casa Cliente', 'Biblioteca', 'Altro'];
@endphp

@section('page-title')
Modifica Lezione <span class="hidden md:inline"> di {{ $studentName }}</span>
@endsection
@section('back-button-route', route('students.show', $lesson->student))

@section('action-buttons')
<x-button type="submit" form="edit-lesson-form"> 
    <span class="md:hidden">Salva</span>
    <span class="hidden md:inline">Salva Modifiche</span>
</x-button>
@endsection

@section('content')

<form id="edit-lesson-form" action="{{ route('lessons.update', $lesson) }}" method="POST" class="flex flex-col gap-6">
    @csrf
    @method('PUT')


    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-[500px] flex flex-col gap-4">

            {{-- Giorno --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">Giorno</label>
                <input type="date" name="giorno" value="{{ $giorno }}" class="input-field" />
            </div>

            {{-- Orario --}}
            <div class="flex flex-row gap-4">
                <div class="flex flex-col gap-1 flex-1">
                    <label class="primary-text text-sm font-medium">Ora inizio</label>
                    <input type="time" name="ora_inizio"
                        value="{{ $oraInizio }}"
                        class="input-field w-full" />
                </div>

                <div class="flex flex-col gap-1 flex-1">
                    <label class="primary-text text-sm font-medium">Ora fine</label>
                    <input type="time" name="ora_fine"
                        value="{{ $oraFine }}"
                        class="input-field w-full" />
                </div>
            </div>


            {{-- Luogo --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">Luogo</label>
                
                <select name="luogo" class="input-field">
                    <option value="">---</option>
                    @foreach($luoghi as $luogo)
                        <option value="{{ $luogo }}" @selected(old('luogo', $lesson->luogo) === $luogo)>
                            {{ $luogo }}
                        </option>
                    @endforeach
                </select>

            </div>

            {{-- Materia --}}
            <div class="flex flex-col gap-1">
                <label class="primary-text text-sm font-medium">
                    Materia <span class="text-red-500">*</span>
                </label>
                <select name="subject_id" class="input-field">
                    <option value="">---</option>

                    @foreach($userSubjects as $subject)
                        <option value="{{ $subject->id }}" @selected($lesson->subject_id === $subject->id)>
                            {{ $subject->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="w-full flex flex-col gap-1">
            <label class="primary-text text-sm font-medium">Argomento</label>
            <textarea name="argomento" rows="11" class="input-field w-full">{{ $lesson->argomento ?? '' }}</textarea>
        </div>
    </div>
</form>

<div class="mt-6">
    <div class="border-t box-border mb-6"></div>

    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa lezione?');">
        @csrf
        @method('DELETE')

        <div class="flex justify-end">
            <x-button type="submit" variant="destructive"> Elimina Lezione </x-button>
        </div>
    </form>
</div>

@endsection
