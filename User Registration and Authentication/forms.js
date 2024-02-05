document.addEventListener('DOMContentLoaded', function () {
    // Get the register link and both the login and registration forms
    const registerLink = document.getElementById('registerLink');
    const loginForm = document.querySelector('.form.login');
    const registrationForm = document.querySelector('.form.registration');

    // Add a click event listener to the register link
    registerLink.addEventListener('click', function (event) {
        // Prevent the default link behavior
        event.preventDefault();

        // Toggle the 'hidden-form' class on the login and registration forms
        loginForm.classList.toggle('hidden-form');
        registrationForm.classList.toggle('hidden-form');
    });
});
        
