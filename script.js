document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');

    menuToggle.addEventListener('change', function () {
        if (menuToggle.checked) {
            menu.classList.add('active');
        } else {
            menu.classList.remove('active');
        }
    });
});