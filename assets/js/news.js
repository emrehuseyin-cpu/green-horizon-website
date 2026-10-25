/**
 * GREEN HORIZON — News & Updates Archive Script
 */

let newsArticles = [];

function initNewsPage() {
  const container = document.getElementById('news-articles-container');
  if (!container) return;

  fetch('assets/data/news.json')
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
    <article class="card-glass" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
          <span class="badge badge-electric">${art.category}</span>
          <span style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--teal);">${art.date}</span>
        </div>
        <h3 style="font-size: 1.25rem; margin-bottom: 0.8rem; line-height: 1.35;">${art.title}</h3>
        <p style="color: var(--text-secondary); font-size: 0.92rem; margin-bottom: 1.2rem;">${art.summary}</p>
      </div>
      <div>
        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; margin-bottom: 1.2rem;">
          ${art.tags.map(tag => `<span style="font-size: 0.72rem; color: var(--text-muted); background: rgba(7,20,17,0.7); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid var(--glass-border);">#${tag}</span>`).join('')}
        </div>
        <button class="btn btn-secondary btn-sm" style="width: 100%;" onclick="openArticleModal('${art.id}')">
          Read Full Announcement &rarr;
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
    filtered = filtered.filter(item => item.category.toLowerCase().includes(activeFilter.toLowerCase()));
  }

  if (query) {
    filtered = filtered.filter(item => 
      item.title.toLowerCase().includes(query) ||
      item.summary.toLowerCase().includes(query) ||
      item.content.toLowerCase().includes(query)
    );
  }

  renderNewsArticles(filtered);
}

window.openArticleModal = function(id) {
  const art = newsArticles.find(a => a.id === id);
  if (!art) return;

  const modal = document.getElementById('article-modal');
  if (!modal) {
    alert(`${art.title}\n\n${art.date} // ${art.author}\n\n${art.content}`);
    return;
  }

  document.getElementById('article-modal-title').textContent = art.title;
  document.getElementById('article-modal-meta').textContent = `${art.date} | Category: ${art.category} | Author: ${art.author}`;
  document.getElementById('article-modal-content').innerHTML = art.content.split('\n\n').map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('');
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
};

window.closeArticleModal = function() {
  const modal = document.getElementById('article-modal');
  if (modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }
};

document.addEventListener('DOMContentLoaded', initNewsPage);
