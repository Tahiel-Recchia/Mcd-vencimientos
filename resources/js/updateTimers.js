window.updateTimers = function() {
    const cards = document.querySelectorAll('.timer-card');
    const now = new Date().getTime();

    cards.forEach(card => {
        const expiresStr = card.getAttribute('data-expires');
        const expireDate = new Date(expiresStr).getTime();
        const distance = expireDate - now;


        const fullId = card.id.replace('timer-card-', '');


        const display = document.getElementById(`timer-${fullId}`);
        const nameEl = document.getElementById(`name-${fullId}`);
        const locEl = document.getElementById(`location-${fullId}`);

        // Validación de seguridad
        if (!display) return;

        const timerContainer = display.parentElement;
        const name = nameEl ? nameEl.textContent : "Producto";
        const location = locEl ? locEl.textContent : "General";

        // Limpiar clases
        card.classList.remove('border-red-600', 'border-yellow-500', 'border-green-500');
        timerContainer.classList.remove('bg-red-100', 'bg-yellow-100', 'bg-green-100', 'bg-slate-50');
        display.classList.remove('text-red-600', 'text-yellow-700', 'text-green-700', 'text-slate-700');

        // Si la distancia no es un número o es menor a 0, está vencido
        if (isNaN(distance) || distance < 0) {
            display.innerHTML = "VENCIDO";
            card.classList.add('border-red-600');
            timerContainer.classList.add('bg-red-100');
            display.classList.add('text-red-600');
        } else {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let timeText = days >= 1
                ? `${days}d ${hours}h`
                : `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            display.innerHTML = timeText;

            const minutesLeft = distance / 1000 / 60;

            if (minutesLeft <= 15) {
                if (typeof showNotification === 'function') showNotification(fullId, name, location);
                card.classList.add('border-red-600');
                timerContainer.classList.add('bg-red-100');
                display.classList.add('text-red-600');
            } else if (minutesLeft <= 45) {
                card.classList.add('border-yellow-500');
                timerContainer.classList.add('bg-yellow-100');
                display.classList.add('text-yellow-700');
            } else {
                card.classList.add('border-green-500');
                timerContainer.classList.add('bg-green-100');
                display.classList.add('text-green-700');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setInterval(updateTimers, 1000);
    updateTimers();
});

document.addEventListener('DOMContentLoaded', () => {
    const closeBtn = document.getElementById('closeNotification');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            const notification = document.getElementById('notification-modal');
            if (notification) notification.classList.add('hidden');
        });
    }

    setInterval(updateTimers, 1000);
    updateTimers();
});

function showNotification(id, name, expirationRule){
    let notifications = JSON.parse(sessionStorage.getItem('notifications')) || [];
    if(notifications.includes(id)){
        return;
    }
    //SONIDO
    const alertSound = new Audio('/sounds/alert.mp3');
    alertSound.currentTime = 0;
    alertSound.play();

    notifications.push(id);
    sessionStorage.setItem('notifications', JSON.stringify(notifications));

    const productName = document.getElementById('notif-product-name');
    const location = document.getElementById('notif-product-location');
    console.log(productName, location);
    productName.textContent = name;
    location.textContent = expirationRule;

    const notification = document.getElementById('notification-modal');
    notification.classList.remove('hidden');

}

document.getElementById('closeNotification').addEventListener('click', ()=>{
    const notification = document.getElementById('notification-modal');
    notification.classList.add('hidden');
});


