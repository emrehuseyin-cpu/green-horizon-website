/**
 * GREEN HORIZON — News & Updates Archive Script
 * Light Booklet Style
 */

window.ghAsset = window.ghAsset || function(path) {
  if (!path) return '';
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('//') || path.startsWith('data:')) return path;
  const base = (window.GreenHorizon && window.GreenHorizon.assetsUri) ? window.GreenHorizon.assetsUri : 'assets';
  if (path.startsWith('assets/')) {
    return base + path.substring(6);
  }
  return base.replace(/\/$/, '') + '/' + path.replace(/^\//, '');
};

let newsArticles = [];

function initNewsPage() {
  const container = document.getElementById('news-articles-container');
  if (!container) return;

  fetch(window.ghAsset('data/news.json') + `?t=${Date.now()}`)
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

  container.innerHTML = articles.map(art => `
    <article class="card card-accent-green" id="${art.id}" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="margin-bottom: 1rem; overflow: hidden; border-radius: var(--radius-md);">
          <img src="${window.ghAsset(art.image || 'images/booklet-cover.jpg')}" alt="${art.title}" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem; flex-wrap: wrap; gap: 0.5rem;">
          <span class="badge badge-completed">${art.category || 'Update'}</span>
          <span style="font-size: 0.82rem; color: var(--text-light); font-weight: 600;">🗓 ${art.date}</span>
        </div>
        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; line-height: 1.35; color: var(--primary);">${art.title}</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.25rem; line-height: 1.55;">${art.summary}</p>
      </div>
      <div>
        <button class="btn btn-secondary btn-sm" style="width: 100%;" onclick="openArticleModal('${art.id}')">
          Read Full Post &rarr;
        </button>
      </div>
    </article>
  `).join('');
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
    bodyEl.innerHTML = textContent.split('\n\n').map(p => `<p style="margin-bottom: 1rem; line-height: 1.6;">${p}</p>`).join('');
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
