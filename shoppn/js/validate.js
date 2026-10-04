document.addEventListener('DOMContentLoaded', function () {

    const registerForm = document.getElementById('register-form');

    if (!registerForm) {
        return;
    }

    registerForm.addEventListener('submit', function (event) {

        // Get form values
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('pass').value;
        const country = document.getElementById('country').value;
        const city = document.getElementById('city').value.trim();
        const contact = document.getElementById('contact').value.trim();

        // Regular expressions
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9+\-\s]{7,15}$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;
        let valid = true;

        // Clear previous errors
        document.getElementById('name-error').textContent = '';
        document.getElementById('email-error').textContent = '';
        document.getElementById('pass-error').textContent = '';
        document.getElementById('country-error').textContent = '';
        document.getElementById('city-error').textContent = '';
        document.getElementById('contact-error').textContent = '';

        // Validate name
        if (name.length < 2 || name.length > 100) {
            document.getElementById('name-error').textContent =
                'Name must be between 2 and 100 characters.';
            valid = false;
        }

        // Validate email
        if (!emailRegex.test(email)) {
            document.getElementById('email-error').textContent =
                'Please enter a valid email address.';
            valid = false;
        }

        // Validate passwordS
        if (!passwordRegex.test(password)) {
            document.getElementById('pass-error').textContent =
                'Password must be at least 8 characters and contain a number,upper case letter and some special character.';
            valid = false;
        }

        // Validate country
        if (country === '') {
            document.getElementById('country-error').textContent =
                'Please select your country.';
            valid = false;
        }

        // Validate city
        if (city.length < 1 || city.length > 30) {
            document.getElementById('city-error').textContent =
                'Please enter a valid city.';
            valid = false;
        }

        // Validate contact
        if (!phoneRegex.test(contact)) {
            document.getElementById('contact-error').textContent =
                'Please enter a valid contact number.';
            valid = false;
        }

        // Stop form submission if validation fails
        if (!valid) {
            event.preventDefault();
            return;
        }

        // Loading state
        const button = document.getElementById('register-button');

        button.disabled = true;
        button.textContent = 'Registering...';
    });
});
