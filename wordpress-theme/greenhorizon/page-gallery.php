<?php
/**
 * Template Name: Photo Gallery
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<!-- Gallery Hero Section -->
    <section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Project Media Archive</span>
        <h1 class="section-title">Green Horizon Photo Gallery</h1>
        <p class="section-subtitle" style="max-width: 760px; margin: 0 auto 1.5rem auto;">
          Authentic moments from our transnational mobilities, camera drone practice drills, and youth workshops in Germany, Romania, and Türkiye.
        </p>
      </div>
    </section>

    <!-- Filterable Masonry / Grid Gallery -->
    <section class="section" style="padding-top: 2rem;">
      <div class="container">
        <!-- Category Filter Bar -->
        <div class="gallery-filter-bar" role="toolbar" aria-label="Filter gallery by category">
          <button class="gallery-filter-btn active" data-category="all">All</button>
          <button class="gallery-filter-btn" data-category="Training course">Training course</button>
          <button class="gallery-filter-btn" data-category="Workshops Germany">Workshops Germany</button>
          <button class="gallery-filter-btn" data-category="Workshops Romania">Workshops Romania</button>
          <button class="gallery-filter-btn" data-category="Workshops Türkiye">Workshops Türkiye</button>
          <button class="gallery-filter-btn" data-category="Drone photography">Drone photography</button>
          <button class="gallery-filter-btn" data-category="Exhibition">Exhibition</button>
          <button class="gallery-filter-btn" data-category="Events">Events</button>
        </div>

        <!-- Gallery Grid -->
        <div id="gallery-grid-container" class="gallery-grid" aria-live="polite">
          <!-- Rendered dynamically via assets/js/gallery.js -->
        </div>

        <!-- Consent Note -->
        <div class="gallery-consent-notice">
          <p>Photos published with the consent of the people shown.</p>
        </div>
      </div>
    </section>
<?php
get_footer();
