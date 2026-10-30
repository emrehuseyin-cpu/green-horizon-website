<?php
/**
 * Default Page Template
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<section class="section-hero booklet-bg-pattern">
  <div class="container" style="text-align: center;">
    <span class="section-eyebrow">Green Horizon</span>
    <h1 class="section-title"><?php the_title(); ?></h1>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width: 920px;">
    <div class="card" style="padding: 2.5rem; line-height: 1.8; font-size: 1.05rem;">
      <?php
      if (have_posts()) :
        while (have_posts()) : the_post();
          the_content();
        endwhile;
      endif;
      ?>
    </div>
  </div>
</section>

<?php
get_footer();
