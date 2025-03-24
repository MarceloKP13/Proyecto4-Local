document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
document.getElementById("eye_icon_login").addEventListener("click", togglePasswordLogin);
document.getElementById("eye_icon_register").addEventListener("click", togglePasswordRegister);
window.addEventListener('resize', ajustarInterfaz);
window.addEventListener('load', ajustarInterfaz);

document.getElementById("admin_check").addEventListener("change", function() {
    var adminPinDiv = document.getElementById("admin_pin_div");
    if (this.checked) {
        adminPinDiv.style.display = "block";
    } else {
        adminPinDiv.style.display = "none";
    }
});

// Variables
var contenedorLoginRegister = document.querySelector(".contenedor__login-register");
var formularioLogin = document.querySelector(".formulario__login");
var formularioRegister = document.querySelector(".formulario__register");
var cajaTraseraLogin = document.querySelector(".caja__trasera-login");
var cajaTraseraRegister = document.querySelector(".caja__trasera-register");

function togglePasswordLogin() {
    var passwordField = document.getElementById("contrasena_login");
    var eyeIcon = document.getElementById("eye_icon_login").querySelector("i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function togglePasswordRegister() {
    var passwordField = document.getElementById("contrasena_register");
    var eyeIcon = document.getElementById("eye_icon_register").querySelector("i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function iniciarSesion() {
    if (window.innerWidth > 850) {
        formularioRegister.style.display = "none";
        contenedorLoginRegister.style.left = "10px";
        formularioLogin.style.display = "block";
        cajaTraseraRegister.style.opacity = "1";
        cajaTraseraLogin.style.opacity = "0";
    } else {
        formularioRegister.style.display = "none";
        contenedorLoginRegister.style.left = "0px";
        formularioLogin.style.display = "block";
        cajaTraseraRegister.style.display = "block";
        cajaTraseraLogin.style.display = "none";
    }
}

function register() {
    if (window.innerWidth > 850) {
        formularioRegister.style.display = "block";
        contenedorLoginRegister.style.left = "410px";
        formularioLogin.style.display = "none";
        cajaTraseraRegister.style.opacity = "0";
        cajaTraseraLogin.style.opacity = "1";
    } else {
        formularioRegister.style.display = "block";
        contenedorLoginRegister.style.left = "0px";
        formularioLogin.style.display = "none";
        cajaTraseraRegister.style.display = "none";
        cajaTraseraLogin.style.display = "block";
        cajaTraseraLogin.style.opacity = "1";
    }
}

function ajustarInterfaz() {
    if (window.innerWidth > 850) {
        cajaTraseraLogin.style.display = "block";
        cajaTraseraRegister.style.display = "block";
    } else {
        cajaTraseraRegister.style.display = "block";
        cajaTraseraRegister.style.opacity = "1";
        cajaTraseraLogin.style.display = "none";
        formularioLogin.style.display = "block";
        formularioRegister.style.display = "none";
        contenedorLoginRegister.style.left = "0px";
    }
}