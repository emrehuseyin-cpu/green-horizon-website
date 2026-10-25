/**
 * GREEN HORIZON — Photo Exhibition & Lightbox Script
 * Drone EXIF Telemetry Inspector & Category Filter
 */

let exhibitionData = [];
let currentItemIndex = 0;

function initPhotoExhibition() {
  const grid = document.getElementById('exhibition-gallery-grid');
  if (!grid) return;

  fetch('assets/data/gallery.json')
    .then(res => res.json())
    .then(data => {
      exhibitionData = data;
      renderGalleryCards(data);
      setupGalleryFilters();
      setupLightbox();
    })
    .catch(err => {
      console.warn('Loading gallery data fallback', err);
    });
}

function renderGalleryCards(items) {
  const grid = document.getElementById('exhibition-gallery-grid');
  if (!grid) return;

  if (items.length === 0) {
    grid.innerHTML = `
      <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-muted);">
        <p>No exhibition items found for this category.</p>
      </div>
    `;
    return;
  }

  grid.innerHTML = items.map((item, idx) => `
    <article class="gallery-card" data-index="${idx}" tabindex="0" role="button" aria-label="View ${item.title}">
      <div class="gallery-thumb-wrapper">
        <img src="${item.image || 'assets/images/exhibition/' + item.id + '.svg'}" alt="${item.title}" loading="lazy">
        <div class="gallery-telemetry-badge">
          ALT: ${item.altitude}
        </div>
      </div>
      <div class="gallery-card-body">
        <div class="gallery-card-meta">
          📍 ${item.location}
        </div>
        <h3 class="gallery-card-title">${item.title}</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 0.8rem;">${item.caption}</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-family: var(--font-mono); font-size: 0.75rem; color: var(--electric-green);">
          <span>${item.category}</span>
          <span>${item.shutter} | ${item.aperture} | ISO ${item.iso}</span>
        </div>
      </div>
    </article>
  `).join('');

  // Attach card click handlers for lightbox
  grid.querySelectorAll('.gallery-card').forEach(card => {
    card.addEventListener('click', () => {
      const idx = parseInt(card.getAttribute('data-index'), 10);
      openLightbox(idx);
    });

    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const idx = parseInt(card.getAttribute('data-index'), 10);
        openLightbox(idx);
      }
    });
  });
}

function setupGalleryFilters() {
  const filterBtns = document.querySelectorAll('.gallery-filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');
      if (filter === 'all') {
        renderGalleryCards(exhibitionData);
      } else {
        const filtered = exhibitionData.filter(item => item.category.toLowerCase().includes(filter.toLowerCase()));
        renderGalleryCards(filtered);
      }
    });
  });
}

function setupLightbox() {
  const modal = document.getElementById('lightbox-modal');
  if (!modal) return;

  const closeBtn = document.getElementById('lightbox-close-btn');
  const prevBtn = document.getElementById('lightbox-prev-btn');
  const nextBtn = document.getElementById('lightbox-next-btn');

  if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
  if (prevBtn) prevBtn.addEventListener('click', () => navigateLightbox(-1));
  if (nextBtn) nextBtn.addEventListener('click', () => navigateLightbox(1));

  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeLightbox();
  });

  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') navigateLightbox(-1);
    if (e.key === 'ArrowRight') navigateLightbox(1);
  });
}

function openLightbox(index) {
  const modal = document.getElementById('lightbox-modal');
  if (!modal || !exhibitionData[index]) return;

  currentItemIndex = index;
  updateLightboxContent();
  modal.classList.add('open');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  const modal = document.getElementById('lightbox-modal');
  if (!modal) return;

  modal.classList.remove('open');
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}

function navigateLightbox(direction) {
  currentItemIndex = (currentItemIndex + direction + exhibitionData.length) % exhibitionData.length;
  updateLightboxContent();
}

function updateLightboxContent() {
  const item = exhibitionData[currentItemIndex];
  if (!item) return;

  const imgEl = document.getElementById('lightbox-img');
  const titleEl = document.getElementById('lightbox-title');
  const metaEl = document.getElementById('lightbox-meta');
  const coordsEl = document.getElementById('lightbox-coords');
  const telemetryEl = document.getElementById('lightbox-telemetry');

  if (imgEl) {
    imgEl.src = item.image || `assets/images/exhibition/${item.id}.svg`;
    imgEl.alt = item.title;
  }
  if (titleEl) titleEl.textContent = item.title;
  if (metaEl) metaEl.textContent = `${item.location} // ${item.theme}`;
  if (coordsEl) coordsEl.textContent = `GPS: ${item.coordinates} | ALT: ${item.altitude}`;
  if (telemetryEl) {
    telemetryEl.textContent = `EXIF: ${item.sensor} | ${item.shutter} | ${item.aperture} | ISO ${item.iso} | FOV ${item.fov}`;
  }
}

document.addEventListener('DOMContentLoaded', initPhotoExhibition);
