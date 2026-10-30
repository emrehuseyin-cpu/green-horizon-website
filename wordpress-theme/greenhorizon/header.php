<?php
/**
 * GREEN HORIZON — Official Theme Header
 */
if (!defined('ABSPATH')) exit;
$options = get_option('greenhorizon_options', []);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?= esc_url(gh_asset('images/logo-greenhorizon-emblem.png')) ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- Accessibility Skip Link -->
  <a href="#main-content" class="skip-link">Skip to main content</a>

  <!-- Top Official Institutional Logo Row (Booklet Style) -->
  <header class="site-header" role="banner">
    <div class="header-institutional-bar">
      <div class="container institutional-logos-wrapper">
        <a href="<?= esc_url(home_url('/')) ?>" class="eu-co-funded-brand" aria-label="Co-funded by the European Union">
          <img src="<?= esc_url(gh_asset('images/eu-flag-official.png')) ?>" alt="Co-funded by the European Union" class="eu-emblem-img">
        </a>
        <div class="partner-logo-strip">
          <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-badge.svg')) ?>" alt="Green Horizon" class="partner-logo-item" style="border-radius: 50%;">
          <img src="<?= esc_url(gh_asset('images/partners/integrational-official.png')) ?>" alt="Integrational e.V." class="partner-logo-item">
          <img src="<?= esc_url(gh_asset('images/partners/iesa-official.png')) ?>" alt="Yenilikçi Eğitim Bilim ve Sanat Derneği (IESA)" class="partner-logo-item">
          <img src="<?= esc_url(gh_asset('images/partners/empower-plus-official.png')) ?>" alt="Asociația Empower Plus" class="partner-logo-item">
        </div>
      </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="header-nav-bar">
      <div class="container header-nav-container">
        <a href="<?= esc_url(home_url('/')) ?>" class="site-brand-pill" aria-label="Green Horizon: Youth Voices for Climate Action Through Drone Technology">
          <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-badge.svg')) ?>" alt="Green Horizon Emblem" width="48" height="48">
          <div>
            <span class="site-brand-name">GREEN HORIZON</span>
            <span class="site-brand-tagline">YOUTH VOICES FOR CLIMATE ACTION THROUGH DRONE TECHNOLOGY</span>
          </div>
        </a>

        <nav class="nav-desktop" role="navigation" aria-label="Main Navigation">
          <ul class="nav-links">
            <li><a href="<?= esc_url(home_url('/')) ?>" class="nav-link <?= is_front_page() ? 'active' : '' ?>">Home</a></li>
            <li><a href="<?= esc_url(home_url('/about')) ?>" class="nav-link <?= is_page('about') ? 'active' : '' ?>">About</a></li>
            <li><a href="<?= esc_url(home_url('/partners')) ?>" class="nav-link <?= is_page('partners') ? 'active' : '' ?>">Partners</a></li>
            <li><a href="<?= esc_url(home_url('/activities')) ?>" class="nav-link <?= is_page('activities') ? 'active' : '' ?>">Activities</a></li>
            <li><a href="<?= esc_url(home_url('/gallery')) ?>" class="nav-link <?= is_page('gallery') ? 'active' : '' ?>">Gallery</a></li>
            <li><a href="<?= esc_url(home_url('/stories')) ?>" class="nav-link <?= is_page('stories') ? 'active' : '' ?>">Climate Stories</a></li>
            <li><a href="<?= esc_url(home_url('/exhibition')) ?>" class="nav-link <?= is_page('exhibition') ? 'active' : '' ?>">Exhibition</a></li>
            <li><a href="<?= esc_url(home_url('/resources')) ?>" class="nav-link <?= is_page('resources') ? 'active' : '' ?>">Resources</a></li>
            <li><a href="<?= esc_url(home_url('/news')) ?>" class="nav-link <?= is_page('news') || is_home() || is_singular('post') ? 'active' : '' ?>">News</a></li>
            <li><a href="<?= esc_url(home_url('/contact')) ?>" class="nav-link <?= is_page('contact') ? 'active' : '' ?>">Contact</a></li>
          </ul>
        </nav>

        <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
          <span>Menu</span>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile Navigation Drawer -->
  <div class="mobile-drawer-overlay"></div>
  <aside class="mobile-drawer" aria-label="Mobile Navigation">
    <div>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.85rem;">
        <a href="<?= esc_url(home_url('/')) ?>" class="site-brand-pill">
          <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-badge.svg')) ?>" alt="Green Horizon" width="40" height="40">
          <div>
            <span class="site-brand-name" style="font-size: 1.15rem;">GREEN HORIZON</span>
          </div>
        </a>
        <button class="mobile-drawer-close" aria-label="Close navigation menu">&times;</button>
      </div>
      <ul class="mobile-nav-links">
        <li><a href="<?= esc_url(home_url('/')) ?>" class="mobile-nav-link <?= is_front_page() ? 'active' : '' ?>">Home</a></li>
        <li><a href="<?= esc_url(home_url('/about')) ?>" class="mobile-nav-link <?= is_page('about') ? 'active' : '' ?>">About the Project</a></li>
        <li><a href="<?= esc_url(home_url('/partners')) ?>" class="mobile-nav-link <?= is_page('partners') ? 'active' : '' ?>">Project Partners</a></li>
        <li><a href="<?= esc_url(home_url('/activities')) ?>" class="mobile-nav-link <?= is_page('activities') ? 'active' : '' ?>">Activities &amp; Timeline</a></li>
        <li><a href="<?= esc_url(home_url('/gallery')) ?>" class="mobile-nav-link <?= is_page('gallery') ? 'active' : '' ?>">Photo Gallery</a></li>
        <li><a href="<?= esc_url(home_url('/stories')) ?>" class="mobile-nav-link <?= is_page('stories') ? 'active' : '' ?>">Climate Stories</a></li>
        <li><a href="<?= esc_url(home_url('/exhibition')) ?>" class="mobile-nav-link <?= is_page('exhibition') ? 'active' : '' ?>">Virtual Exhibition</a></li>
        <li><a href="<?= esc_url(home_url('/resources')) ?>" class="mobile-nav-link <?= is_page('resources') ? 'active' : '' ?>">Educational Resources</a></li>
        <li><a href="<?= esc_url(home_url('/news')) ?>" class="mobile-nav-link <?= is_page('news') || is_home() || is_singular('post') ? 'active' : '' ?>">News &amp; Updates</a></li>
        <li><a href="<?= esc_url(home_url('/contact')) ?>" class="mobile-nav-link <?= is_page('contact') ? 'active' : '' ?>">Contact Us</a></li>
      </ul>
    </div>
  </aside>

  <!-- Main Content Anchor -->
  <main id="main-content">
