<?php
/**
 * GREEN HORIZON — Official Theme Footer
 */
if (!defined('ABSPATH')) exit;
$options = get_option('greenhorizon_options', []);
$projectNumber = $options['project_number'] ?? '2024-3-DE04-KA210-YOU-000293009';
$coordinatorName = $options['coordinator_name'] ?? 'Integrational e.V. (Bonn, Germany)';
$euDisclaimer = $options['eu_disclaimer'] ?? 'Co-funded by the European Union. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or the German National Agency JUGEND für Europa. Neither the European Union nor the granting authority can be held responsible for them.';
$copyright = $options['copyright_text'] ?? 'Project results are published under the Creative Commons licence CC BY-SA 4.0.';
?>
  </main><!-- /#main-content -->

  <!-- Global Lightbox Modal -->
  <div id="global-lightbox-modal" class="lightbox-modal" role="dialog" aria-modal="true" aria-label="Image preview">
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
  </div>

  <!-- Official Footer & Strict EU Visibility Rules -->
  <footer class="site-footer" role="contentinfo">
    <div class="container">
      <!-- Official EU Visibility & Partner Logos Card -->
      <div class="footer-visibility-card">
        <div class="footer-logos-container">
          <!-- Official EU Emblem & Text -->
          <div class="footer-eu-brand">
            <img src="<?= esc_url(gh_asset('images/eu-flag-official.png')) ?>" alt="Co-funded by the European Union" class="footer-eu-flag">
          </div>

          <!-- Vertical Divider -->
          <div class="footer-logo-divider" aria-hidden="true"></div>

          <!-- Partner Logos (no taller than EU flag) -->
          <div class="footer-partner-strip">
            <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-badge.svg')) ?>" alt="Green Horizon" class="footer-partner-logo" style="border-radius: 50%;">
            <img src="<?= esc_url(gh_asset('images/partners/integrational-official.png')) ?>" alt="Integrational e.V." class="footer-partner-logo">
            <img src="<?= esc_url(gh_asset('images/partners/empower-plus-official.png')) ?>" alt="Asociația Empower Plus" class="footer-partner-logo">
            <img src="<?= esc_url(gh_asset('images/partners/iesa-official.png')) ?>" alt="Yenilikçi Eğitim Bilim ve Sanat Derneği (IESA)" class="footer-partner-logo">
          </div>
        </div>

        <p class="footer-project-number">Project number: <strong><?= esc_html($projectNumber) ?></strong></p>

        <!-- Official Disclaimer Text -->
        <p class="footer-disclaimer-text">
          <?= esc_html($euDisclaimer) ?>
        </p>
      </div>

      <div class="footer-grid">
        <div class="footer-col">
          <a href="<?= esc_url(home_url('/')) ?>" class="site-brand-pill" style="margin-bottom: 0.8rem;">
            <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-badge.svg')) ?>" alt="Green Horizon" width="40" height="40">
            <div>
              <span class="site-brand-name" style="font-size: 1.15rem;">GREEN HORIZON</span>
              <span class="site-brand-tagline" style="font-size: 0.58rem;">YOUTH VOICES FOR CLIMATE ACTION THROUGH DRONE TECHNOLOGY</span>
            </div>
          </a>
          <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.55;">
            An Erasmus+ Small-scale Partnership in Youth (1 May 2025 – 31 August 2026).
          </p>
          <p style="font-size: 0.82rem; color: var(--text-light); margin-top: 0.4rem;">
            Coordinator: <?= esc_html($coordinatorName) ?>
          </p>
        </div>

        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul class="footer-links">
            <li><a href="<?= esc_url(home_url('/')) ?>">Home</a></li>
            <li><a href="<?= esc_url(home_url('/about')) ?>">About the Project</a></li>
            <li><a href="<?= esc_url(home_url('/partners')) ?>">Project Partners</a></li>
            <li><a href="<?= esc_url(home_url('/activities')) ?>">Activities &amp; Timeline</a></li>
            <li><a href="<?= esc_url(home_url('/gallery')) ?>">Photo Gallery</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Results &amp; Media</h4>
          <ul class="footer-links">
            <li><a href="<?= esc_url(home_url('/resources')) ?>">Project Results</a></li>
            <li><a href="<?= esc_url(home_url('/stories')) ?>">Climate Stories</a></li>
            <li><a href="<?= esc_url(home_url('/exhibition')) ?>">Virtual Exhibition</a></li>
            <li><a href="<?= esc_url(home_url('/news')) ?>">News &amp; Updates</a></li>
            <li><a href="<?= esc_url(home_url('/contact')) ?>">Contact</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>European Programme</h4>
          <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.8rem;">
            Results and deliverables are accessible on the official European Commission platform:
          </p>
          <a href="https://erasmus-plus.ec.europa.eu/projects/search/details/2024-3-DE04-KA210-YOU-000293009" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="width: 100%; text-decoration: none;">
            Erasmus+ Results Platform &rarr;
          </a>
        </div>
      </div>

      <div class="footer-bottom">
        <p><?= esc_html($copyright) ?></p>
        <div class="footer-bottom-links">
          <a href="<?= esc_url(home_url('/privacy')) ?>">Privacy Policy</a>
          <a href="<?= esc_url(home_url('/accessibility')) ?>">Accessibility</a>
          <a href="<?= esc_url(home_url('/contact')) ?>">Contact</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Cookie Consent Banner -->
  <div id="cookie-consent-banner" class="cookie-consent-banner hidden" role="region" aria-label="Cookie &amp; Privacy Consent">
    <div class="cookie-consent-content">
      <span class="cookie-consent-icon" aria-hidden="true">🍪</span>
      <div class="cookie-consent-text">
        <strong>Privacy &amp; Cookie Preferences</strong>
        This website uses essential technical storage to ensure core features and accessibility. Learn more in our <a href="<?= esc_url(home_url('/privacy')) ?>">Privacy Policy</a>.
      </div>
    </div>
    <div class="cookie-consent-actions">
      <button id="cookie-decline-btn" type="button" class="btn btn-outline btn-sm">Essential Only</button>
      <button id="cookie-accept-btn" type="button" class="btn btn-primary btn-sm">Accept All</button>
    </div>
  </div>

  <?php wp_footer(); ?>
</body>
</html>
