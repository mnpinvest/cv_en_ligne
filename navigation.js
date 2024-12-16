document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('nav a');
    const sections = document.querySelectorAll('.section-content');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId).querySelector('.section-content');

            if (targetElement) {
                if (targetElement.classList.contains('open')) {
                    // Si la section est déjà ouverte, la fermer
                    targetElement.classList.remove('open');
                } else {
                    // Sinon, fermer toutes les sections et ouvrir la section ciblée
                    sections.forEach(section => {
                        section.classList.remove('open');
                    });
                    targetElement.classList.add('open');
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                console.error('La section cible est introuvable :', targetId);
            }
        });
    });
});

