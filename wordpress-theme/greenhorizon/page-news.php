<?php
/**
 * Template Name: News & Updates
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Dissemination</span>
        <h1 class="section-title">News &amp; Project Updates</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          Follow the milestones, publications, training reports, and youth actions from our partnership.
        </p>
      </div>
    </section>

    <!-- News Filter & Archive -->
    <section class="section" style="padding-top: 1.5rem;">
      <div class="container">
        <!-- Filter Bar -->
        <div class="gallery-filter-bar" style="margin-bottom: 2rem;">
          <button class="news-filter-btn gallery-filter-btn active" data-filter="all">All Updates</button>
          <button class="news-filter-btn gallery-filter-btn" data-filter="Publication Release">Publication Release</button>
          <button class="news-filter-btn gallery-filter-btn" data-filter="Training Mobility">Training Mobility</button>
          <button class="news-filter-btn gallery-filter-btn" data-filter="Local Action">Local Action</button>
          <button class="news-filter-btn gallery-filter-btn" data-filter="Media Release">Media Release</button>
          <button class="news-filter-btn gallery-filter-btn" data-filter="Dissemination &amp; Closing">Dissemination &amp; Closing</button>
        </div>

        <!-- Search Bar -->
        <div style="max-width: 480px; margin: 0 auto 2.5rem auto;">
          <input type="text" id="news-search-input" placeholder="Search news articles..." aria-label="Search news" style="width: 100%; padding: 0.75rem 1.25rem; border-radius: var(--radius-full); border: 1px solid var(--border-color); font-family: var(--font-body); font-size: 0.95rem;">
        </div>

        <!-- News Grid (Loaded via assets/js/news.js from news.json) -->
        <div id="news-articles-container" class="news-grid">
          <!-- Dynamically populated -->
        </div>
      </div>
    </section>

  <div id="article-modal" class="lightbox-modal" role="dialog" aria-modal="true" aria-label="Article Details">
    <div style="background: #FFFFFF; border-radius: var(--radius-card); padding: 2.5rem; max-width: 780px; width: 90vw; max-height: 85vh; overflow-y: auto; position: relative; box-shadow: var(--shadow-modal);">
      <button onclick="closeArticleModal()" aria-label="Close article" style="position: absolute; top: 1rem; right: 1rem; background: var(--bg-soft); border: none; font-size: 1.5rem; width: 36px; height: 36px; border-radius: 50%; cursor: pointer;">
        &times;
      </button>

      <span id="article-modal-meta" style="font-size: 0.85rem; color: var(--text-light); font-weight: 600; display: block; margin-bottom: 0.5rem;"></span>
      <h2 id="article-modal-title" style="color: var(--primary); font-size: 1.6rem; margin-bottom: 1.25rem; line-height: 1.3;"></h2>
      <div id="article-modal-content" style="color: var(--text-muted); font-size: 1rem; line-height: 1.7;"></div>
    </div>
<?php
get_footer();
