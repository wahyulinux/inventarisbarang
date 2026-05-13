@extends('layouts.app')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Ubah Kata Sandi</h3>
            <p class="text-sm text-gray-500">Silakan masukkan kata sandi lama dan kata sandi baru Anda.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kata Sandi Lama</label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <hr class="border-gray-100">

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kata Sandi Baru</label>
                    <input type="password" name="new_password" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="new_password_confirmation" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition shadow-sm">
                        <i class="bi bi-shield-check mr-2"></i> Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
