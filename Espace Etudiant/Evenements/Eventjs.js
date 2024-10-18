document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const eventsContainer = document.getElementById('eventsContainer');
    const categoryFilters = document.querySelectorAll('.category-filter');

   // Exemple de données pour les événements avec les chemins des images
const events = [
    {id: 1, title: "Fête Des X", description: "Célébrons l'innovation et la créativité dans l'informatique ensemble", category: "Hebdomadaire", image: "images/event1.png" },
    {id: 2,title: "Fête des O", description: "Un moment convivial pour échanger et partager nos expériences", category: "Mensuel", image: "images/event2.png" },
    {id: 3, title: "Soirée De Réveillon", description: "Plongez dans la magie des fêtes avec un repas festif et chaleureux", category: "Noël", image: "images/event3.png" },
    {id: 4, title: "Fête de la Gastronomie", description: "Savourez des plats raffinés et découvrez des talents culinaires locaux", category: "Spécial", image: "images/event4.png" },
    {id: 5, title: "Ve Associative", description: "Honorez l'engagement et la solidarité avec des activités et des rencontres enrichissantes", category: "Autres", image: "images/event5.png" },
    {id: 6, title: "Fête spéciale ", description: "Evenement spéciale mancée par Zeduc Découvrez en plus en vous rapprochant d'un membre de l'équipe Zeduc", category: "Spécial", image: "images/event6.png" }
];

// Afficher les événements
const displayEvents = (filteredEvents) => {
    eventsContainer.innerHTML = '';
    filteredEvents.forEach(event => {
        const eventCard = `
             <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="${event.image}" class="card-img-top" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title">${event.title}</h5>
                        <p class="card-text">${event.description}</p>
                        <a href="EventDetails.html?id=${event.id}" class="btn btn-warning">Voir Plus</a>
                    </div>
                </div>
            </div>
        `;
        eventsContainer.innerHTML += eventCard;
    });
};

    // Filtrer et rechercher les événements
    const filterEvents = () => {
        const searchText = searchBar.value.toLowerCase();
        const selectedCategories = Array.from(categoryFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const filteredEvents = events.filter(event => {
            const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(event.category);
            const matchesSearch = event.title.toLowerCase().includes(searchText);
            return matchesCategory && matchesSearch;
        });

        displayEvents(filteredEvents);
    };

    searchBar.addEventListener('input', filterEvents);
    categoryFilters.forEach(checkbox => checkbox.addEventListener('change', filterEvents));

    // Afficher tous les événements au chargement de la page
    displayEvents(events);
});
