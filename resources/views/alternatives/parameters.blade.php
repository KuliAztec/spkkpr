@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Parameter Nasabah</h1>
        <p class="mt-2 text-sm text-gray-600">
            Nasabah: <strong>{{ $alternative->name }}</strong> ({{ $alternative->code }}) - Pilih parameter untuk setiap sub kriteria
        </p>
    </div>

    <form action="{{ route('alternatives.parameters.store', $alternative) }}" method="POST">
        @csrf
        
        @foreach($subcriteria as $criteriaName => $subs)
            <div class="bg-white shadow sm:rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $criteriaName }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($subs as $sub)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    {{ $sub->name }} ({{ $sub->code }})
                                </label>
                                <div class="space-y-2">
                                    @foreach($sub->parameters as $parameter)
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="parameters[{{ $parameter->subcriteria_id }}]" 
                                                   value="{{ $parameter->id }}"
                                                   {{ $selectedParameters->get($parameter->subcriteria_id)?->id == $parameter->id ? 'checked' : '' }}
                                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                            <span class="ml-3 block text-sm">
                                                <span class="font-medium text-gray-900">{{ $parameter->parameter_name }}</span>
                                                <span class="text-gray-500">({{ $parameter->nilai }})</span>
                                                <span class="block text-xs text-gray-400">{{ $parameter->description }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end space-x-3">
            <a href="{{ route('alternatives.show', $alternative) }}" 
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                Simpan Parameter
            </button>
        </div>
    </form>
</div>
@endsection
