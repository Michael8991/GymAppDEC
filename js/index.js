//Señalar label parte login

document.getElementById('email').addEventListener('focus', function(){
    document.getElementById('email-wrapper').classList.add('container-blur');
    document.getElementById('email-label').classList.add('font-blur');
});

document.getElementById('email').addEventListener('blur', function(){
    document.getElementById('email-wrapper').classList.remove('container-blur');
    document.getElementById('email-label').classList.remove('font-blur');
});


document.getElementById('psw').addEventListener('focus', function(){
    document.getElementById('psw-wrapper').classList.add('container-blur');
    document.getElementById('psw-label').classList.add('font-blur');
});

document.getElementById('psw').addEventListener('blur', function(){
    document.getElementById('psw-wrapper').classList.remove('container-blur');
    document.getElementById('psw-label').classList.remove('font-blur');
});


//Cambiar login->register

document.getElementById('openRegister').addEventListener('click', function(){
    var biomboWrapper = document.getElementById('biombo-wrapper');
    biomboWrapper.classList.add('biombo-wrapper-left');
    var imageBiombo = document.getElementById('biombo');
    imageBiombo.classList.remove('biombo');
    imageBiombo.classList.add('biombo-left');
});

//Señalar label parte register

document.getElementById('register-email').addEventListener('focus', function(){
    document.getElementById('register-email-wrapper').classList.add('register-container-blur');
    document.getElementById('register-email-label').classList.add('register-font-blur');
});

document.getElementById('register-email').addEventListener('blur', function(){
    document.getElementById('register-email-wrapper').classList.remove('register-container-blur');
    document.getElementById('register-email-label').classList.remove('register-font-blur');
});

document.getElementById('register-psw').addEventListener('focus', function(){
    document.getElementById('register-psw-wrapper').classList.add('register-container-blur');
    document.getElementById('register-psw-label').classList.add('register-font-blur');
});

document.getElementById('register-psw').addEventListener('blur', function(){
    document.getElementById('register-psw-wrapper').classList.remove('register-container-blur');
    document.getElementById('register-psw-label').classList.remove('register-font-blur');
});

document.getElementById('register-psw-confirm').addEventListener('focus', function(){
    document.getElementById('register-psw-confirm-wrapper').classList.add('register-container-blur');
    document.getElementById('register-psw-confirm-label').classList.add('register-font-blur');
});

document.getElementById('register-psw-confirm').addEventListener('blur', function(){
    document.getElementById('register-psw-confirm-wrapper').classList.remove('register-container-blur');
    document.getElementById('register-psw-confirm-label').classList.remove('register-font-blur');
});

document.getElementById('register-name').addEventListener('focus', function(){
    document.getElementById('register-name-wrapper').classList.add('register-container-blur');
    document.getElementById('register-name-label').classList.add('register-font-blur');
});

document.getElementById('register-name').addEventListener('blur', function(){
    document.getElementById('register-name-wrapper').classList.remove('register-container-blur');
    document.getElementById('register-name-label').classList.remove('register-font-blur');
});


//Cambiar register->login
document.getElementById('openLogin').addEventListener('click', function(){
    var biomboWrapper = document.getElementById('biombo-wrapper');
    biomboWrapper.classList.remove('biombo-wrapper-left');
    var imageBiombo = document.getElementById('biombo');
    imageBiombo.classList.add('biombo');
    imageBiombo.classList.remove('biombo-left');
});


//Validar contraseñas

const inputPsw = document.querySelector('#register-psw');
const inputPswConfirm = document.querySelector('#register-psw-confirm');

inputPsw.addEventListener('blur', function(){
    $contrasenia1 = inputPsw.value;
    $contrasenia2 = inputPswConfirm.value;
    if($contrasenia2 !== ''){
        if($contrasenia1 !== $contrasenia2){
            alertNotMatchPsw();
            return;
        }
        alertMatchPsw();
    }
});

inputPswConfirm.addEventListener('blur', function(){
    $contrasenia1 = inputPsw.value;
    $contrasenia2 = inputPswConfirm.value;
    if($contrasenia1 !== ''){
        if($contrasenia1 !== $contrasenia2){
            alertNotMatchPsw();
            return;
        }
        alertMatchPsw();
    }
});

function alertNotMatchPsw(){
    document.getElementById('alertNotMatch').classList.add('show');
    document.getElementById('alertNotMatch2').classList.add('show');
}

function alertMatchPsw(){
    if(document.getElementById('alertNotMatch').classList.contains('show')){
        document.getElementById('alertNotMatch').classList.remove('show');
        document.getElementById('alertNotMatch2').classList.remove('show');
    }
    document.getElementById('register-submit').disabled = false;
}

//Usuario no registrado. 
document.addEventListener('DOMContentLoaded', function(){
    const loginForm = document.getElementById('login-form');
    const loginEMessage = document.getElementById('login-error-message');

    loginForm.addEventListener('submit', function(event){
        event.preventDefault();

        const formData = new FormData(loginForm);

        fetch('php/loginOP.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.success){
                var loginFormWrapper = document.getElementById('login-form-wrapper');
                loginFormWrapper.classList.add('hidden');
                setTimeout(function(){
                    window.location.href = 'php/home.php';
                }, 1000);
                
            }else if(data.message){
                loginEMessage.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${data.message}`;
                loginEMessage.classList.add('show');

                setTimeout(function(){
                    loginEMessage.classList.remove('show');
                    loginForm.reset();
                }, 3500);
            }
        })
        .catch(error => console.error('Error', error));
    });
});


//Usuario no registrado. 
document.addEventListener('DOMContentLoaded', function(){
    const registerForm = document.getElementById('register-form');
    const registerEMessage = document.getElementById('register-error-message');

    registerForm.addEventListener('submit', function(event){
        event.preventDefault();

        const formData = new FormData(registerForm);

        fetch('php/registerOP.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.success){
                var loginFormWrapper = document.getElementById('register-form-wrapper');
                loginFormWrapper.classList.add('hidden');
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 1000);
                
            }else if(data.message){
                registerEMessage.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${data.message}`;
                registerEMessage.classList.add('show');

                setTimeout(function(){
                    registerEMessage.classList.remove('show');
                    registerForm.reset();
                }, 3500);
            }
        })
        .catch(error => console.error('Error', error));
    });
});
