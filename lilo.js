document.addEventListener('DOMContentLoaded', (event) => {
    const container = document.getElementById('container');
    const registerButton = document.getElementById('register');
    const loginButton = document.getElementById('login');

    registerButton.addEventListener('click', function(){
        container.classList.add('active');
        container.classList.remove('close');
    });

    loginButton.addEventListener('click', function(){
        container.classList.add('close');
        container.classList.remove('active');
    });
});
