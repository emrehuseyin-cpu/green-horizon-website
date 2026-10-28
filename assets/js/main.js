/**
 * GREEN HORIZON — Core Application Script
 * Light Booklet Style (CC BY-SA 4.0)
 * Project: Green Horizon (2024-3-DE04-KA210-YOU-000293009)
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initMobileNav();
  initTimelineControls();
  initCountryTabs();
  initHomepageNewsSection();
  initCookieConsent();
  initDownloadTracking();
  initChecklistState();
});

/* 1. Header Scroll Effect & Active Page Highlight */
function initHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 30) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }, { passive: true });

  // Highlight active nav item based on clean URL
  let currentPath = (window.location.pathname.replace(/\/$/, '').split('/').pop() || '').replace(/\.html$/, '');
  const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
  navLinks.forEach(link => {
    let href = (link.getAttribute('href') || '').replace(/^\//, '').replace(/\.html$/, '').split('#')[0].split('?')[0];
    if ((currentPath === '' && (href === '' || href === '/' || href === 'index')) ||
        (currentPath !== '' && href === currentPath)) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    }
  });
}

/* 2. Mobile Navigation Drawer */
function initMobileNav() {
  const toggleBtn = document.querySelector('.mobile-nav-toggle');
  const drawer = document.querySelector('.mobile-drawer');
  const overlay = document.querySelector('.mobile-drawer-overlay');
  if (!toggleBtn || !drawer || !overlay) return;

  const closeBtn = drawer.querySelector('.mobile-drawer-close');
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

  function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('open');
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    if (closeBtn) closeBtn.focus();
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    toggleBtn.focus();
  }

  toggleBtn.addEventListener('click', () => {
    const isOpen = drawer.classList.contains('open');
    if (isOpen) closeDrawer();
    else openDrawer();
  });

  overlay.addEventListener('click', closeDrawer);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('open')) {
      closeDrawer();
    }
  });

  const drawerLinks = drawer.querySelectorAll('a');
  drawerLinks.forEach(link => {
    link.addEventListener('click', closeDrawer);
  });
}

/* 3. Homepage News & Updates (3 Latest Posts) */
function initHomepageNewsSection() {
  const newsContainer = document.getElementById('homepage-news-grid');
  if (!newsContainer) return;

  fetch('assets/data/news.json')
    .then(res => res.json())
    .then(articles => {
      // Pick top 3 newest articles
      const latestThree = articles.slice(0, 3);
      newsContainer.innerHTML = latestThree.map(item => `
        <article class="news-card">
          <img class="news-card-thumb" src="${item.image || 'assets/images/booklet-cover.jpg'}" alt="${item.title}" loading="lazy">
          <div class="news-card-body">
            <div class="news-card-meta">
              <span>🗓 ${item.date}</span>
              <span class="badge badge-completed">${item.category || 'News'}</span>
            </div>
            <h3 class="news-card-title">
              <a href="news#${item.id || item.slug}">${item.title}</a>
            </h3>
            <p class="news-card-summary">${item.summary}</p>
            <a href="news#${item.id || item.slug}" class="news-card-action">
              Read more &rarr;
            </a>
          </div>
        </article>
      `).join('');
    })
    .catch(err => {
      console.warn('Error loading homepage news:', err);
    });
}

/* 4. Privacy-Conscious Cookie Consent (GDPR / ePrivacy Directive Compliant) */
function initCookieConsent() {
  const consent = localStorage.getItem('gh_cookie_consent');
  if (consent) return;

  let banner = document.getElementById('cookie-consent-banner');
  if (!banner) {
    banner = document.createElement('div');
    banner.id = 'cookie-consent-banner';
    banner.className = 'cookie-consent-banner';
    banner.setAttribute('role', 'region');
    banner.setAttribute('aria-label', 'Cookie & Privacy Consent');
    banner.innerHTML = `
      <div class="cookie-consent-content">
        <span class="cookie-consent-icon" aria-hidden="true">🍪</span>
        <div class="cookie-consent-text">
          <strong>Privacy &amp; Cookie Preferences</strong>
          This website uses essential technical storage to ensure core features, navigation, and accessibility preferences. We do not use third-party tracking or commercial advertising cookies. Learn more in our <a href="privacy">Privacy Policy</a>.
        </div>
      </div>
      <div class="cookie-consent-actions">
        <button id="cookie-decline-btn" type="button" class="btn btn-outline btn-sm">Essential Only</button>
        <button id="cookie-accept-btn" type="button" class="btn btn-primary btn-sm">Accept All</button>
      </div>
    `;
    document.body.appendChild(banner);
  } else {
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

/* 6. Interactive Checklist (Page 97) State Storage */
function initChecklistState() {
  const checklistItems = document.querySelectorAll('.checklist-item input[type="checkbox"]');
  if (!checklistItems.length) return;

  checklistItems.forEach((box, idx) => {
    const storageKey = `gh_check_${idx}`;
    if (localStorage.getItem(storageKey) === 'true') {
      box.checked = true;
      box.closest('.checklist-item').classList.add('checked');
    }

    box.addEventListener('change', () => {
      const parent = box.closest('.checklist-item');
      if (box.checked) {
        parent.classList.add('checked');
        localStorage.setItem(storageKey, 'true');
      } else {
        parent.classList.remove('checked');
        localStorage.removeItem(storageKey);
      }
    });
  });
}

/* 7. Activities Timeline Category Filters & Quick Jump */
function initTimelineControls() {
  const filterBtns = document.querySelectorAll('.timeline-filter-btn');
  const milestones = document.querySelectorAll('.timeline-milestone');
  if (!filterBtns.length || !milestones.length) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');

      const filter = btn.getAttribute('data-filter');

      milestones.forEach(m => {
        const cat = m.getAttribute('data-category') || '';
        if (filter === 'all' || cat.includes(filter)) {
          m.classList.remove('hidden-by-filter');
        } else {
          m.classList.add('hidden-by-filter');
        }
      });
    });
  });

  // Smooth scroll for quick jump pills
  document.querySelectorAll('.quick-jump-pill').forEach(pill => {
    pill.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = pill.getAttribute('href');
      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        // If hidden by current filter, reset filter to 'all'
        if (targetEl.classList.contains('hidden-by-filter')) {
          const allBtn = document.querySelector('.timeline-filter-btn[data-filter="all"]');
          if (allBtn) allBtn.click();
        }
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  });
}

/* 8. Multi-Country Tabs inside Milestones */
function initCountryTabs() {
  const switchers = document.querySelectorAll('.country-switcher-container');
  if (!switchers.length) return;

  switchers.forEach(switcher => {
    const tabBtns = switcher.querySelectorAll('.country-nav-btn');
    const panes = switcher.querySelectorAll('.country-tab-pane');

    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-country-target');
        if (!targetId) return;

        tabBtns.forEach(b => {
          b.classList.remove('active');
          b.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');

        panes.forEach(pane => {
          if (pane.id === targetId) {
            pane.classList.add('active');
          } else {
            pane.classList.remove('active');
          }
        });
      });
    });
  });
}
