document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('nav a');
    const sections = document.querySelectorAll('.section-content');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.querySelector(`#${targetId} .section-content`);

            if (targetElement) {
                // Si la section est déjà ouverte, la fermer
                if (targetElement.classList.contains('open')) {
                    targetElement.classList.remove('open');
                } else {
                    // Sinon, fermer toutes les sections et ouvrir la section ciblée
                    sections.forEach(section => {
                        section.classList.remove('open');
                    });
                    targetElement.classList.add('open');
                    targetElement.scrollIntoView({ behavior: 'smooth' });

                    // Ouvrir la Chatbox si c'est la section chatbox
                    if (targetId === 'chatbox') {
                        document.querySelector('.chatbox').style.display = 'block';
                    } else {
                        document.querySelector('.chatbox').style.display = 'none';
                    }
                }
            } else {
                console.error('La section cible est introuvable :', targetId);
            }
        });
    });
});
