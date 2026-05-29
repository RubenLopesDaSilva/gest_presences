@extends('layout')

@section('title', 'Scanner RFID')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col items-center justify-center min-h-[70vh]">
    <div class="bg-white p-10 rounded-3xl shadow-lg border border-slate-100 w-full text-center relative overflow-hidden">

        <!-- Animated Background Ring based on status -->
        <div id="status-bg" class="absolute inset-0 opacity-10 transition-colors duration-500"></div>

        <h2 class="text-3xl font-bold text-slate-800 mb-2 relative z-10">Scanner un badge</h2>
        <p class="text-slate-500 mb-10 relative z-10">Passez votre carte RFID sur le lecteur</p>

        <div class="relative z-10 flex justify-center mb-10">
            <div id="scan-icon" class="p-8 rounded-full border-4 transition-all duration-300 border-blue-100 bg-blue-50 text-blue-500">
                <!-- Scan Icon -->
                <svg id="icon-scan" class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                <!-- Success Icon (hidden by default) -->
                <svg id="icon-success" class="w-16 h-16 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <!-- Error Icon (hidden by default) -->
                <svg id="icon-error" class="w-16 h-16 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Hidden form for the actual scanner input -->
        <form id="scan-form" onsubmit="handleScan(event)" class="relative z-10">
            <input
                id="rfid-input"
                type="text"
                class="opacity-0 absolute -z-10"
                autofocus
            />
        </form>

        <div id="status-message" class="min-h-[80px] relative z-10">
            <div class="p-4 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                En attente du scan...
                <div class="text-xs mt-2 font-mono">
                    (Astuce: Tapez un code RFID ex: "00012345" + Entrée)
                </div>
            </div>
        </div>

        <!-- Demo helpers -->
        <div class="mt-12 pt-6 border-t border-slate-100 relative z-10">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-3">Badges de test</p>
            <div class="flex flex-wrap gap-2 justify-center">
                @foreach($employees as $employee)
                    <button
                        onclick="simulateScan('{{ $employee->rfid }}')"
                        class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-md text-xs font-mono text-slate-600 transition-colors"
                    >
                        {{ $employee->name }}: {{ $employee->rfid }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    const rfidInput = document.getElementById('rfid-input');
    const statusBg = document.getElementById('status-bg');
    const scanIcon = document.getElementById('scan-icon');
    const iconScan = document.getElementById('icon-scan');
    const iconSuccess = document.getElementById('icon-success');
    const iconError = document.getElementById('icon-error');
    const statusMessage = document.getElementById('status-message');

    // Keep focus on input
    rfidInput.focus();
    document.addEventListener('click', () => rfidInput.focus());

    async function handleScan(e) {
        e.preventDefault();

        const rfid = rfidInput.value.trim();
        if (!rfid) return;

        try {
            const response = await fetch('{{ route("api.scan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ rfid })
            });

            const data = await response.json();

            if (data.success) {
                showSuccess(data);
            } else {
                showError(data.message);
            }
        } catch (error) {
            showError('Erreur de connexion au serveur.');
        }

        rfidInput.value = '';

        setTimeout(() => {
            resetStatus();
        }, 3000);
    }

    function showSuccess(data) {
        statusBg.className = 'absolute inset-0 opacity-10 transition-colors duration-500 bg-emerald-500';
        scanIcon.className = 'p-8 rounded-full border-4 transition-all duration-300 border-emerald-200 bg-emerald-100 text-emerald-600 scale-110';
        iconScan.classList.add('hidden');
        iconSuccess.classList.remove('hidden');
        iconError.classList.add('hidden');

        const message = data.type === 'IN' ? 'Bienvenue' : 'Au revoir';
        statusMessage.innerHTML = `
            <div class="p-4 rounded-xl bg-emerald-50 text-emerald-800">
                <p class="font-bold text-lg">${data.employee.name}</p>
                <p>${message} !</p>
            </div>
        `;
    }

    function showError(message) {
        statusBg.className = 'absolute inset-0 opacity-10 transition-colors duration-500 bg-rose-500';
        scanIcon.className = 'p-8 rounded-full border-4 transition-all duration-300 border-rose-200 bg-rose-100 text-rose-600 scale-110';
        iconScan.classList.add('hidden');
        iconSuccess.classList.add('hidden');
        iconError.classList.remove('hidden');

        statusMessage.innerHTML = `
            <div class="p-4 rounded-xl bg-rose-50 text-rose-800">
                <p>${message}</p>
            </div>
        `;
    }

    function resetStatus() {
        statusBg.className = 'absolute inset-0 opacity-10 transition-colors duration-500';
        scanIcon.className = 'p-8 rounded-full border-4 transition-all duration-300 border-blue-100 bg-blue-50 text-blue-500';
        iconScan.classList.remove('hidden');
        iconSuccess.classList.add('hidden');
        iconError.classList.add('hidden');

        statusMessage.innerHTML = `
            <div class="p-4 border-2 border-dashed border-slate-200 rounded-xl text-slate-400">
                En attente du scan...
                <div class="text-xs mt-2 font-mono">
                    (Astuce: Tapez un code RFID ex: "00012345" + Entrée)
                </div>
            </div>
        `;
    }

    function simulateScan(rfid) {
        rfidInput.value = rfid;
        handleScan({ preventDefault: () => {} });
    }
</script>
@endsection
