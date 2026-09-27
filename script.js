const loginModal = document.getElementById("loginModal");
const signupModal = document.getElementById("signupModal");
const loginBtn = document.querySelector(".login-btn");
const signupBtn = document.querySelector(".signup-btn");
const closeButtons = document.querySelectorAll(".close-btn");
const modalContents = document.querySelectorAll(".modal-content");
const profileBtn = document.querySelector('.profile-btn');
const profileModal = document.querySelector('.profile-modal');

document.querySelector(".profile-btn").addEventListener("click", function(e){
    e.preventDefault();
    console.log('Profile button clicked');
    profileModal.classList.toggle('active');
})
function openModalWithAnimation(modal) {

    modal.classList.add("show");

    setTimeout(() => {
        const content = modal.querySelector(".modal-content");
        content.classList.add("animate-in");
    }, 10);
}

function closeModalWithAnimation(modal) {
    const content = modal.querySelector(".modal-content");
    content.classList.remove("animate-in");
    content.classList.add("animate-out");

    setTimeout(() => {
        modal.classList.remove("show");
        content.classList.remove("animate-out");
    }, 300); 
}

loginBtn.addEventListener("click", function(e) {
    // e.preventDefault();
    openModalWithAnimation(loginModal);
});

signupBtn.addEventListener("click", function(e) {
    // e.preventDefault();
    openModalWithAnimation(signupModal);
});

closeButtons.forEach(button => {
    button.addEventListener("click", function() {
        const modal = this.closest(".modal");
        closeModalWithAnimation(modal);
    });
});

window.addEventListener("click", function(e) {
    if (e.target === loginModal) {
        closeModalWithAnimation(loginModal);
    }
    if (e.target === signupModal) {
        closeModalWithAnimation(signupModal);
    }
});

document.querySelector(".signup-link").addEventListener("click", function(e) {
    e.preventDefault();
    closeModalWithAnimation(loginModal);

    setTimeout(() => {
        openModalWithAnimation(signupModal);
    }, 300);
});

document.querySelector(".login-link").addEventListener("click", function(e) {
    e.preventDefault();
    closeModalWithAnimation(signupModal);
    
    setTimeout(() => {
        openModalWithAnimation(loginModal);
    }, 300);
});

document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    console.log("Login form submitted");
    closeModalWithAnimation(loginModal);
});

document.getElementById("signupForm").addEventListener("submit", function(e) {
    e.preventDefault();
    console.log("Signup form submitted");
    closeModalWithAnimation(signupModal);
});

const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

hamburger.addEventListener("click", function() {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
});

modalContents.forEach(content => {
    content.classList.add("animated");
});




    

    

    
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
           
        });

        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target) && !profileModal.contains(e.target)) {
                profileModal.classList.remove('active');
            }
        });

        profileModal.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    


