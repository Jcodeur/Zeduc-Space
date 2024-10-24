
// Fonction pour ajouter un événement
function ajouterEvent() {
    const nomEvent = document.getElementById('nomEvent').value;
    const descriptionEvent = document.getElementById('descriptionEvent').value;
    const categorieEvent = document.getElementById('categorieEvent').value;
    const imageEvent = document.getElementById('imageEvent').files[0];

    if (!nomEvent || !descriptionEvent || !categorieEvent || !imageEvent) {
        alert('Veuillez remplir tous les champs.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
        const imageDataUrl = event.target.result;

        // Créer un nouvel objet événement
        const nouvelEvent = {
            id: Date.now(),
            title: nomEvent,
            description: descriptionEvent,
            category: categorieEvent,
            image: imageDataUrl
        };

        // Récupérer les événements existants depuis le localStorage
        const evenements = JSON.parse(localStorage.getItem('evenements')) || [];
        evenements.push(nouvelEvent);

        // Sauvegarder à nouveau les événements dans le localStorage
        localStorage.setItem('evenements', JSON.stringify(evenements));

        // Réinitialiser le formulaire
        document.getElementById('eventForm').reset();

        // Rafraîchir l'affichage des événements
        afficherEvenements();
    };

    reader.readAsDataURL(imageEvent);
}



// Fonction pour supprimer un événement
function supprimerEvent() {
    const nomPlat = document.getElementById('nomPlat').value;

    if (!nomPlat) {
        alert('Veuillez entrer un nom pour supprimer un événement.');
        return;
    }

    // Récupérer les événements depuis le localStorage
    let evenements = JSON.parse(localStorage.getItem('evenements')) || [];

    // Filtrer la liste pour enlever l'événement qui correspond au nom donné
    const nouvelleListeEvenements = evenements.filter(event => event.title !== nomPlat);

    if (evenements.length === nouvelleListeEvenements.length) {
        alert('Événement non trouvé.');
    } else {
        // Sauvegarder la nouvelle liste dans le localStorage
        localStorage.setItem('evenements', JSON.stringify(nouvelleListeEvenements));
        alert('Événement supprimé avec succès.');
        
        // Réinitialiser le formulaire et rafraîchir l'affichage
        document.getElementById('deleteForm').reset();
        afficherEvenements();
    }
}



document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    const categoryFilters = document.querySelectorAll('.category-filter');
    const eventsContainer = document.getElementById('eventsContainer');

    // Fonction pour afficher les événements stockés
    function afficherEvenements(filteredEvents = null) {
        const evenements = JSON.parse(localStorage.getItem('evenements')) || [];
        const container = document.getElementById('eventsContainer');
        container.innerHTML = ''; // Vider le conteneur avant de le remplir

        // Si aucun filtrage n'est fourni, afficher tous les événements
        const eventsToDisplay = filteredEvents || evenements;

        eventsToDisplay.forEach(event => {
            const card = `
                <div class="col-md-4"> 
                    <div class="card mb-4">
                        <img src="${event.image}" class="card-img-top" alt="Image de ${event.title}">
                        <div class="card-body">
                            <h5 class="card-title">${event.title}</h5>
                            <p class="card-text">${event.description}</p>
                            <p class="card-text"><small class="text-muted">${event.category}</small></p>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += card;
        });
    }

    // Ajout d'un événement
    
    // Fonction pour filtrer les événements par catégorie
    function filtrerParCategorie() {
        const evenements = JSON.parse(localStorage.getItem('evenements')) || [];
        const selectedCategories = Array.from(categoryFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        if (selectedCategories.length === 0) {
            afficherEvenements(evenements); // Si aucune catégorie sélectionnée, afficher tous les événements
            return;
        }

        const filteredEvents = evenements.filter(event => selectedCategories.includes(event.category));
        afficherEvenements(filteredEvents);
    }

    // Fonction pour rechercher les événements via la barre de recherche
    function rechercherEvenements() {
        const searchText = searchBar.value.toLowerCase();
        const evenements = JSON.parse(localStorage.getItem('evenements')) || [];

        const filteredEvents = evenements.filter(event => 
            event.title.toLowerCase().includes(searchText) || 
            event.description.toLowerCase().includes(searchText)
        );

        afficherEvenements(filteredEvents);
    }

    // Attacher les événements aux cases à cocher et à la barre de recherche
    categoryFilters.forEach(checkbox => checkbox.addEventListener('change', filtrerParCategorie));
    searchBar.addEventListener('input', rechercherEvenements);

    // Charger les événements au démarrage de la page
    afficherEvenements();
});
