/**
 * GREEN HORIZON — News & Updates Archive Script
 * Light Booklet Style
 */

let newsArticles = [];

function initNewsPage() {
  const container = document.getElementById('news-articles-container');
  if (!container) return;

  fetch(`assets/data/news.json?t=${Date.now()}`)
    .then(res => res.json())
    .then(data => {
      newsArticles = data;
      renderNewsArticles(data);
      setupNewsFilters();
      setupNewsSearch();
    })
    .catch(err => {
      console.warn('Loading news fallback', err);
    });
}

function renderNewsArticles(articles) {
  const container = document.getElementById('news-articles-container');
  if (!container) return;

  if (articles.length === 0) {
    container.innerHTML = `
      <div style="grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
        <p style="font-size: 1.1rem;">No articles found matching your criteria.</p>
      </div>
    `;
    return;
  }

  container.innerHTML = articles.map(art => {
    let pdfAction = art.pdf_download ? `
      <a href="${art.pdf_download}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; width: 100%; margin-top: 0.5rem; text-decoration: none;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Download PDF Issue
      </a>
    ` : '';

    return `
      <article class="card card-accent-green" id="${art.id}" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div style="margin-bottom: 1rem; overflow: hidden; border-radius: var(--radius-md); position: relative;">
            <img src="${art.image || 'assets/images/booklet-cover.jpg'}" alt="${art.title}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block;" loading="lazy">
            ${art.badge ? `<span style="position: absolute; top: 10px; right: 10px; background: rgba(18, 53, 36, 0.88); backdrop-filter: blur(4px); color: #FFFFFF; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-full);">${art.badge}</span>` : ''}
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem; flex-wrap: wrap; gap: 0.5rem;">
            <span class="badge badge-completed">${art.category || 'Update'}</span>
            <span style="font-size: 0.82rem; color: var(--text-light); font-weight: 600;">🗓 ${art.date}</span>
          </div>
          <h3 style="font-size: 1.22rem; margin-bottom: 0.75rem; line-height: 1.35; color: var(--primary);">${art.title}</h3>
          <p style="color: var(--text-muted); font-size: 0.94rem; margin-bottom: 1.25rem; line-height: 1.55;">${art.summary}</p>
        </div>
        <div>
          <button class="btn btn-secondary btn-sm" style="width: 100%;" onclick="openArticleModal('${art.id}')">
            Read Full Article &rarr;
          </button>
          ${pdfAction}
        </div>
      </article>
    `;
  }).join('');
}

function setupNewsFilters() {
  const filterBtns = document.querySelectorAll('.news-filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyNewsFilters();
    });
  });
}

function setupNewsSearch() {
  const searchInput = document.getElementById('news-search-input');
  if (!searchInput) return;

  searchInput.addEventListener('input', () => {
    applyNewsFilters();
  });
}

function applyNewsFilters() {
  const activeBtn = document.querySelector('.news-filter-btn.active');
  const activeFilter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
  const query = (document.getElementById('news-search-input')?.value || '').toLowerCase().trim();

  let filtered = newsArticles;

  if (activeFilter !== 'all') {
    filtered = filtered.filter(item => (item.category || '').toLowerCase().includes(activeFilter.toLowerCase()));
  }

  if (query) {
    filtered = filtered.filter(item => 
      (item.title || '').toLowerCase().includes(query) ||
      (item.summary || '').toLowerCase().includes(query) ||
      (item.full_text || item.content || '').toLowerCase().includes(query)
    );
  }

  renderNewsArticles(filtered);
}

window.openArticleModal = function(id) {
  const art = newsArticles.find(a => a.id === id);
  if (!art) return;

  const modal = document.getElementById('article-modal');
  const textContent = art.full_text || art.content || art.summary;
  
  if (!modal) {
    alert(`${art.title}\n\n${art.date} • ${art.author || 'Consortium'}\n\n${textContent}`);
    return;
  }

  const titleEl = document.getElementById('article-modal-title');
  const metaEl = document.getElementById('article-modal-meta');
  const bodyEl = document.getElementById('article-modal-content');

  if (titleEl) titleEl.textContent = art.title;
  if (metaEl) metaEl.textContent = `${art.date} | ${art.category || 'News'} | ${art.author || 'Consortium'}`;
  
  if (bodyEl) {
    let html = '';
    
    // Header image inside modal
    if (art.image) {
      html += `
        <div style="margin-bottom: 1.5rem; overflow: hidden; border-radius: var(--radius-md); max-height: 320px;">
          <img src="${art.image}" alt="${art.title}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
      `;
    }

    // Paragraphs and lists
    html += textContent.split('\n\n').map(p => {
      if (p.includes('\n•') || p.startsWith('•')) {
        const lines = p.split('\n');
        const listItems = lines.map(l => {
          if (l.trim().startsWith('•')) {
            return `<li style="margin-bottom: 0.4rem;">${l.trim().substring(1).trim()}</li>`;
          }
          return `<p style="margin-bottom: 0.5rem; font-weight: 600;">${l}</p>`;
        }).join('');
        return `<ul style="margin: 0.8rem 0 1.2rem 1.4rem; line-height: 1.6; color: var(--text-main);">${listItems}</ul>`;
      }
      return `<p style="margin-bottom: 1rem; line-height: 1.65; color: var(--text-main);">${p}</p>`;
    }).join('');

    // PDF Download Banner if newsletter
    if (art.pdf_download) {
      html += `
        <div style="margin-top: 1.75rem; padding: 1.25rem; background: var(--leaf-green-light); border-radius: var(--radius-md); border: 1px solid rgba(46, 125, 50, 0.25); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
          <div>
            <strong style="color: var(--primary-dark); font-size: 1.05rem; display: block;">Official Newsletter Issue (PDF)</strong>
            <span style="font-size: 0.88rem; color: var(--text-muted);">Read the complete 2-page illustrated European progress report.</span>
          </div>
          <a href="${art.pdf_download}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Download PDF
          </a>
        </div>
      `;
    }

    // External Links & Media Coverage
    if (art.links && art.links.length > 0) {
      html += `
        <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
          <h4 style="font-size: 1.05rem; color: var(--primary); margin-bottom: 0.85rem; font-family: var(--font-heading);">Related Media Coverage &amp; Channels:</h4>
          <div style="display: flex; flex-direction: column; gap: 0.6rem;">
            ${art.links.map(l => `
              <a href="${l.url}" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: space-between; color: var(--primary-dark); font-weight: 600; font-size: 0.92rem; text-decoration: none; padding: 0.6rem 1rem; background: #FFFFFF; border-radius: var(--radius-sm); border: 1px solid var(--border-color); box-shadow: 0 1px 4px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                  <span style="font-size: 0.8rem; background: var(--leaf-green-light); color: var(--primary); padding: 0.2rem 0.5rem; border-radius: var(--radius-full); font-weight: 700;">${l.platform || 'Link'}</span>
                  <span>${l.label}</span>
                </span>
                <span style="color: var(--primary);">&rarr;</span>
              </a>
            `).join('')}
          </div>
        </div>
      `;
    }

    bodyEl.innerHTML = html;
  }

  modal.classList.add('open');
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
};

window.closeArticleModal = function() {
  const modal = document.getElementById('article-modal');
  if (modal) {
    modal.classList.remove('open');
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }
};

document.addEventListener('DOMContentLoaded', initNewsPage);
