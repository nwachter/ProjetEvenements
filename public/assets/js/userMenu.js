const body = document.querySelector('body');
const userMenuButton = document.getElementById('userMenuButton');


//User menu dropdown
userMenuButton.addEventListener('click', function () {
    let menu = document.getElementById('userMenu');
    menu.classList.toggle('hidden');
});

// Optionally, close the menu if the user clicks outside of it
document.addEventListener('click', function (e) {
    let menuButton = document.getElementById('userMenuButton');
    let menu = document.getElementById('userMenu');

    if (!menuButton.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
