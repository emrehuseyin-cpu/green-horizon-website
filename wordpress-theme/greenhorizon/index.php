<?php
/**
 * Main Index / Fallback Archive Template
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
    <h1 class="section-title"><?php bloginfo('name'); ?></h1>
    <p class="section-subtitle"><?php bloginfo('description'); ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="news-grid">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="news-card">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium', ['class' => 'news-card-thumb']); ?>
          <?php else: ?>
            <img class="news-card-thumb" src="<?= esc_url(gh_asset('images/booklet-cover.jpg')) ?>" alt="<?php the_title_attribute(); ?>">
          <?php endif; ?>
          <div class="news-card-body">
            <div class="news-card-meta">
              <span>🗓 <?php echo get_the_date(); ?></span>
              <span class="badge badge-completed"><?= strip_tags(get_the_category_list(', ') ?: 'News') ?></span>
            </div>
            <h3 class="news-card-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="news-card-summary"><?php echo get_the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="news-card-action">
              Read article &rarr;
            </a>
          </div>
        </article>
      <?php endwhile; else: ?>
        <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 3rem;">No posts found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php
get_footer();
