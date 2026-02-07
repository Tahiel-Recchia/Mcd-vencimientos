window.deleteTimer = function(id) {
    if(!confirm('¿Estás seguro de que quieres eliminar este vencimiento?')) return;
    const card = document.getElementById(`timer-card-${id}`);
    if(card) {
        card.style.opacity = '0.5'; // Feedback visual de "procesando"
        card.style.pointerEvents = 'none';
    }


    fetch(`/active-timers/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (response.ok) {
                card.remove();
                if(document.querySelectorAll('.timer-card').length === 0) {
                    location.reload();
                }
            } else {
                alert('Hubo un error al eliminar el timer.');
                if(card) {
                    card.style.opacity = '1';
                    card.style.pointerEvents = 'auto';

                }

            }

        })

        .catch(error => {

            console.error('Error:', error);

            alert('Error de conexión.');

        });

}

window.updateTimer = function(id, categoryId) {
    if (!confirm('¿Estás seguro de que quieres actualizar e imprimir este vencimiento?')) return;

    // Buscamos la card. Usamos un selector que encuentre el ID que termine en el numero
    // Esto sirve para el dashboard normal y el global.
    const card = document.querySelector(`[id$="-${id}"].timer-card`);

    if (card) {
        card.style.opacity = '0.5';
        card.style.pointerEvents = 'none';
    }

    fetch(`/updateTimer/${id}/${categoryId}`, {
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
                // Buscamos los elementos dentro de la card específica encontrada
                const timeDisplay = card.querySelector('.timer-display');
                if (timeDisplay) timeDisplay.innerText = data.new_expiration_display;

                // Actualizamos el atributo para que el reloj JS tome la nueva fecha
                card.setAttribute('data-expires', data.new_expiration_iso);
                document.getElementById(`elab-${id}-${categoryId}`).innerText = data.elaborationTime;
                document.getElementById(`vence-${id}-${categoryId}`).innerText = data.expirationTime;

                // Efecto visual de éxito
                card.classList.add('animate-success', 'ring-4', 'ring-green-500/50');
                setTimeout(() => {
                    card.classList.remove('animate-success', 'ring-4', 'ring-green-500/50');
                }, 800);

                // Limpiar notificaciones
                let notificados = JSON.parse(sessionStorage.getItem('notificados_mcd')) || [];
                notificados = notificados.filter(item => item !== id.toString());
                sessionStorage.setItem('notificados_mcd', JSON.stringify(notificados));

            } else {
                // Si el error es de la impresora, el mensaje vendrá en data.message
                alert(data.message || 'Hubo un error al actualizar el timer.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión con el servidor.');
        })
        .finally(() => {
            // Siempre restauramos la card, pase lo que pase
            if (card) {
                card.style.opacity = '1';
                card.style.pointerEvents = 'auto';
            }
        });
}
