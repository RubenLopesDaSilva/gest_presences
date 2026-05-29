@extends('layouts.app')

@section('title', $classe->name)

@section('nav-links')
<a href="{{ route('teacher.dashboard') }}" class="text-gray-600 hover:text-gray-900">
    Tableau de bord
</a>
<a href="{{ route('teacher.students') }}" class="text-gray-600 hover:text-gray-900">
    Élèves
</a>
<a href="{{ route('teacher.history') }}" class="text-gray-600 hover:text-gray-900">
    Historique
</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête de la classe -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                    ← Retour au tableau de bord
                </a>
                <h2 class="text-3xl font-bold text-gray-900">{{ $classe->name }}</h2>
                <p class="text-gray-600 mt-2">{{ $classe->level }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-600">Total: {{ $students->count() }} élèves</div>
                <div class="text-sm text-green-600 font-medium">Présents: {{ $classe->present_students_count }}</div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-600">Total</div>
            <div class="text-2xl font-bold text-gray-900">{{ $students->count() }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <div class="text-sm text-green-600">Présents</div>
            <div class="text-2xl font-bold text-green-600">{{ $classe->present_students_count }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-4">
            <div class="text-sm text-red-600">Absents</div>
            <div class="text-2xl font-bold text-red-600">{{ $classe->absent_students_count }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <div class="text-sm text-blue-600">Taux de présence</div>
            <div class="text-2xl font-bold text-blue-600">
                {{ $students->count() > 0 ? round(($classe->present_students_count / $students->count()) * 100) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Liste des élèves -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Liste des Élèves</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière activité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pointages du jour</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                    <tr class="{{ $student->current_status === 'PRESENT' ? 'bg-green-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 font-medium">{{ substr($student->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->current_status === 'PRESENT')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ✅ Présent
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    ⚪ Absent
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            @if($student->today_logs->first())
                                {{ $student->today_logs->first()->timestamp->format('H:i:s') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($student->today_logs->count() > 0)
                                <div class="flex space-x-1">
                                    @foreach($student->today_logs->reverse() as $log)
                                        <span class="px-2 py-1 text-xs rounded {{ $log->action === 'ENTREE' ? 'bg-green-200 text-green-800' : 'bg-orange-200 text-orange-800' }}" title="{{ $log->timestamp->format('H:i:s') }}">
                                            {{ $log->action === 'ENTREE' ? '→' : '←' }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Aucun pointage</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
