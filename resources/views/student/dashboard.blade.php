@extends('layouts.app')

@section('title', 'Mon Tableau de Bord')

@section('nav-links')
<a href="{{ route('student.scanner') }}" class="text-gray-600 hover:text-gray-900">
    Scanner
</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête avec statut -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Bonjour, {{ $user->name }} 👋
        </h2>
        <p class="text-gray-600">
            {{ $user->classe ? $user->classe->name : 'Non assigné à une classe' }}
        </p>
    </div>

    <!-- Statut du jour -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Statut aujourd'hui</h3>
                    <p class="text-sm text-gray-600">{{ now()->format('d/m/Y') }}</p>
                </div>
                <div class="text-right">
                    @if($status === 'PRESENT')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold bg-green-100 text-green-800">
                            ✅ Présent
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold bg-gray-100 text-gray-800">
                            ⚪ Absent
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Historique du jour -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Aujourd'hui</h3>
            </div>
            <div class="p-6">
                @if($todayLogs->count() > 0)
                    <div class="space-y-3">
                        @foreach($todayLogs as $log)
                        <div class="flex items-center justify-between p-3 rounded-lg {{ $log->action === 'ENTREE' ? 'bg-green-50' : 'bg-orange-50' }}">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ $log->action === 'ENTREE' ? '📥' : '📤' }}</span>
                                <div>
                                    <p class="font-semibold {{ $log->action === 'ENTREE' ? 'text-green-900' : 'text-orange-900' }}">
                                        {{ $log->action === 'ENTREE' ? 'Entrée' : 'Sortie' }}
                                    </p>
                                    <p class="text-sm {{ $log->action === 'ENTREE' ? 'text-green-700' : 'text-orange-700' }}">
                                        {{ $log->timestamp->format('H:i:s') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun pointage aujourd'hui</p>
                @endif
            </div>
        </div>

        <!-- Historique de la semaine -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Cette semaine</h3>
            </div>
            <div class="p-6">
                @if($weekLogs->count() > 0)
                    <div class="space-y-2">
                        @foreach($weekLogs->take(10) as $log)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">
                                {{ $log->timestamp->format('d/m - H:i') }}
                            </span>
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $log->action === 'ENTREE' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ $log->action === 'ENTREE' ? 'Entrée' : 'Sortie' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun pointage cette semaine</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bouton scanner -->
    <div class="mt-8 text-center">
        <a href="{{ route('student.scanner') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Scanner mon badge
        </a>
    </div>
</div>
@endsection
