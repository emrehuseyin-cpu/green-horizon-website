<?php
/**
 * Template Name: Virtual Exhibition
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<!-- Header Section -->
    <section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Activity A5 • Virtual Reality</span>
        <h1 class="section-title">Climate Photo &amp; Virtual Exhibition</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          An immersive virtual walkthrough curated on the MetaSteps platform, pairing high-resolution aerial and ground photography with youth reflections from Germany, Romania, and Türkiye.
        </p>
      </div>
    </section>

    <!-- 1. Virtual Exhibition Live Embed & Controls -->
    <section class="section" style="padding-top: 2rem;">
      <div class="container">
        <div class="exhibition-frame-box" style="background: #111827; border-radius: var(--radius-card); overflow: hidden; box-shadow: var(--shadow-card); border: 1px solid var(--border-color);">
          <!-- Top VR Player Header Bar -->
          <div style="background: #1F2937; padding: 0.85rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; border-bottom: 1px solid #374151;">
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
              <span class="badge badge-completed" style="font-size: 0.75rem;">Activity A5 • Live Exhibition</span>
              <span style="color: #FFFFFF; font-weight: 700; font-size: 1rem; font-family: var(--font-heading);">
                Green Horizon Virtual Exhibition Gallery Room
              </span>
            </div>
            <div style="display: flex; gap: 0.6rem; align-items: center;">
              <a href="<?= esc_url(gh_get_option('vr_embed_url', 'https://metasteps.com/viewer/embed/832a0a3b-4ea0-413d-9b47-d9eccd1e1459?showSignIn=0&showCommunications=0&showOrbitButton=0&showSettingsButton=0&showSoundButton=0&showLikeButton=0&forceOrbitCamera=0')) ?>" 
                 target="_blank" 
                 rel="noopener noreferrer" 
                 class="btn btn-primary btn-sm" 
                 style="font-size: 0.82rem; padding: 0.35rem 0.85rem; text-decoration: none;">
                ⛶ Open Fullscreen / New Tab
              </a>
            </div>
          </div>

          <!-- Responsive Virtual Exhibition Embed Iframe -->
          <div style="position: relative; width: 100%; min-height: 520px; height: 65vh; max-height: 750px; background: #000000;">
            <iframe 
              src="<?= esc_url(gh_get_option('vr_embed_url', 'https://metasteps.com/viewer/embed/832a0a3b-4ea0-413d-9b47-d9eccd1e1459?showSignIn=0&showCommunications=0&showOrbitButton=0&showSettingsButton=0&showSoundButton=0&showLikeButton=0&forceOrbitCamera=0')) ?>" 
              title="Green Horizon: Youth Voices for Climate Action Through Drone"
              width="100%" 
              height="100%" 
              style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; display: block;" 
              allow="fullscreen; xr-spatial-tracking; accelerometer; gyroscope"
              allowfullscreen>
            </iframe>
          </div>

          <!-- Bottom Navigation Guide Bar -->
          <div style="background: #FFFFFF; padding: 1.25rem 1.75rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
              <p style="margin: 0; font-size: 0.92rem; color: var(--text-main); font-weight: 600;">
                🎮 <strong>How to Explore:</strong> Click &amp; drag to look around • Click the floor markers to move • Click artworks to zoom &amp; inspect captions
              </p>
              <p style="margin: 0.25rem 0 0 0; font-size: 0.82rem; color: var(--text-light);">
                Curated by Asociația Empower Plus in collaboration with Integrational e.V. and IESA.
              </p>
            </div>
            <div>
              <a href="<?= esc_url(home_url('/gallery')) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">
                📸 Browse 2D Photo Gallery &rarr;
              </a>
            </div>
          </div>
        </div>

        <!-- Exhibition Overview & Curatorial Notes -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-top: 3rem;">
          <div class="card card-accent-green">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">Curatorial Concept</h3>
            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
              The exhibition is arranged into three thematic rooms mirroring the handbook: (1) Climate Urgency; (2) Photography &amp; Composition; (3) Aerial Drone Perspectives. Each room includes guided virtual audio notes.
            </p>
          </div>

          <div class="card card-accent-leaf">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">Interactive Guided Tours</h3>
            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
              Visitors can follow a self-guided walkthrough or use automated camera waypoints to inspect high-resolution photographs, contextual captions, and location notes from partner cities.
            </p>
          </div>

          <div class="card card-accent-purple">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">Accessible Anywhere</h3>
            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin: 0;">
              Runs directly inside standard modern web browsers on laptops, tablets, and smartphones without requiring proprietary VR headsets, making it ideal for classroom and youth center screenings.
            </p>
          </div>
        </div>
      </div>
    </section>
<?php
get_footer();
