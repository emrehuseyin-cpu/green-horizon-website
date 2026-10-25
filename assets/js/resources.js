/**
 * GREEN HORIZON — Educational Resources Script
 * Searchable, Filterable Repository & Download Tracker
 */

let resourcesData = [];

function initResourcesPage() {
  const container = document.getElementById('resources-list-container');
  if (!container) return;

  fetch('assets/data/resources.json')
    .then(res => res.json())
    .then(data => {
      resourcesData = data;
      renderResources(data);
      setupResourceFilters();
      setupResourceSearch();
    })
    .catch(err => {
      console.warn('Loading resources fallback', err);
    });
}

function renderResources(items) {
  const container = document.getElementById('resources-list-container');
  if (!container) return;

  if (items.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
        <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">No educational resources found matching your query.</p>
        <button class="btn btn-secondary btn-sm" onclick="resetResourceFilters()">Reset Filters</button>
      </div>
    `;
    return;
  }

  container.innerHTML = items.map(res => `
    <article class="card-glass" style="margin-bottom: 2rem;">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
          <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; flex-wrap: wrap;">
            <span class="badge badge-electric">${res.category}</span>
            <span class="badge badge-teal">${res.format}</span>
            <span class="badge badge-planned">${res.fileSize}</span>
            <span class="badge ${res.status.includes('Ready') ? 'badge-electric' : 'badge-pending'}">${res.status}</span>
          </div>
          <h3 style="margin-bottom: 0.8rem; font-size: 1.35rem;">${res.title}</h3>
          <p style="color: var(--text-secondary); margin-bottom: 1.2rem;">${res.description}</p>
          
          <div style="background: rgba(7, 20, 17, 0.6); border: 1px solid var(--glass-border); border-radius: var(--radius-sm); padding: 1rem; margin-bottom: 1.2rem;">
            <h5 style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--teal); margin-bottom: 0.5rem; text-transform: uppercase;">Included Curricular Modules:</h5>
            <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.86rem; color: var(--text-muted);">
              ${res.modules.map(mod => `<li>${mod}</li>`).join('')}
            </ul>
          </div>

          <div style="font-size: 0.82rem; font-family: var(--font-mono); color: var(--text-muted);">
            Available Languages: <span style="color: var(--text-primary);">${res.languages.join(', ')}</span>
          </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.8rem; min-width: 180px;">
          <a href="${res.downloadUrl}" class="btn btn-primary" data-download="${res.id}" ${res.downloadUrl.endsWith('.pdf') ? 'download' : ''} onclick="return handleDownloadPlaceholder(event, '${res.title.replace(/'/g, "\\'")}', '${res.downloadUrl}')">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="7 10 12 15 17 10"></polyline>
              <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            ${res.downloadUrl !== '#' ? 'Download PDF' : 'Download Guide'}
          </a>
          <button class="btn btn-ghost btn-sm" onclick="showResourceDetails('${res.id}')">
            View Syllabus Details
          </button>
        </div>
      </div>
    </article>
  `).join('');
}

function setupResourceFilters() {
  const filterBtns = document.querySelectorAll('.resource-filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyResourceFilters();
    });
  });
}

function setupResourceSearch() {
  const searchInput = document.getElementById('resource-search-input');
  if (!searchInput) return;

  searchInput.addEventListener('input', () => {
    applyResourceFilters();
  });
}

function applyResourceFilters() {
  const activeBtn = document.querySelector('.resource-filter-btn.active');
  const activeFilter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
  const query = (document.getElementById('resource-search-input')?.value || '').toLowerCase().trim();

  let filtered = resourcesData;

  if (activeFilter !== 'all') {
    filtered = filtered.filter(item => item.category.toLowerCase().includes(activeFilter.toLowerCase()));
  }

  if (query) {
    filtered = filtered.filter(item => 
      item.title.toLowerCase().includes(query) ||
      item.description.toLowerCase().includes(query) ||
      item.modules.some(m => m.toLowerCase().includes(query))
    );
  }

  renderResources(filtered);
}

window.resetResourceFilters = function() {
  const searchInput = document.getElementById('resource-search-input');
  if (searchInput) searchInput.value = '';
  const allBtn = document.querySelector('.resource-filter-btn[data-filter="all"]');
  if (allBtn) {
    document.querySelectorAll('.resource-filter-btn').forEach(b => b.classList.remove('active'));
    allBtn.classList.add('active');
  }
  renderResources(resourcesData);
};

window.handleDownloadPlaceholder = function(e, title, url) {
  if (url && url !== '#') {
    // Allow direct download of available file
    return true;
  }
  e.preventDefault();
  alert(`"${title}" is currently in development under the Erasmus+ work plan. The open-access publication will be available for download here upon validation by the consortium.`);
};

window.showResourceDetails = function(id) {
  const item = resourcesData.find(r => r.id === id);
  if (!item) return;
  alert(`RESOURCE SYLLABUS: ${item.title}\nFormat: ${item.format} (${item.pages})\nLanguages: ${item.languages.join(', ')}\nStatus: ${item.status}\n\nModules:\n${item.modules.join('\n')}`);
};

document.addEventListener('DOMContentLoaded', initResourcesPage);
