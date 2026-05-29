<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scanner RFID - Élève</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Carte principale du scanner -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-center">
            <!-- Icône de scan -->
            <div id="scanIcon" class="inline-flex items-center justify-center w-32 h-32 bg-blue-100 rounded-full mb-6 transition-all duration-300">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-900 mb-3">
                Scanner RFID
            </h1>
            <p id="instruction" class="text-lg text-gray-600 mb-8">
                Scannez votre badge pour pointer
            </p>

            <!-- Zone de feedback -->
            <div id="feedback" class="hidden mb-6">
                <div id="feedbackContent" class="p-6 rounded-xl"></div>
            </div>

            <!-- Champ de scan (caché mais actif) -->
            <input
                type="text"
                id="rfidInput"
                class="w-full px-4 py-3 text-center text-2xl border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Scannez votre badge..."
                autocomplete="off"
                autofocus
            >

            <!-- Horloge -->
            <div class="mt-8 text-4xl font-bold text-gray-800" id="clock"></div>
            <div class="text-sm text-gray-500 mt-2" id="date"></div>
        </div>

        <!-- Lien de connexion -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                Se connecter à l'espace personnel →
            </a>
        </div>
    </div>

    <script>
        // Fonction pour mettre à jour l'horloge
        function updateClock() {
            const now = new Date();
            const clock = document.getElementById('clock');
            const date = document.getElementById('date');

            clock.textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            date.textContent = now.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }

        // Mise à jour de l'horloge chaque seconde
        updateClock();
        setInterval(updateClock, 1000);

        // Gestion du scan RFID
        const rfidInput = document.getElementById('rfidInput');
        const feedback = document.getElementById('feedback');
        const feedbackContent = document.getElementById('feedbackContent');
        const scanIcon = document.getElementById('scanIcon');
        const instruction = document.getElementById('instruction');

        rfidInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const rfidCode = this.value.trim();
                if (rfidCode) {
                    scanBadge(rfidCode);
                    this.value = '';
                }
            }
        });

        // Garder le focus sur l'input
        setInterval(() => {
            if (document.activeElement !== rfidInput) {
                rfidInput.focus();
            }
        }, 1000);

        async function scanBadge(rfidCode) {
            try {
                // Animation de scan
                scanIcon.classList.add('scale-110', 'bg-yellow-100');
                instruction.textContent = 'Scan en cours...';

                const response = await fetch('{{ route("student.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ rfid_code: rfidCode })
                });

                const data = await response.json();

                if (data.success) {
                    showSuccess(data);
                } else {
                    showError(data.message);
                }
            } catch (error) {
                showError('Erreur de connexion');
            }
        }

        function showSuccess(data) {
            const isEntry = data.student.action === 'ENTREE';
            const bgColor = isEntry ? 'bg-green-100' : 'bg-orange-100';
            const textColor = isEntry ? 'text-green-800' : 'text-orange-800';
            const icon = isEntry ? '✅' : '👋';

            scanIcon.className = `inline-flex items-center justify-center w-32 h-32 ${bgColor} rounded-full mb-6 transition-all duration-300 scale-110`;

            feedbackContent.className = `p-6 rounded-xl ${bgColor}`;
            feedbackContent.innerHTML = `
                <div class="text-6xl mb-4">${icon}</div>
                <h2 class="text-2xl font-bold ${textColor} mb-2">${data.message}</h2>
                <p class="text-xl ${textColor} font-semibold">${data.student.name}</p>
                <p class="text-lg ${textColor}">${data.student.classe}</p>
                <p class="text-sm ${textColor} mt-2">${data.student.action} • ${data.student.timestamp}</p>
            `;

            feedback.classList.remove('hidden');
            instruction.textContent = data.message;

            // Réinitialiser après 5 secondes
            setTimeout(resetScanner, 5000);
        }

        function showError(message) {
            scanIcon.className = 'inline-flex items-center justify-center w-32 h-32 bg-red-100 rounded-full mb-6 transition-all duration-300 scale-110';

            feedbackContent.className = 'p-6 rounded-xl bg-red-100';
            feedbackContent.innerHTML = `
                <div class="text-6xl mb-4">❌</div>
                <h2 class="text-2xl font-bold text-red-800 mb-2">${message}</h2>
                <p class="text-sm text-red-700">Veuillez réessayer</p>
            `;

            feedback.classList.remove('hidden');
            instruction.textContent = 'Erreur de scan';

            // Réinitialiser après 3 secondes
            setTimeout(resetScanner, 3000);
        }

        function resetScanner() {
            scanIcon.className = 'inline-flex items-center justify-center w-32 h-32 bg-blue-100 rounded-full mb-6 transition-all duration-300';
            feedback.classList.add('hidden');
            instruction.textContent = 'Scannez votre badge pour pointer';
            rfidInput.focus();
        }
    </script>
</body>
</html>
