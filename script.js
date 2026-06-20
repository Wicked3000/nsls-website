/* Paddy's Hotel & Apartments Scripts */
document.addEventListener('DOMContentLoaded', () => {
    console.log("Paddy's Hotel & Apartments site initialized.");

    // Handle Reservation Form Submission
    const reservationForm = document.getElementById('reservation-form');
    if (reservationForm) {
        reservationForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you for your reservation request! Our team will contact you shortly to confirm your stay.');
            reservationForm.reset();
        });
    }

    // Handle Contact Form Submission
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Your message has been sent successfully! Thank you for contacting Paddy\'s Hotel.');
            contactForm.reset();
        });
    }

    // Active Link Highlighting (if needed beyond static HTML)
    const currentPath = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});
