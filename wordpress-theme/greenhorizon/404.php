<?php
/**
 * Template Name: 404 Not Found
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<div class="container" style="text-align: center; max-width: 620px;">
      <div class="card card-accent-green" style="padding: 3rem 2rem;">
        <span class="booklet-chapter-pill pill-safety" style="margin-bottom: 1rem;">Page Not Found</span>
        <h1 style="font-size: 4.5rem; color: var(--primary); margin-bottom: 0.5rem; line-height: 1;">404</h1>
        <h2 style="font-size: 1.6rem; margin-bottom: 1rem; color: var(--text-main);">We couldn't find that page</h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 2rem; line-height: 1.6;">
          The page or file you are looking for might have been moved, renamed, or is temporarily unavailable.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <a href="<?= esc_url(home_url('/')) ?>" class="btn btn-primary btn-lg" style="text-decoration: none;">Return to Homepage</a>
          <a href="<?= esc_url(home_url('/contact')) ?>" class="btn btn-secondary btn-lg" style="text-decoration: none;">Contact Us</a>
        </div>
      </div>
    </div>
<?php
get_footer();
