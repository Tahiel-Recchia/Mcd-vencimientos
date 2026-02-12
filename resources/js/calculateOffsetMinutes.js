function toggleInputs(ruleId) {
    const unitSelect = document.getElementById(`unit-${ruleId}`);
    const numericContainer = document.getElementById(`numeric-container-${ruleId}`);
    const dateContainer = document.getElementById(`date-container-${ruleId}`);

    if (unitSelect.value === 'custom') {
        numericContainer.classList.add('hidden');
        dateContainer.classList.remove('hidden');
    } else {
        numericContainer.classList.remove('hidden');
        dateContainer.classList.add('hidden');
        document.getElementById(`date-${ruleId}`).value = '';
    }
}


function processAndSubmit(ruleId) {
    const unitSelect = document.getElementById(`unit-${ruleId}`);
    const valInput = document.getElementById(`val-${ruleId}`);
    const dateInput = document.getElementById(`date-${ruleId}`).value;
    const finalInput = document.getElementById(`final-${ruleId}`);


    if (unitSelect.value === 'custom' && dateInput) {
        const selectedDate = new Date(dateInput);
        const now = new Date();
        const diffMs = now - selectedDate;
        finalInput.value = diffMs > 0 ? Math.floor(diffMs / 60000) : 0;
    } else {
        const value = parseFloat(valInput.value) || 0;
        const unit = parseFloat(unitSelect.value) || 0;
        finalInput.value = Math.floor(value * unit);
    }

    console.log("Minutos a restar calculados: " + finalInput.value);


    return true;
}

window.processAndSubmit = processAndSubmit;
window.toggleInputs = toggleInputs;
