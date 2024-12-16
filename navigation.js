document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('nav a');
    const sections = document.querySelectorAll('.section-content');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId).querySelector('.section-content');

            if (targetElement) {
                sections.forEach(section => {
                    section.classList.remove('open');
                });
                targetElement.classList.add('open');
                targetElement.scrollIntoView({ behavior: 'smooth' });
            } else {
                console.error('La section cible est introuvable :', targetId);
            }
        });
    });
});
