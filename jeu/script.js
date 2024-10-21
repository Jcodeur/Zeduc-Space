let randomNumber = Math.floor(Math.random() * 1000) + 1;
let attemptsLeft = 5;

function playGame() {
    const userGuess = parseInt(document.getElementById("guess").value);
    const resultText = document.getElementById("result");
    const attemptsText = document.getElementById("attempts");

    if (userGuess === randomNumber) {
        resultText.textContent = "Bravo ! Vous avez deviné le bon nombre.";
        attemptsLeft = 0;
    } else {
        attemptsLeft--;
        if (attemptsLeft > 0) {
            resultText.textContent = userGuess > randomNumber ? "Trop grand !" : "Trop petit !";
            attemptsText.textContent = `Nombre d'essais restant: ${attemptsLeft}`;
        } else {
            resultText.textContent = `Perdu ! Le bon nombre était ${randomNumber}.`;
            attemptsText.textContent = "Nombre d'essais restant: 0";
        }
    }
}
