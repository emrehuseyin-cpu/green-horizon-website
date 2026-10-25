/**
 * GREEN HORIZON — Gallery, Activity Photo Spaces & Lightbox
 * Light Booklet Style (CC BY-SA 4.0)
 */

let activeLightboxItems = [];
let currentLightboxIndex = 0;

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  initMainGalleryPage();
  initHomepageGalleryStrip();
  initActivityPhotoSpaces();
  setupGlobalLightbox();
});

/**
 * 1. Main Gallery Page (/gallery)
 */
function initMainGalleryPage() {
  const grid = document.getElementById('gallery-grid-container');
  if (!grid) return;

  fetch('assets/data/gallery.json')
    .then(res => res.json())
    .then(items => {
      renderGalleryItems(grid, items);
      setupCategoryFilters(grid, items);
    })
    .catch(err => {
      console.warn('Error loading gallery data:', err);
    });
}

function renderGalleryItems(grid, items) {
  if (!grid) return;

  if (items.length === 0) {
    grid.innerHTML = `
      <div style="grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
        <p style="font-size: 1.1rem;">No photos currently found in this category.</p>
      </div>
    `;
    return;
  }

  grid.innerHTML = items.map((item, idx) => `
    <article class="gallery-item-card" data-idx="${idx}" tabindex="0" role="button" aria-label="View photo: ${item.title || item.caption}">
      <div class="gallery-item-thumb-wrapper">
        <img class="gallery-item-thumb" src="${item.file}" alt="${item.alt || item.title || 'Green Horizon photo'}" loading="lazy">
        <span class="gallery-item-badge">${item.category}</span>
      </div>
      <div class="gallery-item-body">
        <h3 class="gallery-item-title">${item.title || item.category}</h3>
        <p class="gallery-item-caption">${item.caption}</p>
        <div class="gallery-item-meta">
          <span>📍 ${item.place}</span>
          <span>🗓 ${item.date}</span>
        </div>
      </div>
    </article>
  `).join('');

  // Attach click handlers
  grid.querySelectorAll('.gallery-item-card').forEach(card => {
    card.addEventListener('click', () => {
      const idx = parseInt(card.getAttribute('data-idx'), 10);
      openLightbox(items, idx);
    });
    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const idx = parseInt(card.getAttribute('data-idx'), 10);
        openLightbox(items, idx);
      }
    });
  });
}

function setupCategoryFilters(grid, allItems) {
  const filterBtns = document.querySelectorAll('.gallery-filter-btn');
  if (!filterBtns.length) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-category');
      if (!filter || filter === 'all') {
        renderGalleryItems(grid, allItems);
      } else {
        const filtered = allItems.filter(item => {
          return item.category.toLowerCase().trim() === filter.toLowerCase().trim();
        });
        renderGalleryItems(grid, filtered);
      }
    });
  });
}

/**
 * 2. Homepage Gallery Preview Strip
 */
function initHomepageGalleryStrip() {
  const strip = document.getElementById('homepage-gallery-strip');
  if (!strip) return;

  fetch('assets/data/gallery.json')
    .then(res => res.json())
    .then(items => {
      // Pick latest 6-8 photos
      const previewItems = items.slice(0, 8);
      strip.innerHTML = previewItems.map((item, idx) => `
        <article class="gallery-item-card" data-idx="${idx}" tabindex="0" role="button" aria-label="View photo: ${item.title || item.caption}">
          <div class="gallery-item-thumb-wrapper">
            <img class="gallery-item-thumb" src="${item.file}" alt="${item.alt || item.title || 'Green Horizon photo'}" loading="lazy">
            <span class="gallery-item-badge">${item.category}</span>
          </div>
          <div class="gallery-item-body">
            <h3 class="gallery-item-title">${item.title || item.category}</h3>
            <p class="gallery-item-caption" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${item.caption}</p>
            <div class="gallery-item-meta">
              <span>📍 ${item.place}</span>
              <span>🗓 ${item.date}</span>
            </div>
          </div>
        </article>
      `).join('');

      strip.querySelectorAll('.gallery-item-card').forEach(card => {
        card.addEventListener('click', () => {
          const idx = parseInt(card.getAttribute('data-idx'), 10);
          openLightbox(previewItems, idx);
        });
        card.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const idx = parseInt(card.getAttribute('data-idx'), 10);
            openLightbox(previewItems, idx);
          }
        });
      });
    })
    .catch(err => {
      console.warn('Error loading homepage gallery preview:', err);
    });
}

/**
 * 3. Activity Photo Spaces
 * Renders defined slots per activity:
 * A1 (6 slots), A2 (9 slots), A4 (DE 6, RO 6, TR 6), A7 (DE 6, RO 6, TR 6, TR Final Meeting 6)
 */
function initActivityPhotoSpaces() {
  const activityGrids = document.querySelectorAll('[data-activity-slots]');
  if (!activityGrids.length) return;

  fetch('assets/data/activities.json')
    .then(res => res.json())
    .then(activities => {
      activityGrids.forEach(container => {
        const actId = container.getAttribute('data-activity-id');
        const galleryKey = container.getAttribute('data-gallery-key') || 'photoGallery';
        const slotsCount = parseInt(container.getAttribute('data-slots-count'), 10) || 6;

        const act = activities.find(a => a.id === actId);
        let photos = [];
        let activityTitle = act ? act.title : 'Activity';

        if (act && act[galleryKey] && act[galleryKey].photos) {
          photos = act[galleryKey].photos;
        }

        renderPhotoSlots(container, photos, slotsCount, activityTitle);
      });
    })
    .catch(err => {
      console.warn('Error loading activity photos:', err);
    });
}

function renderPhotoSlots(container, photos, totalSlots, activityTitle) {
  let html = '';
  const filledPhotos = photos || [];

  for (let i = 0; i < totalSlots; i++) {
    if (i < filledPhotos.length) {
      const p = filledPhotos[i];
      html += `
        <div class="photo-slot-card has-photo" data-photo-idx="${i}" tabindex="0" role="button" aria-label="View photo: ${p.caption}">
          <img class="photo-slot-thumb" src="${p.file}" alt="${p.alt || p.caption}" loading="lazy">
          <div class="photo-slot-caption">
            <div>${p.caption}</div>
            <div class="photo-slot-meta">📍 ${p.place || ''} • 🗓 ${p.date || ''}</div>
          </div>
        </div>
      `;
    } else {
      html += `
        <div class="photo-slot-empty" role="img" aria-label="Photo coming soon placeholder">
          <svg class="photo-slot-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
            <circle cx="12" cy="13" r="4"></circle>
          </svg>
          <span class="photo-slot-empty-text">Photo coming soon</span>
          <span style="font-size: 0.75rem; color: #9CA3AF; margin-top: 0.25rem;">Slot #${i + 1}</span>
        </div>
      `;
    }
  }

  container.innerHTML = html;

  // Attach lightbox click to filled photo slots
  container.querySelectorAll('.photo-slot-card.has-photo').forEach(slot => {
    slot.addEventListener('click', () => {
      const idx = parseInt(slot.getAttribute('data-photo-idx'), 10);
      openLightbox(filledPhotos, idx);
    });
    slot.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const idx = parseInt(slot.getAttribute('data-photo-idx'), 10);
        openLightbox(filledPhotos, idx);
      }
    });
  });
}

/**
 * 4. Lightbox Core
 */
function setupGlobalLightbox() {
  let modal = document.getElementById('global-lightbox-modal');
  if (!modal) {
    modal = document.createElement('div');
    modal.id = 'global-lightbox-modal';
    modal.className = 'lightbox-modal';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-label', 'Image preview');
    modal.innerHTML = `
      <div class="lightbox-content-box">
        <button class="lightbox-close-btn" id="lightbox-close-button" aria-label="Close image preview">&times;</button>
        <button class="lightbox-nav-btn lightbox-prev-btn" id="lightbox-prev-button" aria-label="Previous image">&#10094;</button>
        <img class="lightbox-image" id="lightbox-modal-img" src="" alt="">
        <div class="lightbox-caption-box">
          <p id="lightbox-modal-caption" style="margin: 0; font-weight: 600;"></p>
          <p id="lightbox-modal-meta" style="margin: 0.3rem 0 0 0; font-size: 0.85rem; color: #D1D5DB;"></p>
        </div>
        <button class="lightbox-nav-btn lightbox-next-btn" id="lightbox-next-button" aria-label="Next image">&#10095;</button>
      </div>
    `;
    document.body.appendChild(modal);
  }

  const closeBtn = document.getElementById('lightbox-close-button');
  const prevBtn = document.getElementById('lightbox-prev-button');
  const nextBtn = document.getElementById('lightbox-next-button');

  if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
  if (prevBtn) prevBtn.addEventListener('click', () => stepLightbox(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => stepLightbox(1));

  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeLightbox();
  });

  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') stepLightbox(-1);
    if (e.key === 'ArrowRight') stepLightbox(1);
  });
}

function openLightbox(itemsList, startIndex) {
  if (!itemsList || itemsList.length === 0) return;
  activeLightboxItems = itemsList;
  currentLightboxIndex = startIndex;

  const modal = document.getElementById('global-lightbox-modal');
  if (!modal) return;

  renderActiveLightboxItem();
  modal.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  const modal = document.getElementById('global-lightbox-modal');
  if (!modal) return;
  modal.classList.remove('active');
  document.body.style.overflow = '';
}

function stepLightbox(direction) {
  if (!activeLightboxItems.length) return;
  currentLightboxIndex = (currentLightboxIndex + direction + activeLightboxItems.length) % activeLightboxItems.length;
  renderActiveLightboxItem();
}

function renderActiveLightboxItem() {
  const item = activeLightboxItems[currentLightboxIndex];
  if (!item) return;

  const imgEl = document.getElementById('lightbox-modal-img');
  const capEl = document.getElementById('lightbox-modal-caption');
  const metaEl = document.getElementById('lightbox-modal-meta');

  if (imgEl) {
    imgEl.src = item.file || item.image;
    imgEl.alt = item.alt || item.title || item.caption || 'Enlarged photo';
  }
  if (capEl) {
    capEl.textContent = item.caption || item.title || '';
  }
  if (metaEl) {
    let metaText = '';
    if (item.place) metaText += `📍 ${item.place} `;
    if (item.date) metaText += `• 🗓 ${item.date} `;
    if (item.category) metaText += `• [${item.category}]`;
    metaEl.textContent = metaText;
  }
}
