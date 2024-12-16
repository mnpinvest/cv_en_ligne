document.addEventListener('DOMContentLoaded', function () {
    var headers = document.querySelectorAll('.section-header');

    headers.forEach(function(header) {
        header.addEventListener('click', function() {
            var content = header.nextElementSibling;
            if (content.classList.contains('open')) {
                content.classList.remove('open');
            } else {
                content.classList.add('open');
            }
        });
    });
});
