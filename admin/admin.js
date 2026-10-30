/**
 * GREEN HORIZON — Admin Control Panel JavaScript
 * Client-Side Controller for Visual Video, Photo, and Content Management
 */

let currentCsrf = document.getElementById('global-csrf')?.value || '';
let currentAlbum = 'a1-kickoff';
let currentContentFile = 'home';
let currentContentData = {};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  initAuth();
  initTabs();
  initVideos();
  initAlbums();
  initContentEditor();
  initSettings();

  // If already logged in, load initial data
  if (document.body.classList.contains('dashboard-view')) {
    loadVideos();
    loadAlbumPhotos(currentAlbum);
    loadContentFile(currentContentFile);
    loadSystemStatus();
  }
});

// Toast / Alert Helper
function showAlert(message, type = 'success') {
  const alertEl = document.getElementById('global-alert');
  if (!alertEl) return;
  alertEl.className = `alert alert-${type}`;
  alertEl.textContent = message;
  alertEl.style.display = 'block';
  setTimeout(() => {
    alertEl.style.display = 'none';
  }, 4000);
}

// =============================================================================
// 1. AUTHENTICATION (Login / Logout)
// =============================================================================
function initAuth() {
  const loginForm = document.getElementById('login-form');
  const loginError = document.getElementById('login-error');
  const logoutBtn = document.getElementById('logout-btn');

  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      loginError.style.display = 'none';
      const password = document.getElementById('admin-password').value;

      try {
        const res = await fetch('api.php?action=login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ password })
        });
        const data = await res.json();

        if (data.success) {
          currentCsrf = data.csrf_token;
          document.body.classList.remove('login-view');
          document.body.classList.add('dashboard-view');
          document.getElementById('login-modal').style.display = 'none';
          document.getElementById('dashboard-wrapper').style.display = 'flex';

          loadVideos();
          loadAlbumPhotos(currentAlbum);
          loadContentFile(currentContentFile);
          loadSystemStatus();
        } else {
          loginError.textContent = data.error || 'Authentication failed.';
          loginError.style.display = 'block';
        }
      } catch (err) {
        loginError.textContent = 'Server connection error. Please try again.';
        loginError.style.display = 'block';
      }
    });
  }

  if (logoutBtn) {
    logoutBtn.addEventListener('click', async () => {
      await fetch('api.php?action=logout', { method: 'POST' });
      document.body.classList.remove('dashboard-view');
      document.body.classList.add('login-view');
      document.getElementById('dashboard-wrapper').style.display = 'none';
      document.getElementById('login-modal').style.display = 'flex';
      document.getElementById('admin-password').value = '';
    });
  }
}

// =============================================================================
// 2. TAB NAVIGATION
// =============================================================================
function initTabs() {
  const navBtns = document.querySelectorAll('.sidebar-nav .nav-item');
  const panes = document.querySelectorAll('.admin-tab-pane');

  navBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      navBtns.forEach(b => b.classList.remove('active'));
      panes.forEach(p => p.classList.remove('active'));

      btn.classList.add('active');
      const tabId = btn.getAttribute('data-tab');
      const targetPane = document.getElementById(`tab-${tabId}`);
      if (targetPane) targetPane.classList.add('active');

      // Trigger data refresh on tab open
      if (tabId === 'videos') loadVideos();
      if (tabId === 'albums') loadAlbumPhotos(currentAlbum);
      if (tabId === 'content') loadContentFile(currentContentFile);
      if (tabId === 'news') loadNewsArticles();
      if (tabId === 'settings') loadSystemStatus();
    });
  });
}

// =============================================================================
// 3. VIDEOS & CAMPAIGN FILMS
// =============================================================================
function initVideos() {
  // video actions bound in loadVideos()
}

async function loadVideos() {
  const container = document.getElementById('videos-grid');
  if (!container) return;
  container.innerHTML = '<div class="loading-spinner">Loading campaign videos...</div>';

  try {
    const res = await fetch('api.php?action=get_videos');
    const data = await res.json();
    if (!data.success || !data.videos) {
      container.innerHTML = '<p class="text-danger">Failed to load video list.</p>';
      return;
    }

    container.innerHTML = data.videos.map(v => `
      <article class="video-card" id="card-${v.id}">
        <div class="video-player-container">
          <video controls preload="metadata" poster="../${v.poster}?t=${Date.now()}">
            <source src="../${v.video_src}?t=${Date.now()}" type="video/mp4">
            Your browser does not support HTML5 video.
          </video>
        </div>

        <div class="video-card-body">
          <div class="video-meta-badge">
            <span class="badge">${v.country || 'Transnational'}</span>
            <span style="font-size: 0.82rem; font-weight: 600; color: ${v.file_exists ? '#059669' : '#DC2626'};">
              ${v.file_exists ? '● Ready (' + v.file_size + ')' : '○ Missing file'}
            </span>
          </div>

          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control video-title-input" value="${escapeHtml(v.title)}">
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
            <div class="form-group">
              <label>Country</label>
              <input type="text" class="form-control video-country-input" value="${escapeHtml(v.country)}">
            </div>
            <div class="form-group">
              <label>Duration</label>
              <input type="text" class="form-control video-duration-input" value="${escapeHtml(v.duration)}">
            </div>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control video-desc-input">${escapeHtml(v.description)}</textarea>
          </div>

          <button class="btn btn-primary btn-sm save-video-btn" data-id="${v.id}" style="margin-bottom: 1rem;">
            💾 Save Video Details
          </button>

          <!-- File Upload Box -->
          <div class="video-upload-box">
            <strong style="font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Replace Media Files:</strong>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
              <label class="btn btn-outline btn-sm" style="color: var(--gh-primary); border-color: var(--gh-border); cursor: pointer;">
                📹 Upload New MP4 Video
                <input type="file" accept="video/mp4" style="display: none;" onchange="uploadVideoFile('${v.id}', 'video', this)">
              </label>

              <label class="btn btn-outline btn-sm" style="color: var(--gh-primary); border-color: var(--gh-border); cursor: pointer;">
                🖼️ Upload Poster Image
                <input type="file" accept="image/*" style="display: none;" onchange="uploadVideoFile('${v.id}', 'poster', this)">
              </label>
            </div>
          </div>
        </div>
      </article>
    `).join('');

    // Attach click events
    container.querySelectorAll('.save-video-btn').forEach(btn => {
      btn.addEventListener('click', async () => {
        const id = btn.getAttribute('data-id');
        const card = document.getElementById(`card-${id}`);
        const title = card.querySelector('.video-title-input').value;
        const country = card.querySelector('.video-country-input').value;
        const duration = card.querySelector('.video-duration-input').value;
        const description = card.querySelector('.video-desc-input').value;

        btn.disabled = true;
        btn.textContent = 'Saving...';

        const saveRes = await fetch('api.php?action=save_video_meta', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': currentCsrf
          },
          body: JSON.stringify({ id, title, country, duration, description })
        });
        const resData = await saveRes.json();
        btn.disabled = false;
        btn.textContent = '💾 Save Video Details';

        if (resData.success) {
          showAlert(`Video details updated! (${title})`);
        } else {
          showAlert(resData.error || 'Failed to save video details', 'danger');
        }
      });
    });

  } catch (err) {
    container.innerHTML = '<p class="text-danger">Error connecting to video API.</p>';
  }
}

async function uploadVideoFile(id, fileType, inputEl) {
  if (!inputEl.files || !inputEl.files[0]) return;
  const file = inputEl.files[0];

  const formData = new FormData();
  formData.append('id', id);
  formData.append('file_type', fileType);
  formData.append('file', file);
  formData.append('csrf_token', currentCsrf);

  showAlert(`Uploading ${fileType}... please wait.`);

  try {
    const res = await fetch('api.php?action=upload_video_file', {
      method: 'POST',
      headers: { 'X-CSRF-Token': currentCsrf },
      body: formData
    });
    const data = await res.json();
    if (data.success) {
      showAlert(`${fileType === 'video' ? 'Video' : 'Poster'} updated successfully! (${data.size || ''})`);
      loadVideos();
    } else {
      showAlert(data.error || 'Upload failed.', 'danger');
    }
  } catch (err) {
    showAlert('Server error during media upload.', 'danger');
  }
}

// =============================================================================
// 4. PHOTO ALBUMS (A1–A7 & Gallery)
// =============================================================================
function initAlbums() {
  const albumSelect = document.getElementById('album-select');
  const uploadForm = document.getElementById('upload-photo-form');
  const uploadAlbumInput = document.getElementById('upload-album-id');

  if (albumSelect) {
    albumSelect.addEventListener('change', () => {
      currentAlbum = albumSelect.value;
      if (uploadAlbumInput) uploadAlbumInput.value = currentAlbum;
      loadAlbumPhotos(currentAlbum);
    });
  }

  if (uploadForm) {
    uploadForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = document.getElementById('upload-photo-btn');
      btn.disabled = true;
      btn.textContent = 'Uploading...';

      const formData = new FormData(uploadForm);
      try {
        const res = await fetch('api.php?action=upload_photo', {
          method: 'POST',
          headers: { 'X-CSRF-Token': currentCsrf },
          body: formData
        });
        const data = await res.json();
        btn.disabled = false;
        btn.textContent = 'Upload Photo';

        if (data.success) {
          showAlert('Photo uploaded and added to album!');
          uploadForm.reset();
          if (uploadAlbumInput) uploadAlbumInput.value = currentAlbum;
          loadAlbumPhotos(currentAlbum);
        } else {
          showAlert(data.error || 'Upload failed.', 'danger');
        }
      } catch (err) {
        btn.disabled = false;
        btn.textContent = 'Upload Photo';
        showAlert('Server upload error.', 'danger');
      }
    });
  }
}

async function loadAlbumPhotos(albumId) {
  const grid = document.getElementById('album-photos-grid');
  const countEl = document.getElementById('album-photos-count');
  const titleEl = document.getElementById('album-photos-title');
  if (!grid) return;

  grid.innerHTML = '<div class="loading-spinner">Loading photos...</div>';

  try {
    const res = await fetch(`api.php?action=get_album_photos&album=${encodeURIComponent(albumId)}`);
    const data = await res.json();

    if (!data.success) {
      grid.innerHTML = `<p class="text-danger">${data.error || 'Failed to load album.'}</p>`;
      return;
    }

    const photos = data.photos || [];
    if (titleEl) titleEl.textContent = data.album.title || 'Album Photos';
    if (countEl) countEl.textContent = `${photos.length} photo${photos.length === 1 ? '' : 's'}`;

    if (photos.length === 0) {
      grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: #FFF; border-radius: 8px; border: 1px dashed #DDD;"><p>No photos in this album yet. Upload one using the box above!</p></div>';
      return;
    }

    grid.innerHTML = photos.map((p, idx) => `
      <article class="photo-card" id="photo-card-${idx}">
        <div class="photo-thumb-box">
          <img src="${p.file_url}?t=${Date.now()}" alt="${escapeHtml(p.caption_en || p.file)}" loading="lazy">
        </div>
        <div class="photo-card-body">
          <div class="photo-meta-info">
            <span style="font-weight: 600; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 130px;">
              ${escapeHtml(p.file)}
            </span>
            <span>${p.file_size}</span>
          </div>

          <div class="form-group" style="margin-bottom: 0.5rem;">
            <label style="font-size: 0.78rem;">Caption (English)</label>
            <input type="text" class="form-control caption-en-input" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;" value="${escapeHtml(p.caption_en || p.caption || '')}">
          </div>

          <div class="photo-card-actions">
            <button class="btn btn-outline btn-sm save-single-photo-btn" data-idx="${idx}" style="color: var(--gh-primary); border-color: var(--gh-border); padding: 0.25rem 0.5rem; font-size: 0.78rem;">
              Save
            </button>
            <button class="btn btn-danger btn-sm delete-photo-btn" data-file="${escapeHtml(p.file)}" style="padding: 0.25rem 0.5rem; font-size: 0.78rem;">
              Delete
            </button>
          </div>
        </div>
      </article>
    `).join('');

    // Attach actions
    grid.querySelectorAll('.save-single-photo-btn').forEach(btn => {
      btn.addEventListener('click', async () => {
        const idx = parseInt(btn.getAttribute('data-idx'), 10);
        const card = document.getElementById(`photo-card-${idx}`);
        const capEn = card.querySelector('.caption-en-input').value;
        photos[idx].caption_en = capEn;
        if (photos[idx].caption !== undefined) photos[idx].caption = capEn;

        btn.textContent = 'Saving...';
        const sRes = await fetch('api.php?action=save_album_photos', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': currentCsrf },
          body: JSON.stringify({ album: albumId, photos })
        });
        const sData = await sRes.json();
        btn.textContent = 'Saved!';
        setTimeout(() => { btn.textContent = 'Save'; }, 1500);
        if (sData.success) showAlert('Caption updated!');
      });
    });

    grid.querySelectorAll('.delete-photo-btn').forEach(btn => {
      btn.addEventListener('click', async () => {
        const file = btn.getAttribute('data-file');
        if (!confirm(`Are you sure you want to delete "${file}"? This action cannot be undone.`)) return;

        btn.disabled = true;
        btn.textContent = '...';

        const dRes = await fetch('api.php?action=delete_photo', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': currentCsrf },
          body: JSON.stringify({ album: albumId, filename: file })
        });
        const dData = await dRes.json();
        if (dData.success) {
          showAlert('Photo deleted.');
          loadAlbumPhotos(albumId);
        } else {
          showAlert(dData.error || 'Failed to delete photo', 'danger');
        }
      });
    });

  } catch (err) {
    grid.innerHTML = '<p class="text-danger">Error loading album photos.</p>';
  }
}

// =============================================================================
// 5. PAGES & TEXT CONTENT EDITOR
// =============================================================================
function initContentEditor() {
  const fileBtns = document.querySelectorAll('.content-file-btn');
  const saveBtn = document.getElementById('save-content-btn');

  fileBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      fileBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentContentFile = btn.getAttribute('data-file');
      loadContentFile(currentContentFile);
    });
  });

  if (saveBtn) {
    saveBtn.addEventListener('click', async () => {
      saveBtn.disabled = true;
      saveBtn.textContent = 'Saving...';

      // Read form values back into currentContentData
      const inputs = document.querySelectorAll('#content-fields-container [data-path]');
      inputs.forEach(input => {
        const path = input.getAttribute('data-path').split('.');
        let target = currentContentData;
        for (let i = 0; i < path.length - 1; i++) {
          if (!target[path[i]]) target[path[i]] = {};
          target = target[path[i]];
        }
        target[path[path.length - 1]] = input.value;
      });

      try {
        const res = await fetch('api.php?action=save_content', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': currentCsrf },
          body: JSON.stringify({ file: currentContentFile, data: currentContentData })
        });
        const data = await res.json();
        saveBtn.disabled = false;
        saveBtn.textContent = '💾 Save All Changes';

        if (data.success) {
          showAlert(`Saved successfully! All HTML files updated.`);
        } else {
          showAlert(data.error || 'Failed to save content', 'danger');
        }
      } catch (err) {
        saveBtn.disabled = false;
        saveBtn.textContent = '💾 Save All Changes';
        showAlert('Server error during content save.', 'danger');
      }
    });
  }
}

async function loadContentFile(file) {
  const container = document.getElementById('content-fields-container');
  const titleEl = document.getElementById('editing-file-title');
  if (!container) return;

  const labels = {
    'home': 'Homepage Hero, Videos & Results',
    'about': 'About the Project & Objectives',
    'results': 'Results, Deliverables & Booklets',
    'contact': 'Contact & Partner Information',
    'site-settings': 'Global EU Disclaimer & Project Settings'
  };

  if (titleEl) titleEl.textContent = `Editing: ${labels[file] || file}`;
  container.innerHTML = '<div class="loading-spinner">Loading form fields...</div>';

  try {
    const res = await fetch(`api.php?action=get_content&file=${encodeURIComponent(file)}`);
    const data = await res.json();
    if (!data.success || !data.data) {
      container.innerHTML = '<p class="text-danger">Failed to load content file.</p>';
      return;
    }

    currentContentData = data.data;
    container.innerHTML = renderObjectFields(currentContentData, '');
  } catch (err) {
    container.innerHTML = '<p class="text-danger">Error fetching content.</p>';
  }
}

function renderObjectFields(obj, prefix) {
  let html = '';
  for (const [key, val] of Object.entries(obj)) {
    const fieldPath = prefix ? `${prefix}.${key}` : key;
    const label = ucwords(key.replace(/_/g, ' '));

    if (val !== null && typeof val === 'object' && !Array.isArray(val)) {
      html += `
        <div style="background: #FAFAFA; border: 1px solid #E5E7EB; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
          <h4 style="color: var(--gh-primary); margin-bottom: 1rem; border-bottom: 1px solid #E5E7EB; padding-bottom: 0.5rem;">${label}</h4>
          ${renderObjectFields(val, fieldPath)}
        </div>
      `;
    } else if (Array.isArray(val)) {
      // Simple preview of lists
      html += `
        <div style="margin-bottom: 1.5rem;">
          <label style="font-weight: 700; display: block; margin-bottom: 0.25rem;">${label} (${val.length} items)</label>
          <small class="form-help">Items in this section can be edited directly or managed in dedicated tabs.</small>
        </div>
      `;
    } else {
      const isLongText = String(val).length > 60 || key.includes('description') || key.includes('subtitle') || key.includes('disclaimer');
      html += `
        <div class="form-group">
          <label>${label}</label>
          ${isLongText
            ? `<textarea class="form-control" data-path="${fieldPath}">${escapeHtml(val)}</textarea>`
            : `<input type="text" class="form-control" data-path="${fieldPath}" value="${escapeHtml(val)}">`
          }
        </div>
      `;
    }
  }
  return html;
}

// =============================================================================
// 6. NEWS & ARTICLES
// =============================================================================
async function loadNewsArticles() {
  const container = document.getElementById('news-articles-list');
  if (!container) return;
  container.innerHTML = '<div class="loading-spinner">Loading articles...</div>';

  try {
    const res = await fetch('api.php?action=get_content&file=news');
    const data = await res.json();
    const articles = (data.data && data.data.articles) ? data.data.articles : (Array.isArray(data.data) ? data.data : []);

    if (articles.length === 0) {
      container.innerHTML = '<p>No news articles found.</p>';
      return;
    }

    container.innerHTML = articles.map((a, idx) => `
      <article class="article-item-card">
        <img src="../${a.image || 'assets/images/logo-greenhorizon-emblem.png'}" class="article-item-thumb" alt="${escapeHtml(a.title)}">
        <div class="article-item-body">
          <h4>${escapeHtml(a.title)}</h4>
          <div class="article-item-meta">
            <span>🗓 ${escapeHtml(a.date || '')}</span> • <span>🏷 ${escapeHtml(a.category || '')}</span>
          </div>
          <p style="font-size: 0.88rem; color: #4B5563; margin-bottom: 0;">${escapeHtml(a.summary || '')}</p>
        </div>
      </article>
    `).join('');
  } catch (err) {
    container.innerHTML = '<p class="text-danger">Error loading news.</p>';
  }
}

function openNewArticleModal() {
  alert('To publish a new article, you can edit news.json in the Pages & Texts tab or use the add:news script.');
}

// =============================================================================
// 7. SETTINGS & SYSTEM STATUS
// =============================================================================
function initSettings() {
  const pwdForm = document.getElementById('change-password-form');
  if (pwdForm) {
    pwdForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const current = document.getElementById('current-password').value;
      const newPwd = document.getElementById('new-password').value;
      const btn = document.getElementById('change-pwd-btn');

      btn.disabled = true;
      btn.textContent = 'Updating...';

      try {
        const res = await fetch('api.php?action=change_password', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': currentCsrf },
          body: JSON.stringify({ current_password: current, new_password: newPwd })
        });
        const data = await res.json();
        btn.disabled = false;
        btn.textContent = 'Update Password';

        if (data.success) {
          showAlert('Password updated successfully! Please remember your new password.');
          pwdForm.reset();
        } else {
          showAlert(data.error || 'Failed to change password.', 'danger');
        }
      } catch (err) {
        btn.disabled = false;
        btn.textContent = 'Update Password';
        showAlert('Server connection error.', 'danger');
      }
    });
  }
}

async function loadSystemStatus() {
  const box = document.getElementById('system-status-info');
  const badge = document.getElementById('git-status-badge');
  if (!box) return;

  try {
    const res = await fetch('api.php?action=system_status');
    const data = await res.json();

    if (badge && data.git_branch) {
      badge.innerHTML = `Git: <code>${escapeHtml(data.git_branch)}</code>`;
    }

    box.innerHTML = `
      <ul style="list-style: none; font-size: 0.9rem; line-height: 1.8;">
        <li><strong>PHP Version:</strong> ${escapeHtml(data.php_version || 'N/A')}</li>
        <li><strong>Server Environment:</strong> ${escapeHtml(data.server_software || 'Apache')}</li>
        <li><strong>Max Upload Limit:</strong> ${escapeHtml(data.upload_max_filesize || 'N/A')}</li>
        <li><strong>Max POST Size:</strong> ${escapeHtml(data.post_max_size || 'N/A')}</li>
        <li><strong>Git Active Branch:</strong> <code>${escapeHtml(data.git_branch || 'main')}</code></li>
        <li><strong>Last Git Commit:</strong> ${escapeHtml(data.git_commit || 'Active')}</li>
        <li><strong>Root Directory:</strong> <code>${escapeHtml(data.root_dir || '')}</code></li>
      </ul>
      <p style="margin-top: 1rem; font-size: 0.85rem; color: #059669; font-weight: 600;">
        ✓ Self-hosted system active. Fully decoupled from Netlify and zero third-party dependencies.
      </p>
    `;
  } catch (err) {
    box.innerHTML = '<p class="text-danger">Could not fetch server information.</p>';
  }
}

// Utility
function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function ucwords(str) {
  return String(str).replace(/\b\w/g, l => l.toUpperCase());
}
