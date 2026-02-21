# 🏦 Nambawan Savings & Loan Society (NSLS) — Website

> Official website for **Nambawan Savings & Loan Society (NSLS)** — a savings and loan society established to serve the short-term financial needs of Nambawan Super Fund members across Papua New Guinea.

---

## 🌐 Live Site

Hosted via GitHub Pages (or your preferred host):  
👉 `https://wicked3000.github.io/nsls-website/`

---

## 📋 About the Project

The NSLS website provides members and the public with information on:
- Savings products (General, Education, Christmas)
- Loan products (1:1, 1:2, 1:5 ratios)
- Mobile banking via `*155#` USSD
- Branch office locations across PNG
- Downloadable forms and brochures
- A contact form for enquiries

---

## ✨ Features

- ⚡ **Physics-based UI** — Interactive elements powered by [Matter.js](https://brm.io/matter-js/)
- 🗺️ **Interactive Map** — Nationwide branch map using [Leaflet.js](https://leafletjs.com/)
- 📬 **Contact Forms** — Wired to [Formspree](https://formspree.io) for email delivery (no backend required)
- 🔍 **Site Search** — Instant keyword search across all pages
- 📱 **Fully Responsive** — Mobile-first navigation with hamburger menu
- 🎠 **Hero Carousel** — Auto-rotating hero banner with manual dot navigation
- ✨ **Cursor Particle Trail** — Subtle animated particle effects on mouse movement
- 🌀 **Page Loader** — Branded loading screen on every page

---

## 🗂️ File Structure

```
nsls-website/
├── index.html              # Home page
├── about.html              # About Us
├── services.html           # Products & Services overview
├── general-savings.html    # General Savings (S1 Account)
├── education-savings.html  # Education Savings (S2 Account)
├── christmas-savings.html  # Christmas Savings (S3 Account)
├── loans.html              # Loan Products
├── mobile-service.html     # Mobile Banking (*155#)
├── downloads.html          # Forms & Brochures
├── faqs.html               # Frequently Asked Questions
├── contact.html            # Contact Form & Office Details
├── offices.html            # Branch Office Locations
├── style.css               # Global stylesheet
├── script.js               # Shared JavaScript (physics, carousel, search)
├── png_map.svg             # Papua New Guinea SVG map asset
├── .gitignore              # Git ignore rules
└── images/
    ├── Logo.jpg            # NSLS logo
    ├── nsls3_new.jpg       # Hero banner image
    └── vector.jpg          # Additional graphic asset
```

---

## 🛠️ Tech Stack

| Technology | Purpose |
|---|---|
| HTML5 | Page structure & semantics |
| CSS3 (Vanilla) | Styling, animations, responsive layout |
| JavaScript (ES6+) | Interactivity, physics, carousel, search |
| [Matter.js](https://brm.io/matter-js/) `v0.19` | Physics engine for interactive UI elements |
| [Leaflet.js](https://leafletjs.com/) `v1.9.4` | Interactive branch location map |
| [Formspree](https://formspree.io) | Contact form email delivery |
| [Font Awesome](https://fontawesome.com/) `v6.4` | Icons |
| [Google Fonts](https://fonts.google.com/) | Inter & Outfit typography |

---

## 🚀 Getting Started (Local Development)

No build tools or dependencies required — this is a pure HTML/CSS/JS project.

### 1. Clone the repository
```bash
git clone https://github.com/Wicked3000/nsls-website.git
cd nsls-website
```

### 2. Open in browser
Simply open `index.html` in your browser, or use a local dev server:

```bash
# Using VS Code Live Server extension (recommended)
# Right-click index.html → "Open with Live Server"

# Or using Python
python -m http.server 8080
# Then visit http://localhost:8080
```

---

## 📬 Contact Form Setup (Formspree)

The contact forms use [Formspree](https://formspree.io) for email delivery.

To activate:
1. Sign up at [formspree.io](https://formspree.io)
2. Create a new form and copy your **Form ID** (e.g. `abcxyz12`)
3. In `contact.html`, replace **both** occurrences of `YOUR_FORM_ID`:
   ```html
   action="https://formspree.io/f/YOUR_FORM_ID"
   ```

---

## 🔄 Deploying Updates

After making changes locally:

```bash
git add .
git commit -m "brief description of your changes"
git push
```

---

## 🌍 Deploying to GitHub Pages

1. Go to your repo on GitHub
2. Click **Settings** → **Pages**
3. Under **Source**, select `main` branch → `/ (root)` folder
4. Click **Save**
5. Your site will be live at `https://wicked3000.github.io/nsls-website/`

---

## 📞 Organisation Contact

| | |
|---|---|
| **Phone** | Call Centre: 1599 |
| **Fax** | +675 32144046 |
| **Email** | nsls@nambawansuper.com.pg |
| **Address** | Level 2, Deloitte Haus, McGregor St, Port Moresby, PNG |
| **Postal** | P.O. Box 483, Port Moresby 121, NCD, PNG |
| **Website** | [www.nambawansuper.com.pg/nsls](http://www.nambawansuper.com.pg/nsls) |

---

## 📄 Licence

© 2026 Nambawan Savings & Loan Society. All rights reserved.  
This codebase is proprietary and intended for internal/official use only.
