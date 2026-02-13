export function updateTimer(id, categoryId) {
    if (!confirm('¿Estás seguro de que quieres actualizar e imprimir este vencimiento?')) return;
    const card = document.getElementById(`timer-card-${id}`);
    if (card) {
        card.style.opacity = '0.5';
        card.style.pointerEvents = 'none';
    }

    fetch(`/updateTimer/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-HTTP-Method-Override': 'PUT'
        },
        body: JSON.stringify({ _method: 'PUT' })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ok') {
                console.log(id, categoryId);
                const timeDisplay = card.querySelector('.timer-card');
                console.log(timeDisplay);
                if (timeDisplay) timeDisplay.innerText = data.new_expiration_display;

                card.setAttribute('data-expires', data.new_expiration_iso);
                document.getElementById(`elab-${id}-${categoryId}`).innerText = data.elaborationTime;
                document.getElementById(`vence-${id}-${categoryId}`).innerText = data.expirationTime;


                card.classList.add('animate-success', 'ring-4', 'ring-green-500/50');
                setTimeout(() => {
                    card.classList.remove('animate-success', 'ring-4', 'ring-green-500/50');
                }, 800);

                // Limpiar notificaciones
                let notificados = JSON.parse(sessionStorage.getItem('notificados_mcd')) || [];
                notificados = notificados.filter(item => item !== id.toString());
                sessionStorage.setItem('notificados_mcd', JSON.stringify(notificados));

            } else {

                alert(data.message || 'Hubo un error al actualizar el timer.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión con el servidor.');
        })
        .finally(() => {
            if (card) {
                card.style.opacity = '1';
                card.style.pointerEvents = 'auto';
            }
        });
}
