<?php
/**
 * Single Post Template (News & Updates)
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<?php while (have_posts()) : the_post(); ?>
<section class="section-hero booklet-bg-pattern">
  <div class="container" style="text-align: center;">
    <div style="margin-bottom: 0.75rem;">
      <a href="<?= esc_url(home_url('/news')) ?>" style="display: inline-flex; align-items: center; gap: 0.4rem; color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.9rem;">
        &larr; Back to News &amp; Updates
      </a>
    </div>
    <span class="section-eyebrow"><?= strip_tags(get_the_category_list(', ') ?: 'Project News') ?></span>
    <h1 class="section-title" style="max-width: 900px; margin: 0 auto 1rem auto;"><?php the_title(); ?></h1>
    <div style="display: inline-flex; align-items: center; gap: 1rem; color: var(--text-light); font-size: 0.9rem; flex-wrap: wrap; justify-content: center;">
      <span>🗓 <?php echo get_the_date(); ?></span>
      <span>•</span>
      <span>✍️ <?php the_author(); ?></span>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 2rem;">
  <div class="container" style="max-width: 860px;">
    <article class="card card-accent-green" style="padding: 2.5rem; margin-bottom: 3rem;">
      <?php if (has_post_thumbnail()) : ?>
        <div style="margin: -2.5rem -2.5rem 2rem -2.5rem; overflow: hidden; border-radius: var(--radius-card) var(--radius-card) 0 0;">
          <?php the_post_thumbnail('large', ['style' => 'width: 100%; max-height: 480px; object-fit: cover;']); ?>
        </div>
      <?php endif; ?>

      <div class="post-content" style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main);">
        <?php the_content(); ?>
      </div>

      <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <a href="<?= esc_url(home_url('/news')) ?>" class="btn btn-outline btn-sm">
          &larr; All Project News
        </a>
        <a href="<?= esc_url(home_url('/')) ?>" class="btn btn-secondary btn-sm">
          Visit Homepage &rarr;
        </a>
      </div>
    </article>
  </div>
</section>
<?php endwhile; ?>

<?php
get_footer();
