<?php
/**
 * Template Name: Accessibility Statement
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Digital Inclusion</span>
        <h1 class="section-title">Accessibility Statement</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          Our commitment to ensuring the Green Horizon digital platform is accessible and usable for all European citizens, youth, and educators.
        </p>
      </div>
    </section>

    <section class="section" style="padding-top: 1.5rem;">
      <div class="container" style="max-width: 860px;">
        <div class="card card-accent-green" style="padding: 2.5rem;">
          <h2 style="font-size: 1.4rem; margin-bottom: 1rem; color: var(--primary);">Conformance Status</h2>
          <p style="color: var(--text-muted); line-height: 1.65; margin-bottom: 1.5rem;">
            Green Horizon strives to conform with the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA. These guidelines define how to make web content more accessible to people with disabilities, including blind and low-vision users, individuals with motor impairments, and cognitive differences.
          </p>

          <h2 style="font-size: 1.4rem; margin-bottom: 1rem; color: var(--primary);">Key Accessibility Features</h2>
          <ul style="color: var(--text-muted); line-height: 1.65; margin-bottom: 1.5rem; padding-left: 1.4rem;">
            <li><strong>High-Contrast Light Theme:</strong> Text elements strictly comply with WCAG AA minimum 4.5:1 contrast ratios (primary text ratio exceeds 10:1 on white).</li>
            <li><strong>Keyboard Navigability:</strong> All interactive elements, filter bars, photo slots, and lightbox modals are fully navigable using the Tab, Arrow, and Escape keys.</li>
            <li><strong>Alt Text on Media:</strong> All photographs and illustrations provide meaningful descriptive alternative text for screen reader users.</li>
            <li><strong>Skip to Content Link:</strong> A dedicated skip-navigation link allows assistive technology users to jump directly to main content.</li>
            <li><strong>Semantic HTML5:</strong> Structural landmarks (`header`, `nav`, `main`, `section`, `article`, `footer`) are used consistently across all pages.</li>
          </ul>

          <h2 style="font-size: 1.4rem; margin-bottom: 1rem; color: var(--primary);">Feedback &amp; Contact</h2>
          <p style="color: var(--text-muted); line-height: 1.65; margin: 0;">
            If you encounter any accessibility barriers on this website, please contact our coordinator at <strong>info@greenhorizonyou.eu</strong>. We actively review and improve accessibility across all project outputs.
          </p>
        </div>
      </div>
    </section>
<?php
get_footer();
