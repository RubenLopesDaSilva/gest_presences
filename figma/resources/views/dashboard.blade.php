@extends('layout')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Tableau de bord</h1>
            <p class="text-slate-500 mt-1">Aperçu en temps réel des présences.</p>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium uppercase">Total Employés</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $totalEmployees }}</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium uppercase">Présents</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $presentEmployees }}</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium uppercase">Absents</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $absentEmployees }}</h2>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart (simplifié pour cette version - vous pouvez utiliser Chart.js ou ApexCharts) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Activité de la journée</h3>
            <div class="h-72 flex items-end justify-around space-x-2">
                @foreach($chartData as $data)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full flex flex-col items-center space-y-1">
                            @if($data['entrees'] > 0)
                                <div class="w-full bg-emerald-200 rounded-t" style="height: {{ $data['entrees'] * 20 }}px"></div>
                            @endif
                            @if($data['sorties'] > 0)
                                <div class="w-full bg-rose-200 rounded-b" style="height: {{ $data['sorties'] * 20 }}px"></div>
                            @endif
                            @if($data['entrees'] == 0 && $data['sorties'] == 0)
                                <div class="w-full bg-slate-100 rounded" style="height: 10px"></div>
                            @endif
                        </div>
                        <span class="text-xs text-slate-500 mt-2">{{ $data['time'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex justify-center space-x-4 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-emerald-200 rounded"></div>
                    <span class="text-slate-600">Entrées</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-rose-200 rounded"></div>
                    <span class="text-slate-600">Sorties</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Derniers passages</h3>
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="space-y-4">
                @forelse($recentLogs as $log)
                    @php
                        $isEntry = $log->type === 'IN';
                    @endphp
                    <div class="flex items-start space-x-3 pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                        <div class="mt-0.5 p-2 rounded-full {{ $isEntry ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            @if($isEntry)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-800">{{ $log->employee->name }}</p>
                            <p class="text-xs text-slate-500">{{ $log->employee->department }}</p>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">
                            {{ $log->timestamp->format('H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Aucune activité récente.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
