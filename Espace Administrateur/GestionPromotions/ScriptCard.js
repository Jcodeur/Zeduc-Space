document.addEventListener('DOMContentLoaded', function() {
    // Charger les événements depuis localStorage lors du chargement de la page
    loadEvents();

    // Ajouter un événement au formulaire
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Récupérer les valeurs du formulaire
        const nomEvent = document.getElementById('nomEvent').value;
        const commentaire = document.getElementById('commentaire').value;
        const imageFile = document.getElementById('image').files[0];

        if (!imageFile) {
            alert("Veuillez sélectionner une image.");
            return;
        }

        // Lire l'image sélectionnée
        const reader = new FileReader();
        reader.readAsDataURL(imageFile);

        reader.onload = function(e) {
            const imageURL = e.target.result;

            // Ajouter l'événement au localStorage
            const newEvent = {
                nomEvent,
                commentaire,
                imageURL
            };
            saveEvent(newEvent);

            // Créer une nouvelle carte pour l'événement
            createEventCard(newEvent);

            // Réinitialiser le formulaire
            document.getElementById('eventForm').reset();
        };
    });
});

// Fonction pour créer une carte événement
function createEventCard(event) {
    const eventContainer = document.getElementById('eventContainer');
    
    const newCard = document.createElement('div');
    newCard.classList.add('col-md-4', 'mt-4');
    newCard.innerHTML = `
        <div class="card">
            <img src="${event.imageURL}" class="card-img-top" alt="${event.nomEvent}">
            <div class="card-body">
                <h5 class="card-title">${event.nomEvent}</h5>
                <p class="card-text">${event.commentaire}</p>
                <a href="#" class="btn btn-warning">Voir Plus</a>
            </div>
        </div>
    `;
    
    // Ajouter la carte à l'élément eventContainer
    eventContainer.appendChild(newCard);
}

// Fonction pour sauvegarder un événement dans le localStorage
function saveEvent(event) {
    // Récupérer les événements stockés dans le localStorage
    let events = JSON.parse(localStorage.getItem('events')) || [];
    
    // Ajouter le nouvel événement à la liste
    events.push(event);
    
    // Sauvegarder la liste d'événements dans le localStorage
    localStorage.setItem('events', JSON.stringify(events));
}

// Fonction pour charger les événements depuis le localStorage
function loadEvents() {
    const events = JSON.parse(localStorage.getItem('events')) || [];
    
    // Créer une carte pour chaque événement enregistré
    events.forEach(event => {
        createEventCard(event);
    });
}
