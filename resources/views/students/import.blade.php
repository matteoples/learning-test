@extends('layouts.app')

@section('page-title', 'Importa Studente da JSON')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold mb-6">Importa Studente da JSON</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">
                    File JSON dello studente (esportato con "Esporta dati in JSON")
                </label>
               <input type="file" name="json_files[]" accept=".json" multiple required
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                
                @error('json_file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <a href="{{ route('students.index') }}"
                   class="px-6 py-3 border rounded-lg hover:bg-gray-50">
                    Annulla
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    Importa Studente
                </button>
            </div>
        </form>

        <div class="mt-8 text-sm text-gray-500">
            <p>Il file deve essere stato generato con la funzione "Esporta dati in JSON".</p>
            <p class="mt-2">Verranno importati:</p>
            <ul class="list-disc list-inside mt-1">
                <li>Dati anagrafici</li>
                <li>Tutte le lezioni</li>
                <li>Tutti i pagamenti</li>
            </ul>
        </div>
    </div>
</div>
@endsection