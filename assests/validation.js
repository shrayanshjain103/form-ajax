const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const cpassword = document.getElementById('cpassword');

form.addEventListener('Submit', (e) => {
    e.preventDefault();

    validateInputs();
});

const setError = (element, message) => {
    const errorDisplay = element.parentElement.querySelector('.formerr');
    errorDisplay.innerText = message;
    element.parentElement.classList.add('error');
};

const setSuccess = (element) => {
    const errorDisplay = element.parentElement.querySelector('.formerr');
    errorDisplay.innerText = '';
    element.parentElement.classList.remove('error');
};

const isValidEmail = (email) => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};

const validateInputs = () => {
    const nameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const cpasswordValue = cpassword.value.trim();

    if (nameValue === '') {
        setError(username, 'Username is required');
        return false;
    } else {
        setSuccess(username);
    }

    if (emailValue === '') {
        setError(email, 'Email is required');
        return false;
    } else if (!isValidEmail(emailValue)) {
        setError(email, 'Provide a valid email address');
    } else {
        setSuccess(email);
    }

    if (passwordValue === '') {
        setError(password, 'Password is required');
        return false;
    } else if (passwordValue.length < 5) {
        setError(password, 'Password must be at least 5 characters.');
    } else {
        setSuccess(password);
    }

    if (cpasswordValue === '') {
        setError(cpassword, 'Please confirm your password');
        return false;
    } else if (cpasswordValue !== passwordValue) {
        setError(cpassword, "Passwords don't match");
    } else {
        setSuccess(cpassword);
    }
};
