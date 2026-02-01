window.updateTimers = function() {
    const cards = document.querySelectorAll('.timer-card');
    const now = new Date().getTime();

    cards.forEach(card => {
        const expiresStr = card.getAttribute('data-expires');
        const expireDate = new Date(expiresStr).getTime();
        const distance = expireDate - now;

        const display = card.querySelector('.timer-display');
        const timerContainer = display.parentElement; // La caja gris del timer

        // Limpiamos estados previos (usando clases base que siempre existen)
        card.classList.remove('border-red-600', 'border-yellow-500', 'border-green-500');
        timerContainer.classList.remove('bg-red-100', 'bg-yellow-100', 'bg-green-100', 'bg-slate-50');
        display.classList.remove('text-red-600', 'text-yellow-700', 'text-green-700', 'text-slate-700');

        if (distance < 0) {
            display.innerHTML = "VENCIDO";
            card.classList.add('border-red-600');
            timerContainer.classList.add('bg-red-100');
            display.classList.add('text-red-600');
        } else {
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Formato 00:00:00 (más limpio para dashboard)
            display.innerHTML =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            const minutesLeft = distance / 1000 / 60;

            if (minutesLeft <= 15) {
                // CRÍTICO
                card.classList.add('border-red-600');
                timerContainer.classList.add('bg-red-100');
                display.classList.add('text-red-600');
            } else if (minutesLeft <= 45) {
                // ADVERTENCIA
                card.classList.add('border-yellow-500');
                timerContainer.classList.add('bg-yellow-100');
                display.classList.add('text-yellow-700');
            } else {
                // SEGURO
                card.classList.add('border-green-500');
                timerContainer.classList.add('bg-green-100');
                display.classList.add('text-green-700');
            }
        }
    });
}

// Ejecución
document.addEventListener('DOMContentLoaded', () => {
    setInterval(updateTimers, 1000);
    updateTimers();
});
