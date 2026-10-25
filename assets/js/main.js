/**
 * GREEN HORIZON — Core Application & Drone HUD Script
 * Official Erasmus+ KA210-YOU Project
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initMobileNav();
  initTelemetrySimulation();
  initCookieConsent();
  initDownloadTracking();
});

/* 1. Header Scroll Effect & Active Page Highlight */
function initHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }, { passive: true });

  // Highlight active link based on URL
  const currentPath = window.location.pathname.split('/').pop() || 'index.html';
  const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath || (currentPath === '' && href === 'index.html')) {
      link.classList.add('active');
    }
  });
}

/* 2. Mobile Navigation Drawer */
function initMobileNav() {
  const toggleBtn = document.querySelector('.mobile-nav-toggle');
  const drawer = document.querySelector('.mobile-drawer');
  const overlay = document.querySelector('.mobile-drawer-overlay');
  if (!toggleBtn || !drawer || !overlay) return;

  function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('open');
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  toggleBtn.addEventListener('click', () => {
    const isOpen = drawer.classList.contains('open');
    if (isOpen) closeDrawer();
    else openDrawer();
  });

  overlay.addEventListener('click', closeDrawer);

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('open')) {
      closeDrawer();
    }
  });

  // Close drawer on link click
  const drawerLinks = drawer.querySelectorAll('a');
  drawerLinks.forEach(link => {
    link.addEventListener('click', closeDrawer);
  });
}

/* 3. Live Telemetry HUD Simulation */
function initTelemetrySimulation() {
  const altEl = document.getElementById('hud-live-alt');
  const coordsEl = document.getElementById('hud-live-coords');
  const satsEl = document.getElementById('hud-live-sats');
  const batEl = document.getElementById('hud-live-bat');

  if (!altEl && !coordsEl) return;

  let baseAlt = 124.5;
  let baseLat = 50.7374;
  let baseLon = 7.0982;
  let sats = 18;
  let bat = 94;

  setInterval(() => {
    // Subtle realistic UAV micro-fluctuations
    const deltaAlt = (Math.random() - 0.49) * 0.4;
    baseAlt = Math.max(90, Math.min(150, baseAlt + deltaAlt));

    const deltaLat = (Math.random() - 0.5) * 0.00004;
    const deltaLon = (Math.random() - 0.5) * 0.00004;
    baseLat += deltaLat;
    baseLon += deltaLon;

    if (altEl) altEl.textContent = `${baseAlt.toFixed(1)}M AGL`;
    if (coordsEl) coordsEl.textContent = `${baseLat.toFixed(4)}°N, ${baseLon.toFixed(4)}°E`;
    if (satsEl) satsEl.textContent = `${sats} GNSS`;
    if (batEl) batEl.textContent = `${bat}%`;
  }, 2200);
}

/* 4. Privacy-Conscious Cookie Consent (GDPR Compliant) */
function initCookieConsent() {
  const banner = document.getElementById('cookie-consent-banner');
  if (!banner) return;

  const consent = localStorage.getItem('gh_cookie_consent');
  if (!consent) {
    banner.classList.remove('hidden');
  }

  const acceptBtn = document.getElementById('cookie-accept-btn');
  const declineBtn = document.getElementById('cookie-decline-btn');

  if (acceptBtn) {
    acceptBtn.addEventListener('click', () => {
      localStorage.setItem('gh_cookie_consent', 'accepted');
      banner.classList.add('hidden');
    });
  }

  if (declineBtn) {
    declineBtn.addEventListener('click', () => {
      localStorage.setItem('gh_cookie_consent', 'declined');
      banner.classList.add('hidden');
    });
  }
}

/* 5. Download Event Tracking (Privacy-safe) */
function initDownloadTracking() {
  document.addEventListener('click', (e) => {
    const target = e.target.closest('a[download], a[data-download]');
    if (target) {
      const file = target.getAttribute('href') || target.getAttribute('data-download');
      console.log(`[Green Horizon Analytics] Download tracked: ${file}`);
    }
  });
}
