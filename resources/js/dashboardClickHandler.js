import './updateTimers.js'
import { deleteTimer } from './deleteTimer.js';
import { updateTimer } from './renewTimer.js';
import { importTimer, executeImport, closeImportModal } from './importTimer.js';

document.addEventListener('click', (e) => {
    console.log('clicked');
    const btn = e.target.closest('.btn-action');
    if (!btn) return;

    e.preventDefault();

    const { action, timerId, categoryId } = btn.dataset;

    console.log(`Acción: ${action}, ID: ${timerId}`);

    switch (action) {
        case 'delete':
            deleteTimer(timerId, categoryId);
            break;

        case 'renew':
            updateTimer(timerId, categoryId);
            break;

        case 'import':
            const { productName, location } = btn.dataset;
            importTimer(timerId, productName, location);
            break;

        case 'confirm-import':
            executeImport(timerId, categoryId);
            break;
        case 'closeImportModal':
            closeImportModal();
            break;
        default:
            console.warn('Acción no reconocida:', action);
    }
});
