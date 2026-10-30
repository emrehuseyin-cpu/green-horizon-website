<?php
/**
 * Template Name: Climate Stories
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
        <span class="section-eyebrow">Activity A5 • Media Series</span>
        <h1 class="section-title">Short Climate Campaigns</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          Documentary series · 3 videos from Germany, Romania and Türkiye
        </p>
      </div>
    </section>

    <!-- 3 Documentary Film Slots Grid -->
    <section class="section" style="padding-top: 2rem;">
      <div class="container">
        <div class="section-header" style="text-align: left; margin-bottom: 2.5rem;">
          <h2 style="font-size: 1.8rem; margin-bottom: 0.5rem;">Short Climate Campaigns (3 Videos)</h2>
          <p style="color: var(--text-muted); margin: 0;">
            Watch each video produced during our local youth workshops and training course.
          </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 2.5rem;">

          <!-- Film 01: Germany (Bonn Parklands) -->
          <article class="media-embed-slot" id="film-01">
            <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000; overflow: hidden;">
              <video controls preload="metadata" poster="<?= esc_url(gh_asset('video/poster-germany.jpg')) ?>" playsinline style="width: 100%; height: 100%; object-fit: contain; display: block;">
                <source src="<?= esc_url(gh_asset('video/campaign-germany.mp4')) ?>" type="video/mp4">
                Your browser does not support HTML5 video playback.
              </video>
            </div>
            <div class="media-slot-body">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Eco-Action &amp; Reduction</span>
              <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">
                Reduce & Reconnect: Aerial Perspectives & Youth Eco-Action in Bonn
              </h3>
              <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
                Youth participants in Bonn capture aerial drone views of urban lake ecosystems and parklands, raising smartphone banners to advocate for conscious consumption ('REDUCE') and Erasmus+ youth-led climate responsibility.
              </p>
              <div style="font-size: 0.82rem; color: var(--text-light); font-weight: 600;">
                Production: Integrational e.V. Youth Media Lab • Bonn, Germany
              </div>
            </div>
          </article>

          <!-- Film 02: Romania (Carpathian Valleys) -->
          <article class="media-embed-slot" id="film-02">
            <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000; overflow: hidden;">
              <video controls preload="metadata" poster="<?= esc_url(gh_asset('video/poster-romania.jpg')) ?>" playsinline style="width: 100%; height: 100%; object-fit: contain; display: block;">
                <source src="<?= esc_url(gh_asset('video/campaign-romania.mp4')) ?>" type="video/mp4">
                Your browser does not support HTML5 video playback.
              </video>
            </div>
            <div class="media-slot-body">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Freshwater &amp; Forest Protection</span>
              <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">
                Stop Water Contamination: Aerial Guardians of Carpathian Valleys
              </h3>
              <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
                Romanian youth teams deploy camera drones above mountain parklands in Brașov, pairing sweeping canopy views with an urgent on-camera call to safeguard freshwater reserves and stop water contamination.
              </p>
              <div style="font-size: 0.82rem; color: var(--text-light); font-weight: 600;">
                Production: Asociația Empower Plus • Brașov, Romania
              </div>
            </div>
          </article>

          <!-- Film 03: Türkiye (Mersin) -->
          <article class="media-embed-slot" id="film-03">
            <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000000; overflow: hidden;">
              <video controls preload="metadata" poster="<?= esc_url(gh_asset('video/poster-turkiye.jpg')) ?>" playsinline style="width: 100%; height: 100%; object-fit: contain; display: block;">
                <source src="<?= esc_url(gh_asset('video/campaign-turkiye.mp4')) ?>" type="video/mp4">
                Your browser does not support HTML5 video playback.
              </video>
            </div>
            <div class="media-slot-body">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Plastic Waste &amp; Circular Action</span>
              <h3 style="font-size: 1.25rem; margin-bottom: 0.6rem; color: var(--primary);">
                Stop Plastic Waste: Youth Recycling & Circular Action in Mersin
              </h3>
              <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
                Young advocates in Mersin take to public spaces with grassroots campaign signs—'RECYCLE' and 'STOP PLASTIC WASTE'—highlighting the daily battle against single-use plastics and mobilizing youth for circular waste management.
              </p>
              <div style="font-size: 0.82rem; color: var(--text-light); font-weight: 600;">
                Production: IESA Youth Media Team • Mersin, Türkiye
              </div>
            </div>
          </article>

        </div>
      </div>
    </section>
<?php
get_footer();
