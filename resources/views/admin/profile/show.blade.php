@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="h-32 bg-gradient-to-r from-emerald-600 to-emerald-700"></div>

            <!-- Content -->
            <div class="px-6 pb-6">
                <!-- Avatar & Name -->
                <div class="flex items-end space-x-4 -mt-16 mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl border-4 border-white flex items-center justify-center shadow-lg">
                        <span class="text-4xl font-bold text-white">{{ substr($admin->name, 0, 1) }}</span>
                    </div>
                    <div class="pb-2">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $admin->name }}</h1>
                        <p class="text-sm text-gray-500">Administrator</p>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <!-- Email -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-bold text-gray-700">Email:</label>
                        <p class="col-span-2 text-gray-900">{{ $admin->email }}</p>
                    </div>

                    <!-- Role -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-bold text-gray-700">Peran:</label>
                        <div class="col-span-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                Admin
                            </span>
                        </div>
                    </div>

                    <!-- Join Date -->
                    <div class="grid grid-cols-3 items-center gap-4">
                        <label class="text-sm font-bold text-gray-700">Terdaftar:</label>
                        <p class="col-span-2 text-gray-900">{{ $admin->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.profile.edit') }}" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 text-center font-medium">
                        Edit Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200 font-medium">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
