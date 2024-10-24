document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const eventsContainer = document.getElementById('eventsContainer');
    const categoryFilters = document.querySelectorAll('.category-filter');

    // Récupérer les événements depuis le LocalStorage (événements ajoutés par l'administrateur)
    const storedEvents = JSON.parse(localStorage.getItem('events')) || [];

    // Fonction pour afficher les événements
    const displayEvents = (filteredEvents) => {
        eventsContainer.innerHTML = ''; // Vider le conteneur d'événements
        if (filteredEvents.length === 0) {
            eventsContainer.innerHTML = '<p>Aucun événement disponible</p>'; // Afficher un message s'il n'y a pas d'événements
            return;
        }

        filteredEvents.forEach(event => {
            const eventCard = `
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img src="${event.image}" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title">${event.title}</h5>
                            <p class="card-text">${event.description}</p>
                        </div>
                    </div>
                </div>
            `;
            eventsContainer.innerHTML += eventCard;
        });
    };

    // Fonction pour filtrer et rechercher les événements
    const filterEvents = () => {
        const searchText = searchBar.value.toLowerCase();
        const selectedCategories = Array.from(categoryFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const filteredEvents = storedEvents.filter(event => {
            const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(event.category);
            const matchesSearch = event.title.toLowerCase().includes(searchText);
            return matchesCategory && matchesSearch;
        });

        displayEvents(filteredEvents);
    };

    // Gestion des événements de recherche et de filtrage
    searchBar.addEventListener('input', filterEvents);
    categoryFilters.forEach(checkbox => checkbox.addEventListener('change', filterEvents));

    // Afficher les événements enregistrés dans le LocalStorage au chargement de la page
    displayEvents(storedEvents);
});
