document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('nav a');
    const sections = document.querySelectorAll('.section');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1); // Récupérer l'ID cible sans le #
            const targetElement = document.getElementById(targetId); // Trouver l'élément correspondant

            if (targetElement) {
                // Masquer toutes les sections
                sections.forEach(section => {
                    section.classList.remove('open');
                });

                // Afficher la section cible
                targetElement.classList.add('open');
                targetElement.scrollIntoView({ behavior: 'smooth' });
            } else {
                console.error('La section cible est introuvable :', targetId);
            }
        });
    });
});
