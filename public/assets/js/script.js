import './userMenu.js';

//Search bar

//Search button
// document.getElementById('search-button').addEventListener('click', function (e) {
//     e.preventDefault(); // Prevent form submission
//     document.getElementById('search').classList.toggle('open');

// });

// //Search box
// document.getElementById('search').addEventListener('click', function (e) {
//     e.preventDefault(); // Prevent form submission
//     if (document.getElementById('search').classList.contains('open')) {
//         document.getElementById('search').classList.toggle('open');
//         return true;
//     }
//     // document.getElementById('search').classList.toggle('open');
// });

// document.addEventListener('click', function (e) {
//     // Get the search element and the button
//     const searchElement = document.getElementById('search');
//     const searchButton = document.getElementById('search-button');

//     if (!searchElement.contains(e.target) && !searchButton.contains(e.target)) {
//         if (searchElement.classList.contains('open')) {
//             searchElement.classList.remove('open');
//         }
//     }
// });


function validateEvent() {
    let isValid = true;
    const errorElements = document.querySelectorAll('.form_error_msg');

    // Hide all error messages first
    errorElements.forEach(el => el.classList.add('hidden'));

    // Validate each field
    const nomLieu = document.getElementById('nomLieu');
    if (!nomLieu.value || nomLieu.value.length < 3) {
        document.getElementById('error_lieu').classList.remove('hidden');
        isValid = false;
    }

    const titre = document.getElementById('titre');
    if (!titre.value || titre.value.length < 3) {
        document.getElementById('error_titre').classList.remove('hidden');
        isValid = false;
    }

    const dateEvenement = document.getElementById('dateEvenement');
    if (!dateEvenement.value) {
        document.getElementById('error_date').classList.remove('hidden');
        isValid = false;
    }

    const description = document.getElementById('description');
    if (!description.value) {
        document.getElementById('error_description').classList.remove('hidden');
        isValid = false;
    }

    const nbPlaces = document.getElementById('nbPlaces');
    if (!nbPlaces.value || nbPlaces.value < 1) {
        document.getElementById('error_nbPlaces').classList.remove('hidden');
        isValid = false;
    }

    const image = document.getElementById('image');
    if (image.files.length === 0) {
        document.getElementById('error_image').classList.remove('hidden');
        isValid = false;
    }

    return isValid;
}


//Event Handlers

// Preview image on selection
document.getElementById('image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const container = document.querySelector('label[for="image"]');
            container.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover rounded-lg" />`;
            container.style.height = 'auto';
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('mobile-menu-button').addEventListener('click', function () {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
});