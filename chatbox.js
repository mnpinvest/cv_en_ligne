document.addEventListener('DOMContentLoaded', function () {
    const chatbox = document.getElementById('chatbox');
    const chatboxButton = document.getElementById('chatboxButton');
    
    if (chatboxButton) {
        chatboxButton.addEventListener('click', function (event) {
            event.preventDefault();
            if (chatbox) {
                chatbox.classList.toggle('open');
            } else {
                console.error('La chatbox est introuvable');
            }
        });
    }
});
