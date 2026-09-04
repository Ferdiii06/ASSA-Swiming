@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Program</h2>
        <p class="text-gray-600">Perbarui detail program, nama kolam renang, atau lokasi.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('programs.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Program <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('name', $program->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pool_name" class="block text-gray-700 font-medium mb-2">Nama Kolam Renang <span class="text-red-500">*</span></label>
                <input type="text" name="pool_name" id="pool_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ old('pool_name', $program->pool_name) }}" required>
                @error('pool_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-medium mb-2">Lokasi Baru <span class="text-red-500">*</span></label>
                <textarea name="location" id="location" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('location', $program->location) }}</textarea>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi Program (Opsional)</label>
                <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description', $program->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ $program->is_active ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 text-gray-700 font-medium">Program Aktif</label>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('programs.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Perbarui Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
