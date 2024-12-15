document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('nav a');
    const sections = document.querySelectorAll('.section');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.querySelector(`#${targetId} .section-content`);

            if (targetElement) {
                // Masquer toutes les sections
                sections.forEach(section => {
                    section.querySelector('.section-content').classList.remove('open');
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
