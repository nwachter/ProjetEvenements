import './userMenu.js';

function loadPage(page) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `index.php?page=administration&nb=${page}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("userContainer").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Check if the URL contains a hash and scroll to the corresponding section
document.addEventListener('DOMContentLoaded', function () {
    const sectionId = window.location.hash.substring(1); // Get the section ID from the hash

    if (sectionId) {
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});