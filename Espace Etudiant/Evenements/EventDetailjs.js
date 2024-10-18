document.addEventListener('DOMContentLoaded', () => {
    // Exemple d'événements
    const events = [
        { id: 1, title: "Fête Des X", description: "Célébrons l'innovation et la créativité dans l'informatique ensemble", image: "devine.png" },
        { id: 2, title: "Fête des O", description: "Un moment convivial pour échanger et partager nos expériences", image: "billard.png" },
        { id: 3, title: "Soirée De Réveillon", description: "Plongez dans la magie des fêtes avec un repas festif et chaleureux", image: "reveillon.png" },
        { id: 4, title: "Fête de la Gastronomie", description: "Savourez des plats raffinés et découvrez des talents culinaires locaux", image: "gastronomie.png" },
        { id: 5, title: "Ve Associative", description: "Honorez l'engagement et la solidarité avec des activités et des rencontres enrichissantes", image: "associative.png" }
    ];

    // Fonction pour récupérer les paramètres de l'URL
    const getEventIdFromURL = () => {
        const params = new URLSearchParams(window.location.search);
        return parseInt(params.get('id'));
    };

    // Récupérer l'ID de l'événement depuis l'URL
    const eventId = getEventIdFromURL();
    const event = events.find(e => e.id === eventId);

    if (event) {
        document.getElementById('eventTitle').textContent = event.title;
        document.getElementById('eventDescription').textContent = event.description;
        document.getElementById('eventImage').src = event.image;
    } else {
        document.getElementById('eventTitle').textContent = "Événement non trouvé";
        document.getElementById('eventDescription').textContent = "";
    }
});
