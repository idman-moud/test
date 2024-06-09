const calendar = document.querySelector('.calendar');
const monthYear = document.getElementById('month-year');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');
const eventForm = document.querySelector('.event-form');
const eventName = document.getElementById('event-name');
const eventDate = document.getElementById('event-date');
const weekdays = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

function updateCalendar() {
    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    calendar.querySelector('.calendar-days').innerHTML = '';
    monthYear.textContent = new Date(currentYear, currentMonth).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });

    for (let i = 0; i < weekdays.length; i++) {
        calendar.querySelector('.calendar-weekdays').innerHTML += `<div>${weekdays[i]}</div>`;
    }

    for (let i = 0; i < firstDay; i++) {
        calendar.querySelector('.calendar-days').innerHTML += '<div></div>';
    }

    for (let i = 1; i <= daysInMonth; i++) {
        let dayElement = document.createElement('div');
        dayElement.textContent = i;
        dayElement.classList.add('calendar-day');
        dayElement.setAttribute('data-day', i);
        dayElement.setAttribute('data-month', currentMonth + 1);
        dayElement.setAttribute('data-year', currentYear);

        dayElement.addEventListener('click', () => {
            eventDate.value = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
            eventForm.style.display = 'block';
        });

        calendar.querySelector('.calendar-days').appendChild(dayElement);
    }
}

prevButton.addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentYear--;
        currentMonth = 11;
    }
    updateCalendar();
});

nextButton.addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentYear++;
        currentMonth = 0;
    }
    updateCalendar();
});

function addEvent() {
    const name = eventName.value;
    const date = eventDate.value;

    if (name.trim() === '' || date.trim() === '') {
        alert('Veuillez remplir tous les champs.');
        return;
    }

    // Envoyer l'événement au serveur (PHP/MySQL) pour l'enregistrement
    alert(`Événement "${name}" ajouté pour le ${date}.`);

    eventName.value = '';
    eventDate.value = '';
    eventForm.style.display = 'none';
}

updateCalendar();
