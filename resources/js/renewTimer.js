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
                const newId = data.new_timer_id;
                const timeDisplay = card.querySelector('.timer-card');
                if (timeDisplay) timeDisplay.innerText = data.new_expiration_display;


                //Actualizar nuevos datos

                card.id = `timer-card-${newId}`;
                card.setAttribute('data-expires', data.new_expiration_iso);

                let elabSpan = document.getElementById(`elab-${id}-${categoryId}`);
                elabSpan.innerText = data.elaborationTime;
                elabSpan.id = `elab-${newId}-${categoryId}`;

                let venceSpan = document.getElementById(`vence-${id}-${categoryId}`);
                venceSpan.innerText = data.expirationTime;
                venceSpan.id = `vence-${newId}-${categoryId}`;

                let btnDelete = card.querySelector('.btn-eliminar');
                btnDelete.setAttribute('data-timer-id', `${newId}`);

                let btnImport = card.querySelector('.btn-importar');
                btnImport.setAttribute('data-timer-id', `${newId}`);

                let btnRenew = card.querySelector('.btn-renovar');
                btnRenew.setAttribute('data-timer-id', `${newId}`);

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
