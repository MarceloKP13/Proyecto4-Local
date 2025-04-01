document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hambur');
    const navMenu = document.querySelector('.nav-menu');
    
    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        const isClickInside = navMenu.contains(event.target) || 
                            hamburger.contains(event.target);
        
        if (!isClickInside && navMenu.classList.contains('active')) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }
    });

    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }
    });

    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
                
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    });
});