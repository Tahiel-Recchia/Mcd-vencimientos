export function deleteTimer(timerId, categoryId) {

    if(!confirm('¿Estás seguro de que quieres eliminar este vencimiento?')) return;
    const card = document.getElementById(`timer-card-${timerId}`);
    console.log(card)
    if(card) {
        card.style.opacity = '0.5';
        card.style.pointerEvents = 'none';
    }


    fetch(`/active-timers/${timerId}/${categoryId}`, {
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

