/*boutons Scroll partie acceuil*/
function scrollToTop(){
	window.scrollTo({
		top: 0,
		behavior: 'smooth'
	});
}
function scrollToFooter(){
	const footer = document.getElementById("footer");
	footer.scrollIntoView({ behavior: 'smooth'});
}

/*Partie 3 nos offres*/
function filterOffers(level, event){
	const allOffers = document.querySelectorAll('.offer-box');
	allOffers.forEach(box => { box.style.display = (box.dataset.level === level ) ? 'block' : 'none'; });
	
	document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
	event.target.classList.add('active');
}
window.onload = function(){
	filterOffers('ابتدائي',{ target: document.querySelector('.tab.active') });
};

// JS pour alterner entre login et register avec animation
const showRegister = document.getElementById('show-register');
const showLogin = document.getElementById('show-login');
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');

// au début login form est visible
loginForm.classList.add('visible');

showRegister.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.classList.add('hidden');
    setTimeout(() => {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        registerForm.classList.remove('hidden');
        registerForm.classList.add('visible');
    }, 300);
});

showLogin.addEventListener('click', (e) => {
    e.preventDefault();
    registerForm.classList.add('hidden');
    setTimeout(() => {
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
        loginForm.classList.remove('hidden');
        loginForm.classList.add('visible');
    }, 300);
});
// admin.js
document.addEventListener('DOMContentLoaded', function() {
    // Activer les tooltips Bootstrap
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Confirmation avant suppression
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Confirmez la suppression ?')) {
                e.preventDefault();
            }
        });
    });
});