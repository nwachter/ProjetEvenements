import './userMenu.js';


document.getElementById('organizer_checkbox').addEventListener('change', function (e) {
    e.preventDefault(); // Prevent default behavior if necessary
    const designationInput = document.getElementById('designation_input');
    if (e.target.checked) {
        designationInput.classList.remove('hidden'); // Show the input
    } else {
        designationInput.classList.add('hidden'); // Hide the input
    }
});