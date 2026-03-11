// Site Components Initialization
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

    // Priority 3: Calculator (if on home page)
    if (document.getElementById('monthly-savings')) {
        initSavingsCalculator();
    }

    // Priority 4: USSD Simulator (if on mobile services page)
    if (document.getElementById('ussd-screen')) {
        initUSSDSimulator();
    }

    // Priority 5: FAQ Accordions
    initAccordions();

    // Priority 6: Page Loader Handoff
    handleLoader();
});

function handleLoader() {
    const loader = document.getElementById('loader-wrapper');
    if (!loader) return;

    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('hide-loader');
            setTimeout(() => {
                loader.remove();
            }, 800);
        }, 800);
    });

    // Fallback
    setTimeout(() => {
        if (document.body.contains(loader)) {
            loader.classList.add('hide-loader');
            setTimeout(() => loader.remove(), 800);
        }
    }, 3000);
}

function initMobileMenu() {
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const hasDropdowns = document.querySelectorAll('.has-dropdown');

    if (!menuToggle || !navMenu) return;

    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        navMenu.classList.toggle('active');

        if (navMenu.classList.contains('active')) {
            menuToggle.innerHTML = '&times;';
            document.body.style.overflow = 'hidden';
        } else {
            menuToggle.innerHTML = '&#9776;';
            document.body.style.overflow = '';
        }
    });

    hasDropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('a');
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                dropdown.classList.toggle('active');
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

    const siteIndex = [
        { title: "Home", url: "index.html", content: "Main landing page, NSLS overview" },
        { title: "About Us", url: "about.html", content: "Our story, mission, vision, board" },
        { title: "General Savings", url: "general-savings.html", content: "Savings account for individuals, S1 account" },
        { title: "Education Savings", url: "education-savings.html", content: "Save for school fees, S2 account" },
        { title: "Christmas Savings", url: "christmas-savings.html", content: "Savings for festive season, S3 account" },
        { title: "Loans", url: "loans.html", content: "Personal loans, 1:1 loans, 1:2 loans, 1:5 loans" },
        { title: "Mobile Service", url: "mobile-service.html", content: "Mobile banking, *155#, USSD" },
        { title: "Downloads", url: "downloads.html", content: "Forms, brochures, loan applications" },
        { title: "FAQs", url: "faqs.html", content: "Frequently asked questions, support" },
        { title: "Contact", url: "contact.html", content: "Get in touch, contact details" },
        { title: "Our Offices", url: "offices.html", content: "Branch locations, maps, addresses" }
    ];

    searchTrigger.addEventListener('click', () => {
        searchOverlay.classList.add('active');
        setTimeout(() => searchInput.focus(), 300);
    });

    searchClose.addEventListener('click', () => {
        searchOverlay.classList.remove('active');
    });

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
                item.innerHTML = `<h4>${result.title}</h4><p>${result.content}</p>`;
                searchResults.appendChild(item);
            });
        }
    });
}

function initHeroCarousel() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    if (!slides.length) return;

    let currentSlide = 0;
    let slideInterval = setInterval(() => showSlide(currentSlide + 1), 5000);

    function showSlide(n) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function resetInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(() => showSlide(currentSlide + 1), 5000);
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetInterval();
        });
    });
}

function initSavingsCalculator() {
    const monthlyInput = document.getElementById('monthly-savings');
    const rateInput = document.getElementById('interest-rate');
    const monthsInput = document.getElementById('calc-months');
    const totalDisplay = document.getElementById('calc-total');
    const interestDisplay = document.getElementById('calc-interest');

    function calculate() {
        const P = 0; // Starting balance
        const PMT = parseFloat(monthlyInput.value) || 0;
        const r = (parseFloat(rateInput.value) || 0) / 100 / 12;
        const n = parseInt(monthsInput.value) || 0;

        // Future Value of Annuity formula: FV = PMT * [((1 + r)^n - 1) / r]
        let fv = 0;
        if (r === 0) {
            fv = PMT * n;
        } else {
            fv = PMT * ((Math.pow(1 + r, n) - 1) / r) * (1 + r);
        }

        const totalInvested = PMT * n;
        const interestEarned = fv - totalInvested;

        totalDisplay.innerText = `K ${fv.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        interestDisplay.innerText = `K ${interestEarned.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    [monthlyInput, rateInput, monthsInput].forEach(input => {
        input.addEventListener('input', calculate);
    });
    calculate();
}

function initUSSDSimulator() {
    const screen = document.getElementById('ussd-screen');
    const buttons = document.querySelectorAll('.sim-btn');
    if (!screen) return;

    const menus = {
        start: { text: "NSLS Mobile Banking\n1. Balance Inquiry\n2. Mini Statement\n3. Funds Transfer\n0. Exit", next: "main" },
        balance: { text: "Your S1 Balance is:\nK 1,250.45\n\n0. Back", next: "start" },
        mini: { text: "Last 3 Trx:\n12/10 DEP K200\n05/10 WDL K50\n01/10 DEP K200\n0. Back", next: "start" }
    };

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.innerText;
            if (val === 'CALL') {
                screen.innerText = menus.start.text;
            } else if (val === '0') {
                screen.innerText = "Connection closed.";
            } else if (val === '1') {
                screen.innerText = menus.balance.text;
            } else if (val === '2') {
                screen.innerText = menus.mini.text;
            }
        });
    });
}

function initAccordions() {
    const items = document.querySelectorAll('.faq-question');
    items.forEach(item => {
        item.addEventListener('click', () => {
            const parent = item.parentElement;
            parent.classList.toggle('active');
        });
    });
}
