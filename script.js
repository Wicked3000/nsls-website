const { Engine, Render, Runner, Bodies, Composite, Mouse, MouseConstraint, Events, Vector } = Matter;

// Setup Engine
const engine = Engine.create();
engine.gravity.y = 0; // Set to 0 for AntiGravity effect by default

// Elements to sync with physics
const physicsElements = [
    { id: 'phone-info', type: 'circle', mass: 1 },
    { id: 'email-info', type: 'circle', mass: 1 },
    { id: 'main-logo', type: 'rectangle', mass: 5 },
    { id: 'hero-cta', type: 'circle', mass: 2, magnetic: true },
    { id: 'icon-leaf', type: 'circle', mass: 3, interactive: true },
    { id: 'icon-lightbulb', type: 'circle', mass: 3, interactive: true },
    { id: 'icon-download', type: 'circle', mass: 3, interactive: true },
    { id: 'card-general', type: 'rectangle', mass: 8, interactive: true },
    { id: 'card-education', type: 'rectangle', mass: 8, interactive: true },
    { id: 'card-christmas', type: 'rectangle', mass: 8, interactive: true },
    { id: 'card-loans', type: 'rectangle', mass: 8, interactive: true },
    { id: 'doc-1', type: 'rectangle', mass: 2, interactive: true },
    { id: 'doc-2', type: 'rectangle', mass: 2, interactive: true },
    { id: 'doc-3', type: 'rectangle', mass: 2, interactive: true },
    { id: 'doc-4', type: 'rectangle', mass: 2, interactive: true },
    { id: 'banner-apply', type: 'rectangle', mass: 15 },
    { id: 'footer-about', type: 'rectangle', mass: 10, interactive: true },
    { id: 'footer-links', type: 'rectangle', mass: 10, interactive: true },
    { id: 'footer-message', type: 'rectangle', mass: 10, interactive: true },
    { id: 'footer-search', type: 'rectangle', mass: 10, interactive: true },
    { id: 'about-intro', type: 'rectangle', mass: 15 },
    { id: 'stats-members', type: 'rectangle', mass: 12, interactive: true },
    { id: 'service-general', type: 'rectangle', mass: 8, interactive: true },
    { id: 'service-education', type: 'rectangle', mass: 8, interactive: true },
    { id: 'service-christmas', type: 'rectangle', mass: 8, interactive: true },
    { id: 'loan-11', type: 'rectangle', mass: 8, interactive: true },
    { id: 'loan-12', type: 'rectangle', mass: 8, interactive: true },
    { id: 'loan-15', type: 'rectangle', mass: 8, interactive: true },
    { id: 'form-membership', type: 'rectangle', mass: 5, interactive: true },
    { id: 'form-update', type: 'rectangle', mass: 5, interactive: true },
    { id: 'form-pikinini', type: 'rectangle', mass: 5, interactive: true },
    { id: 'form-loan', type: 'rectangle', mass: 5, interactive: true },
    { id: 'brochure-savings', type: 'rectangle', mass: 7, interactive: true },
    { id: 'brochure-loans', type: 'rectangle', mass: 7, interactive: true },
    { id: 'faq-1', type: 'rectangle', mass: 10, interactive: true },
    { id: 'faq-2', type: 'rectangle', mass: 10, interactive: true },
    { id: 'faq-3', type: 'rectangle', mass: 10, interactive: true },
    { id: 'contact-form-box', type: 'rectangle', mass: 20 },
    { id: 'office-details', type: 'rectangle', mass: 15 },
    { id: 'about-what', type: 'rectangle', mass: 12, interactive: true },
    { id: 'about-why', type: 'rectangle', mass: 15, interactive: true },
    { id: 'about-eligible', type: 'rectangle', mass: 12, interactive: true },
    { id: 'about-governance', type: 'rectangle', mass: 18, interactive: true },
    { id: 'about-banner-apply', type: 'rectangle', mass: 20 },
    { id: 'social-strip', type: 'rectangle', mass: 8, interactive: true },
    { id: 'about-sidebar', type: 'rectangle', mass: 15, interactive: true },
    { id: 'prod-general', type: 'rectangle', mass: 10, interactive: true },
    { id: 'prod-education', type: 'rectangle', mass: 10, interactive: true },
    { id: 'prod-christmas', type: 'rectangle', mass: 10, interactive: true },
    { id: 'prod-loan', type: 'rectangle', mass: 10, interactive: true },
    { id: 'prod-mobile', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-services', type: 'rectangle', mass: 8, interactive: true },
    { id: 'social-strip-downloads', type: 'rectangle', mass: 8, interactive: true },

    // Member Forms
    { id: 'form-factsheet', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-membership', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-update', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-iatd', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-pikinini', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-loan-advance', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-loan-1-2', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-loan-1-5', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-loan-teacher', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-loan-schedule', type: 'rectangle', mass: 6, interactive: true },
    { id: 'form-withdrawal', type: 'rectangle', mass: 6, interactive: true },

    // Brochures
    { id: 'brochure-tertiary', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-housing', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-pikinini', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-loan-1-1', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-loan-1-2', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-1-5', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-nsls-loans', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-nsls-savings', type: 'rectangle', mass: 6, interactive: true },
    { id: 'brochure-nsls-services', type: 'rectangle', mass: 6, interactive: true },

    { id: 'social-strip-faqs', type: 'rectangle', mass: 8, interactive: true },
    { id: 'main-faqs', type: 'rectangle', mass: 15, interactive: true },
    { id: 'faq-gen-1', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq-gen-2', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq-gen-3', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq-gen-4', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq-gen-5', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq-gen-6', type: 'rectangle', mass: 5, interactive: true },
    { id: 'social-strip-contact', type: 'rectangle', mass: 8, interactive: true },
    { id: 'contact-form-box', type: 'rectangle', mass: 20, interactive: true },
    { id: 'info-topics', type: 'rectangle', mass: 10, interactive: true },
    { id: 'head-office', type: 'rectangle', mass: 10, interactive: true },
    { id: 'postal-info', type: 'rectangle', mass: 8, interactive: true },
    { id: 'branch-info', type: 'rectangle', mass: 12, interactive: true },
    { id: 'branch-proper-map', type: 'rectangle', mass: 50, interactive: true },
    { id: 'offices-grid', type: 'rectangle', mass: 10, interactive: true },
    { id: 'office-headoffice', type: 'rectangle', mass: 10, interactive: true },
    { id: 'office-alotau', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-buka', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-goroka', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-kavieng', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-kimbe', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-kiunga', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-kokopo', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-lae', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-hagen', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-madang', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-wewak', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-kundiawa', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-manus', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-mendi', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-popondetta', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-vanimo', type: 'rectangle', mass: 8, interactive: true },
    { id: 'office-wabag', type: 'rectangle', mass: 8, interactive: true },
    { id: 'social-strip-offices', type: 'rectangle', mass: 8, interactive: true },

    // General Savings
    { id: 'gs-purpose', type: 'rectangle', mass: 10, interactive: true },
    { id: 'gs-rates', type: 'rectangle', mass: 10, interactive: true },
    { id: 'gs-withdrawals', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-gs', type: 'rectangle', mass: 8, interactive: true },
    { id: 'gs-sidebar', type: 'rectangle', mass: 20, interactive: true },

    // Education Savings
    { id: 'edu-purpose', type: 'rectangle', mass: 10, interactive: true },
    { id: 'edu-contributions', type: 'rectangle', mass: 10, interactive: true },
    { id: 'edu-access', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-edu', type: 'rectangle', mass: 8, interactive: true },
    { id: 'edu-sidebar', type: 'rectangle', mass: 20, interactive: true },

    // Christmas Savings
    { id: 'xmas-purpose', type: 'rectangle', mass: 10, interactive: true },
    { id: 'xmas-features', type: 'rectangle', mass: 10, interactive: true },
    { id: 'xmas-access', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-xmas', type: 'rectangle', mass: 8, interactive: true },
    { id: 'xmas-sidebar', type: 'rectangle', mass: 20, interactive: true },

    // Loans
    { id: 'loan-overview', type: 'rectangle', mass: 10, interactive: true },
    { id: 'loan-1-1', type: 'rectangle', mass: 10, interactive: true },
    { id: 'loan-1-5', type: 'rectangle', mass: 10, interactive: true },
    { id: 'loan-eligibility', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-loans', type: 'rectangle', mass: 8, interactive: true },
    { id: 'loans-sidebar', type: 'rectangle', mass: 20, interactive: true },

    // Mobile Service
    { id: 'mobile-overview', type: 'rectangle', mass: 10, interactive: true },
    { id: 'mobile-access', type: 'rectangle', mass: 10, interactive: true },
    { id: 'mobile-features', type: 'rectangle', mass: 10, interactive: true },
    { id: 'social-strip-mobile', type: 'rectangle', mass: 8, interactive: true },
    { id: 'mobile-faqs', type: 'rectangle', mass: 15, interactive: true },
    { id: 'faq1', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq2', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq3', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq4', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq5', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq6', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq7', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq8', type: 'rectangle', mass: 5, interactive: true },
    { id: 'faq9', type: 'rectangle', mass: 5, interactive: true },
    { id: 'mobile-sidebar', type: 'rectangle', mass: 20, interactive: true },

    { id: 'footer', type: 'rectangle', mass: 100, isStatic: true }
];

const bodies = [];
const elementsMap = new Map();

function initPhysics() {
    const canvas = document.getElementById('physics-canvas');
    const width = window.innerWidth;
    const height = window.innerHeight;

    physicsElements.forEach(item => {
        const el = document.getElementById(item.id);
        if (!el) return;

        const rect = el.getBoundingClientRect();
        let body;

        if (item.type === 'circle') {
            body = Bodies.circle(
                rect.left + rect.width / 2,
                rect.top + rect.height / 2,
                Math.max(rect.width, rect.height) / 2,
                {
                    frictionAir: 0.1,
                    restitution: 0.8,
                    render: { visible: false },
                    isStatic: item.reveal === 'fall' // Start as static if it needs to fall later
                }
            );
        } else {
            body = Bodies.rectangle(
                rect.left + rect.width / 2,
                rect.top + rect.height / 2,
                rect.width,
                rect.height,
                {
                    frictionAir: 0.1,
                    restitution: 0.6,
                    render: { visible: false },
                    isStatic: item.reveal === 'fall'
                }
            );
        }

        body.meta = item;
        bodies.push(body);
        elementsMap.set(body.id, el);
        Composite.add(engine.world, body);
    });

    // Add boundaries (walls) to keep things from flying off
    const wallOptions = { isStatic: true, render: { visible: false } };
    Composite.add(engine.world, [
        Bodies.rectangle(width / 2, -50, width, 100, wallOptions), // Top
        Bodies.rectangle(width / 2, height + 50, width, 100, wallOptions), // Bottom
        Bodies.rectangle(-50, height / 2, 100, height, wallOptions), // Left
        Bodies.rectangle(width + 50, height / 2, 100, height, wallOptions) // Right
    ]);

    // Mouse control
    const mouse = Mouse.create(document.body);
    const mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            stiffness: 0.2,
            render: { visible: false }
        }
    });

    Composite.add(engine.world, mouseConstraint);

    // Animation Loop
    (function update() {
        Engine.update(engine, 1000 / 60);

        bodies.forEach(body => {
            const el = elementsMap.get(body.id);
            if (!el) return;

            // Update DOM element position based on physics body
            const { x, y } = body.position;
            const angle = body.angle;

            // Only apply transforms if the body isn't static (or after reveal)
            if (!body.isStatic) {
                // We use translate3d for performance
                el.style.transform = `translate3d(${x - body.initialX}px, ${y - body.initialY}px, 0) rotate(${angle}rad)`;
            } else {
                body.initialX = x;
                body.initialY = y;
            }

            // Magnetic effect for CTA
            if (body.meta.magnetic) {
                const dist = Vector.magnitude(Vector.sub(mouse.position, body.position));
                if (dist < 200) {
                    const force = Vector.mult(Vector.normalise(Vector.sub(mouse.position, body.position)), 0.005);
                    Matter.Body.applyForce(body, body.position, force);
                }
            }
        });

        // Floating effect (gentle bobbing)
        bodies.forEach(body => {
            if (!body.isStatic) {
                const buoyancy = -0.0001 * body.mass;
                Matter.Body.applyForce(body, body.position, { x: 0, y: buoyancy });
            }
        });

        requestAnimationFrame(update);
    })();

    // Reveal animations on scroll
    window.addEventListener('scroll', () => {
        bodies.forEach(body => {
            if (body.meta.reveal === 'fall' && body.isStatic) {
                const el = elementsMap.get(body.id);
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.8) {
                    Matter.Body.setStatic(body, false);
                    el.style.opacity = '1';
                    engine.gravity.y = 1; // Temporarily enable gravity for fall
                    setTimeout(() => { engine.gravity.y = 0; }, 2000);
                }
            }
        });
    });
}

// Particle system for cursor trail
const particles = [];
function createParticle(x, y) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    particle.style.left = `${x}px`;
    particle.style.top = `${y}px`;
    document.body.appendChild(particle);

    const velocity = {
        x: (Math.random() - 0.5) * 4,
        y: (Math.random() - 0.5) * 4
    };

    particles.push({ el: particle, x, y, vx: velocity.x, vy: velocity.y, life: 1 });
}

function updateParticles() {
    for (let i = particles.length - 1; i >= 0; i--) {
        const p = particles[i];
        p.life -= 0.015;
        if (p.life <= 0) {
            p.el.remove();
            particles.splice(i, 1);
            continue;
        }
        p.x += p.vx;
        p.y += p.vy;
        p.el.style.transform = `translate3d(${p.x - p.el.offsetLeft}px, ${p.y - p.el.offsetTop}px, 0)`;
        p.el.style.opacity = p.life;
    }
    requestAnimationFrame(updateParticles);
}

// Initial reveal animations (CSS-based first then physics handoff)
document.addEventListener('DOMContentLoaded', () => {
    // Priority 1: Mobile Navigation
    try {
        initMobileMenu();
    } catch (e) {
        console.error("Mobile menu init failed", e);
    }

    // Priority 2: Core Components
    try {
        initHeroCarousel();
        initSiteSearch();
    } catch (e) {
        console.error("Core components init failed", e);
    }

    // Priority 3: Visual Effects
    try {
        initPhysics();
        window.addEventListener('mousemove', (e) => {
            if (Math.random() > 0.4) createParticle(e.clientX, e.clientY);
        });
        requestAnimationFrame(updateParticles);
    } catch (e) {
        console.error("Physics effects init failed", e);
    }

    // Priority 4: Page Loader Handoff
    handleLoader();
});

function handleLoader() {
    const loader = document.getElementById('loader-wrapper');
    if (!loader) return;

    // Wait for window load (assets ready) or at least 1s for the animation to be seen
    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('hide-loader');
            // Remove from DOM after fade animation
            setTimeout(() => {
                loader.remove();
            }, 800);
        }, 1000);
    });

    // Fallback: insurance if load event doesn't fire or takes too long
    setTimeout(() => {
        if (document.body.contains(loader)) {
            loader.classList.add('hide-loader');
            setTimeout(() => loader.remove(), 800);
        }
    }, 5000);
}

function initMobileMenu() {
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const hasDropdowns = document.querySelectorAll('.has-dropdown');

    if (!menuToggle || !navMenu) return;

    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        navMenu.classList.toggle('active');
        console.log("Menu toggled", navMenu.classList.contains('active'));

        // Change icon to close if active
        if (navMenu.classList.contains('active')) {
            menuToggle.innerHTML = '&times;';
            document.body.style.overflow = 'hidden'; // Prevent scroll when menu open
        } else {
            menuToggle.innerHTML = '&#9776;'; // Hamburger icon
            document.body.style.overflow = '';
        }
    });

    // Handle dropdowns on mobile
    hasDropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('a');
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });
    });

    // Close menu when clicking a link (single page apps or same page links)
    const menuLinks = navMenu.querySelectorAll('a:not(.has-dropdown > a)');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
                menuToggle.innerHTML = '&#9776;';
            }
        });
    });
}

function initSiteSearch() {
    const searchTrigger = document.getElementById('search-trigger');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('site-search-input');
    const searchResults = document.getElementById('search-results');

    if (!searchTrigger || !searchOverlay) return;

    // Site Index (Keywords and Pages)
    const siteIndex = [
        { title: "Home", url: "index.html", content: "Main landing page, NSLS overview, welcome message" },
        { title: "About Us", url: "about.html", content: "Our story, mission, vision, board and management" },
        { title: "General Savings", url: "general-savings.html", content: "Savings account for individuals, rates, features, S1 account" },
        { title: "Education Savings", url: "education-savings.html", content: "Save for school fees, school fee saver, S2 account" },
        { title: "Christmas Savings", url: "christmas-savings.html", content: "Savings for festive season, Christmas account, S3 account" },
        { title: "Loans", url: "loans.html", content: "Personal loans, 1:1 loans, 1:2 loans, 1:5 loans, eligibility" },
        { title: "Mobile Service", url: "mobile-service.html", content: "Mobile banking, *155#, check balance, transfers, USSD" },
        { title: "Downloads", url: "downloads.html", content: "Forms, brochures, loan applications, membership forms" },
        { title: "FAQs", url: "faqs.html", content: "Frequently asked questions, support, help, how do I" },
        { title: "Contact", url: "contact.html", content: "Get in touch, contact details, email, phone, location" },
        { title: "Our Offices", url: "offices.html", content: "Branch locations, maps, addresses, Port Moresby, Lae, Hagen" }
    ];

    searchTrigger.addEventListener('click', () => {
        searchOverlay.classList.add('active');
        setTimeout(() => searchInput.focus(), 300);
    });

    searchClose.addEventListener('click', () => {
        searchOverlay.classList.remove('active');
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') searchOverlay.classList.remove('active');
    });

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        searchResults.innerHTML = '';

        if (query.length < 2) return;

        const results = siteIndex.filter(item =>
            item.title.toLowerCase().includes(query) ||
            item.content.toLowerCase().includes(query)
        );

        if (results.length > 0) {
            results.forEach(result => {
                const item = document.createElement('a');
                item.className = 'search-result-item';
                item.href = result.url;
                item.innerHTML = `
                    <h4>${result.title}</h4>
                    <p>${result.content}</p>
                    <span class="result-url">nambawansavings.com.pg/${result.url}</span>
                `;
                searchResults.appendChild(item);
            });
        } else {
            searchResults.innerHTML = '<p style="color:white; text-align:center;">No results found for "' + query + '"</p>';
        }
    });
}

function initHeroCarousel() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    if (!slides.length) return;

    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds

    function showSlide(n) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    // Auto slide
    let timer = setInterval(nextSlide, slideInterval);

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            // Reset timer on manual interaction
            clearInterval(timer);
            timer = setInterval(nextSlide, slideInterval);
        });
    });
}

// Handle window resize
window.addEventListener('resize', () => {
    // In a real app we'd re-init or update boundaries
});
