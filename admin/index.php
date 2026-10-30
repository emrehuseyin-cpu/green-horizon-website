<?php
/**
 * GREEN HORIZON — Self-Hosted Visual Content Management System
 * Official Admin Dashboard for HostGator / cPanel / Standard Apache & PHP Hosting
 */

require_once __DIR__ . '/config.php';
$isLoggedIn = gh_is_logged_in();
$csrfToken = gh_get_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Horizon — Admin Control Panel</title>
  <link rel="icon" href="../assets/images/logo-greenhorizon-emblem.png">
  <link rel="stylesheet" href="admin.css?v=20261031">
</head>
<body class="<?= $isLoggedIn ? 'dashboard-view' : 'login-view' ?>">

  <!-- ===================================================================== -->
  <!-- 1. LOGIN SCREEN -->
  <!-- ===================================================================== -->
  <div id="login-modal" class="login-wrapper" style="<?= $isLoggedIn ? 'display: none;' : '' ?>">
    <div class="login-card">
      <div class="login-brand">
        <img src="../assets/images/logo-greenhorizon-emblem.png" alt="Green Horizon" class="login-logo">
        <h2>Green Horizon</h2>
        <p class="login-subtitle">Self-Hosted Admin Control Panel</p>
      </div>

      <form id="login-form">
        <div class="form-group">
          <label for="admin-password">Admin Password</label>
          <input type="password" id="admin-password" class="form-control" placeholder="Enter password" required autocomplete="current-password">
          <small class="form-help">Default password: <code>greenhorizon2026</code></small>
        </div>

        <div id="login-error" class="alert alert-danger" style="display: none;"></div>

        <button type="submit" class="btn btn-primary btn-block" id="login-btn">
          Sign In to Dashboard
        </button>
      </form>

      <div class="login-footer">
        <a href="../" target="_blank">← Return to Website</a>
      </div>
    </div>
  </div>

  <!-- ===================================================================== -->
  <!-- 2. MAIN DASHBOARD (Protected) -->
  <!-- ===================================================================== -->
  <div id="dashboard-wrapper" class="dashboard-layout" style="<?= $isLoggedIn ? '' : 'display: none;' ?>">

    <!-- Top Navigation Header -->
    <header class="admin-header">
      <div class="header-left">
        <img src="../assets/images/logo-greenhorizon-emblem.png" alt="Green Horizon" class="header-logo">
        <div>
          <h1 class="header-title">Green Horizon Admin</h1>
          <span class="header-badge">Erasmus+ KA210-YOU</span>
        </div>
      </div>

      <div class="header-right">
        <a href="../" target="_blank" class="btn btn-outline btn-sm">
          <span>View Live Website</span> ↗
        </a>
        <button id="logout-btn" class="btn btn-danger btn-sm">
          Sign Out
        </button>
      </div>
    </header>

    <div class="admin-main">
      <!-- Sidebar Navigation -->
      <aside class="admin-sidebar">
        <nav class="sidebar-nav">
          <button class="nav-item active" data-tab="videos">
            <span class="nav-icon">🎬</span>
            <span class="nav-label">Videos & Campaigns</span>
          </button>
          <button class="nav-item" data-tab="albums">
            <span class="nav-icon">📸</span>
            <span class="nav-label">Photo Albums (A1–A7)</span>
          </button>
          <button class="nav-item" data-tab="content">
            <span class="nav-icon">📝</span>
            <span class="nav-label">Pages & Texts</span>
          </button>
          <button class="nav-item" data-tab="news">
            <span class="nav-icon">📰</span>
            <span class="nav-label">News & Articles</span>
          </button>
          <button class="nav-item" data-tab="settings">
            <span class="nav-icon">⚙️</span>
            <span class="nav-label">Settings & Password</span>
          </button>
        </nav>

        <div class="sidebar-footer">
          <p><strong>Hosting:</strong> cPanel / Apache</p>
          <p class="git-version" id="git-status-badge">Git: <code>main</code></p>
        </div>
      </aside>

      <!-- Main Content Area -->
      <main class="admin-content">
        <div id="global-alert" class="alert" style="display: none;"></div>

        <!-- =============================================================== -->
        <!-- TAB 1: VIDEOS & CAMPAIGNS -->
        <!-- =============================================================== -->
        <section id="tab-videos" class="admin-tab-pane active">
          <div class="tab-header">
            <div>
              <h2>Campaign Documentaries & Promotional Video</h2>
              <p>Preview playable videos, update video details, or upload/replace MP4 video files and poster images.</p>
            </div>
            <button class="btn btn-outline btn-sm" onclick="loadVideos()">↻ Refresh Videos</button>
          </div>

          <div id="videos-grid" class="videos-grid">
            <div class="loading-spinner">Loading videos...</div>
          </div>
        </section>

        <!-- =============================================================== -->
        <!-- TAB 2: PHOTO ALBUMS (A1–A7) -->
        <!-- =============================================================== -->
        <section id="tab-albums" class="admin-tab-pane">
          <div class="tab-header">
            <div>
              <h2>Photo Albums & Activity Galleries</h2>
              <p>Manage authentic photos for mobilities, local workshops, exhibition, and main gallery.</p>
            </div>
          </div>

          <div class="album-controls-bar">
            <label for="album-select" style="font-weight: 600; margin-right: 0.5rem;">Select Album:</label>
            <select id="album-select" class="form-control" style="max-width: 400px; display: inline-block;">
              <option value="a1-kickoff">A1 Kick-Off Meeting (Bonn, Germany)</option>
              <option value="a2-training-course">A2 Youth Training Course (Brașov, Romania)</option>
              <option value="a4-de">A4 Local Workshops (Germany)</option>
              <option value="a4-ro">A4 Local Workshops (Romania)</option>
              <option value="a4-tr">A4 Local Workshops (Türkiye)</option>
              <option value="a5-films-exhibition">A5 Campaign Films & VR Exhibition</option>
              <option value="a7-ro">A7 Dissemination (Romania)</option>
              <option value="a7-tr">A7 Dissemination (Türkiye)</option>
              <option value="a7-de">A7 Dissemination (Germany)</option>
              <option value="a7-final">A7 Final Transnational Meeting</option>
              <option value="gallery">Main Website Photo Gallery</option>
            </select>
          </div>

          <!-- Upload Box -->
          <div class="card upload-card" style="margin-bottom: 2rem;">
            <h3>Upload New Photo to Selected Album</h3>
            <form id="upload-photo-form" enctype="multipart/form-data">
              <input type="hidden" name="album" id="upload-album-id" value="a1-kickoff">
              <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

              <div class="upload-dropzone" id="upload-dropzone">
                <input type="file" id="photo-file-input" name="photo" accept="image/*" required>
                <div class="dropzone-prompt">
                  <span style="font-size: 2rem;">📤</span>
                  <p><strong>Click to browse</strong> or drag &amp; drop an image file here</p>
                  <small>Supported: JPG, JPEG, PNG, WEBP</small>
                </div>
              </div>

              <div class="form-row" style="margin-top: 1rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                <div class="form-group">
                  <label>Caption (English)</label>
                  <input type="text" name="caption_en" class="form-control" placeholder="Photo caption in English">
                </div>
                <div class="form-group">
                  <label>Photo Credit</label>
                  <input type="text" name="credit" class="form-control" placeholder="e.g. Integrational e.V.">
                </div>
              </div>

              <button type="submit" class="btn btn-primary" id="upload-photo-btn" style="margin-top: 1rem;">
                Upload Photo
              </button>
            </form>
          </div>

          <!-- Album Photos Grid -->
          <div class="album-photos-header">
            <h3 id="album-photos-title">Album Photos</h3>
            <span id="album-photos-count" class="badge">0 photos</span>
          </div>

          <div id="album-photos-grid" class="album-photos-grid">
            <div class="loading-spinner">Loading photos...</div>
          </div>
        </section>

        <!-- =============================================================== -->
        <!-- TAB 3: PAGES & TEXT CONTENT -->
        <!-- =============================================================== -->
        <section id="tab-content" class="admin-tab-pane">
          <div class="tab-header">
            <div>
              <h2>Website Content & Texts</h2>
              <p>Edit titles, descriptions, objectives, and information across all pages.</p>
            </div>
          </div>

          <div class="content-editor-layout">
            <div class="content-file-selector">
              <button class="content-file-btn active" data-file="home">Homepage</button>
              <button class="content-file-btn" data-file="about">About Project</button>
              <button class="content-file-btn" data-file="results">Results & Deliverables</button>
              <button class="content-file-btn" data-file="contact">Contact Information</button>
              <button class="content-file-btn" data-file="site-settings">Site Settings & Disclaimer</button>
            </div>

            <div class="content-editor-card card">
              <div class="content-editor-toolbar">
                <h3 id="editing-file-title">Editing Homepage</h3>
                <button id="save-content-btn" class="btn btn-primary">
                  💾 Save All Changes
                </button>
              </div>

              <div id="content-fields-container" class="content-fields-container">
                <div class="loading-spinner">Loading content editor...</div>
              </div>
            </div>
          </div>
        </section>

        <!-- =============================================================== -->
        <!-- TAB 4: NEWS & ARTICLES -->
        <!-- =============================================================== -->
        <section id="tab-news" class="admin-tab-pane">
          <div class="tab-header">
            <div>
              <h2>News & Project Updates</h2>
              <p>Publish project news, consortium updates, and activity articles.</p>
            </div>
            <button class="btn btn-primary btn-sm" onclick="openNewArticleModal()">
              + Create New Article
            </button>
          </div>

          <div id="news-articles-list" class="news-articles-list">
            <div class="loading-spinner">Loading articles...</div>
          </div>
        </section>

        <!-- =============================================================== -->
        <!-- TAB 5: SETTINGS & SECURITY -->
        <!-- =============================================================== -->
        <section id="tab-settings" class="admin-tab-pane">
          <div class="tab-header">
            <div>
              <h2>Admin Security & Hosting Configuration</h2>
              <p>Manage admin credentials, view hosting information, and check git deployment status.</p>
            </div>
          </div>

          <div class="settings-grid">
            <!-- Password Change Card -->
            <div class="card">
              <h3>Change Admin Password</h3>
              <form id="change-password-form">
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                <div class="form-group">
                  <label for="current-password">Current Password</label>
                  <input type="password" id="current-password" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="new-password">New Password (min 6 characters)</label>
                  <input type="password" id="new-password" class="form-control" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary" id="change-pwd-btn">
                  Update Password
                </button>
              </form>
            </div>

            <!-- Server & Git Information Card -->
            <div class="card">
              <h3>Hosting & Git Environment</h3>
              <div id="system-status-info" class="system-status-box">
                <p>Loading server details...</p>
              </div>
            </div>
          </div>
        </section>

      </main>
    </div>
  </div>

  <input type="hidden" id="global-csrf" value="<?= $csrfToken ?>">
  <script src="admin.js?v=20261031"></script>
</body>
</html>
