const chatboxBody = document.getElementById('chatbox-body');
const userInput = document.getElementById('user-input');
const chatboxButton = document.getElementById('chatboxButton');

// Variables pour suivre la conversation
let userName = '';
let userCompany = '';
let conversationStep = 0;

// Fonction pour afficher/masquer la chatbox
function toggleChatbox() {
    const chatbox = document.getElementById('chatbox');
    if (chatbox.style.display === 'none' || !chatbox.style.display) {
        chatbox.style.display = 'block';
    } else {
        chatbox.style.display = 'none';
    }
}

// Ajouter l'événement pour le bouton de la chatbox
document.addEventListener('DOMContentLoaded', (event) => {
    if (chatboxButton) {
        chatboxButton.addEventListener('click', (event) => {
            event.preventDefault(); // Empêche le comportement par défaut du lien
            toggleChatbox();
        });
    }
});

function sendMessage() {
    const userMessage = userInput.value.trim().toLowerCase();
    if (userMessage === '') return;

    // Afficher le message de l'utilisateur
    const userMessageElement = document.createElement('div');
    userMessageElement.classList.add('message', 'user-message');
    userMessageElement.textContent = userMessage;
    chatboxBody.appendChild(userMessageElement);
    userInput.value = '';

    // Réponse du bot
    const botMessageElement = document.createElement('div');
    botMessageElement.classList.add('message', 'bot-message');
    let botResponse = 'Je suis désolé, je ne comprends pas votre question. Pouvez-vous la reformuler ou poser une autre question ?';

    if (conversationStep === 0) {
        botResponse = 'Bonjour et bienvenue sur mon site interactif ! Quel est votre nom et le nom de votre société ?';
        conversationStep = 1;
    } else if (conversationStep === 1) {
        const parts = userMessage.split(' ');
        if (parts.length >= 2) {
            userName = parts[0];
            userCompany = parts.slice(1).join(' ');
            botResponse = `Enchanté ${userName} de la société ${userCompany}. Moi, je suis Si Mohamed M'Nari. Avez-vous eu le temps de regarder mon site interactif regroupant mes expériences, mes réalisations, et mes formations ?`;
            conversationStep = 2;
        } else {
            botResponse = 'Pourriez-vous préciser votre nom et le nom de votre société ?';
        }
    } else if (conversationStep === 2) {
        botResponse = `J'ai une vaste expérience en développement commercial, notamment chez Unik Concept où j'ai géré des projets de prospection foncière et de vente immobilière. Mes compétences clés incluent l'analyse de marché, la gestion des données, la négociation, le développement de stratégies, la formation d'équipes, et la transformation digitale. Y a-t-il des domaines sur lesquels vous souhaitez en savoir plus ?`;
        conversationStep = 3;
    } else if (conversationStep === 3) {
        botResponse = 'Merci pour votre message. Pour plus d\'informations, vous pouvez télécharger mon CV ou me contacter directement via les informations de contact sur mon site. Passez une excellente journée !';
        conversationStep = 4;
    } else {
        botResponse = 'Si vous avez d\'autres questions, n\'hésitez pas à les poser !';
    }

    botMessageElement.textContent = botResponse;
    chatboxBody.appendChild(botMessageElement);
    chatboxBody.scrollTop = chatboxBody.scrollHeight;
}
