@extends('layout')

@section('title', 'Historique des passages')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Historique des passages</h1>
            <p class="text-slate-500 mt-1">Tous les événements enregistrés par le système.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Date & Heure</th>
                        <th class="px-6 py-4 font-medium">Employé</th>
                        <th class="px-6 py-4 font-medium">Département</th>
                        <th class="px-6 py-4 font-medium">Événement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $log->timestamp->format('d/m/Y') }}</span>
                                    <span class="text-slate-400">à</span>
                                    <span>{{ $log->timestamp->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $log->employee->name }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $log->employee->department }}
                            </td>
                            <td class="px-6 py-4">
                                @if($log->type === 'IN')
                                    <span class="inline-flex items-center space-x-1 text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Entrée</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Sortie</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                Aucun historique enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
