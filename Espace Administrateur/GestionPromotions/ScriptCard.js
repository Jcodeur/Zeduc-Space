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

// Fonction pour afficher les événements stockés
function afficherEvenements() {
    const evenements = JSON.parse(localStorage.getItem('evenements')) || [];
    const container = document.getElementById('eventsContainer');
    container.innerHTML = '';  // Vider le conteneur avant de le remplir

    evenements.forEach(event => {
        const card = `
           <div class="col-md-4"> 
                <div class="card mb-4">
                    <img src="${event.image}" class="card-img-top" alt="Image de ${event.title}">
                    <div class="card-body">
                        <p class="card-text">${event.description}</p>
                        <p class="Name">${event.title}</p>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += card;
    });
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

// Charger les événements au démarrage de la page
window.onload = afficherEvenements;
