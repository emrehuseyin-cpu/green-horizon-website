<?php
/**
 * Template Name: Home — Front Page
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<!-- Hero Section (Light Booklet Style) -->
    <section class="section-hero booklet-bg-pattern" aria-label="Introduction Hero">
      <div class="container">
        <div style="max-width: 900px; margin: 0 auto; text-align: center;">
          <!-- Small Flags in Hero: Germany, Romania, Türkiye -->
          <div class="hero-flags-badge">
            <span>Germany 🇩🇪</span>
            <span>•</span>
            <span>Romania 🇷🇴</span>
            <span>•</span>
            <span>Türkiye 🇹🇷</span>
          </div>

          <h1 class="section-title" style="font-size: clamp(2rem, 3.8vw, 3.2rem); margin-bottom: 1.25rem;">
            <?= esc_html(gh_get_option('hero_title', 'GREEN HORIZON: YOUTH VOICES FOR CLIMATE ACTION THROUGH DRONE TECHNOLOGY')) ?>
          </h1>

          <p class="section-subtitle" style="font-size: 1.15rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 2rem;">
            <?= esc_html(gh_get_option('hero_subtitle', 'An Erasmus+ youth partnership equipping young people and youth workers with practical skills in camera drone piloting, environmental photography, and visual storytelling to document climate challenges and drive community action.')) ?>
          </p>

          <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem;">
            <a href="<?= esc_url(gh_get_option('booklet_en', gh_asset('downloads/Green_Horizon_Booklet_Official.pdf'))) ?>" download class="btn btn-primary btn-lg" style="text-decoration: none;">
              📖 Download Educational Booklet (PDF)
            </a>
            <a href="<?= esc_url(gh_get_option('vr_embed_url', 'https://metasteps.com/viewer/embed/832a0a3b-4ea0-413d-9b47-d9eccd1e1459?showSignIn=0&showCommunications=0&showOrbitButton=0&showSettingsButton=0&showSoundButton=0&showLikeButton=0&forceOrbitCamera=0')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-lg" style="text-decoration: none;">
              🥽 Visit the VR Exhibition
            </a>
            <a href="<?= esc_url(home_url('/gallery')) ?>" class="btn btn-outline btn-lg" style="text-decoration: none;">
              📸 Explore Photo Gallery
            </a>
            <a href="<?= esc_url(home_url('/activities')) ?>" class="btn btn-outline btn-lg" style="text-decoration: none;">
              🗓 Activities &amp; Timeline
            </a>
          </div>

          <!-- Project Quick Meta Pill -->
          <div style="display: inline-flex; align-items: center; gap: 0.8rem; background: #FFFFFF; border: 1px solid var(--border-color); padding: 0.5rem 1.2rem; border-radius: var(--radius-full); font-size: 0.85rem; color: var(--text-light); box-shadow: var(--shadow-sm); flex-wrap: wrap; justify-content: center;">
            <span>Project: <strong>2024-3-DE04-KA210-YOU-000293009</strong></span>
            <span>•</span>
            <span>Period: <strong>1 May 2025 – 31 August 2026</strong></span>
            <span>•</span>
            <span>Grant: <strong>€60,000.00</strong></span>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: HOMEPAGE DRONE VIDEO ("Our project from above") -->
    <section class="drone-video-section section-warm booklet-bg-pattern" aria-labelledby="drone-video-heading">
      <div class="container">
        <div class="section-header" style="margin-bottom: 2rem;">
          <span class="section-eyebrow">Aerial Perspective</span>
          <h2 id="drone-video-heading" class="section-title">Our Project from Above</h2>
          <p class="section-subtitle">
            Experience our local environments and transnational field training through aerial camera perspectives captured by youth participants.
          </p>
        </div>

        <div class="drone-video-wrapper">
          <div class="drone-video-player-box">
            <!-- Responsive 16:9 Video Player (Project Promotional Video) -->
            <video id="drone-mp4-player" controls preload="metadata" poster="<?= esc_url(gh_get_option('promo_poster_url', gh_asset('video/poster-promo.jpg'))) ?>" playsinline style="width: 100%; height: 100%; display: block; border-radius: var(--radius-md); object-fit: contain; background: #000000;">
              <source src="<?= esc_url(gh_get_option('promo_video_url', gh_asset('video/campaign-1-footage.mp4'))) ?>" type="video/mp4">
              Your browser does not support HTML5 video playback.
            </video>
          </div>

          <div class="drone-video-caption-bar">
            <h3 class="drone-video-title"><?= esc_html(gh_get_option('promo_title', 'Green Horizon: Official Promotional Video')) ?></h3>
            <p class="drone-video-description">
              <?= esc_html(gh_get_option('promo_description', 'The official promotional film of Green Horizon captures transnational youth climate advocacy and aerial drone perspectives across Germany, Romania, and Türkiye. From urban parklands in Bonn and Carpathian mountain canopies in Brașov to Mediterranean coastlines in Mersin, young participants document environmental shifts, champion conscious consumption, and prove how digital aerial skills inspire local ecological change.')) ?>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 3: CORE PROJECT OUTCOMES (Three Result Cards) -->
    <section class="section" aria-labelledby="outcomes-heading">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Key Results</span>
          <h2 id="outcomes-heading" class="section-title">What We Created Together</h2>
          <p class="section-subtitle">
            Explore the three tangible results developed during the Green Horizon partnership.
          </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
          <!-- Result Card 1: Educational Booklet -->
          <div class="card card-accent-green" style="display: flex; flex-direction: column;">
            <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1rem;">
              <img src="<?= esc_url(gh_asset('images/booklet-cover.jpg')) ?>" alt="Green Horizon Educational Booklet Cover" style="width: 80px; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); flex-shrink: 0;">
              <div>
                <span class="booklet-chapter-pill pill-ch1" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">Result 1 • Publication</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.3rem; margin-bottom: 0.2rem; line-height: 1.3;">Educational Booklet</h3>
                <p style="font-size: 0.8rem; color: var(--text-light); margin: 0;">Educational Booklet • CC BY-SA 4.0</p>
              </div>
            </div>
            <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 1.25rem; flex: 1;">
              Combines climate change mitigation principles, photographic composition masterclasses, camera drone flight safety, 6 flight drills, and a printable field checklist.
            </p>
            <div style="margin-top: auto;">
              <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; margin-bottom: 0.6rem;">
                <a href="<?= esc_url(gh_asset('downloads/green-horizon-booklet-en.pdf')) ?>" download="green-horizon-booklet-en.pdf" class="btn btn-primary btn-sm" style="text-decoration: none; padding: 0.35rem 0.55rem; font-size: 0.8rem;" title="Download in English">🇬🇧 EN</a>
                <a href="<?= esc_url(gh_asset('downloads/green-horizon-booklet-de.pdf')) ?>" download="green-horizon-booklet-de.pdf" class="btn btn-primary btn-sm" style="text-decoration: none; padding: 0.35rem 0.55rem; font-size: 0.8rem;" title="Auf Deutsch herunterladen">🇩🇪 DE</a>
                <a href="<?= esc_url(gh_asset('downloads/green-horizon-booklet-tr.pdf')) ?>" download="green-horizon-booklet-tr.pdf" class="btn btn-primary btn-sm" style="text-decoration: none; padding: 0.35rem 0.55rem; font-size: 0.8rem;" title="Türkçe İndir">🇹🇷 TR</a>
                <a href="<?= esc_url(gh_asset('downloads/green-horizon-booklet-ro.pdf')) ?>" download="green-horizon-booklet-ro.pdf" class="btn btn-primary btn-sm" style="text-decoration: none; padding: 0.35rem 0.55rem; font-size: 0.8rem;" title="Descarcă în Română">🇷🇴 RO</a>
              </div>
              <a href="<?= esc_url(home_url('/resources#result-booklet')) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Overview &amp; Modules &rarr;</a>
            </div>
          </div>

          <!-- Result Card 2: Short Climate Campaigns -->
          <div class="card card-accent-blue" style="display: flex; flex-direction: column;">
            <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1rem;">
              <img src="<?= esc_url(gh_asset('images/booklet/poster-capture-the-change.jpg')) ?>" alt="Capture the Change Poster" style="width: 80px; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); flex-shrink: 0;">
              <div>
                <span class="booklet-chapter-pill pill-ch3" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">Result 2 • Media Series</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.3rem; margin-bottom: 0.2rem; line-height: 1.3;">Short Climate Campaigns</h3>
                <p style="font-size: 0.8rem; color: var(--text-light); margin: 0;">Documentary series · 3 videos from Germany, Romania and Türkiye</p>
              </div>
            </div>
            <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 1.25rem; flex: 1;">
              Grid of 3 documentary short films filmed and edited by youth participants, documenting riverbank health, forest recovery, and coastal ecosystems from above.
            </p>
            <div style="margin-top: auto;">
              <a href="<?= esc_url(home_url('/resources#result-documentaries')) ?>" class="btn btn-secondary btn-sm" style="text-decoration: none;">Watch 3 Videos &rarr;</a>
            </div>
          </div>

          <!-- Result Card 3: VR-Enhanced Photo Exhibition -->
          <div class="card card-accent-purple" style="display: flex; flex-direction: column;">
            <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1rem;">
              <img src="<?= esc_url(gh_asset('images/booklet/poster-chapter2-photography.jpg')) ?>" alt="VR-Enhanced Photo Exhibition" style="width: 80px; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); flex-shrink: 0;">
              <div>
                <span class="booklet-chapter-pill pill-ch2" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">Result 3 • VR-Enhanced Photo Exhibition</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.3rem; margin-bottom: 0.2rem; line-height: 1.3;">VR-Enhanced Photo Exhibition</h3>
                <p style="font-size: 0.8rem; color: var(--text-light); margin: 0;">Presented July 2026 • Online since October 2026</p>
              </div>
            </div>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 1.25rem; flex: 1;">
              Drone photos by young people from Germany, Romania and Türkiye. Presented at the dissemination conferences in July 2026 and online as a virtual exhibition since October 2026.
            </p>
            <div style="margin-top: auto; display: flex; gap: 0.6rem; flex-wrap: wrap;">
              <a href="https://metasteps.com/viewer/embed/832a0a3b-4ea0-413d-9b47-d9eccd1e1459?showSignIn=0&showCommunications=0&showOrbitButton=0&showSettingsButton=0&showSoundButton=0&showLikeButton=0&forceOrbitCamera=0" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" style="text-decoration: none; background: var(--purple); border-color: var(--purple);">Visit the VR exhibition &rarr;</a>
              <a href="<?= esc_url(home_url('/resources#result-vr-photo-exhibition')) ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Details</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 4: GALLERY PREVIEW STRIP -->
    <section class="section section-warm booklet-bg-pattern" aria-labelledby="gallery-preview-heading">
      <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
          <div>
            <span class="section-eyebrow">Visual Highlights</span>
            <h2 id="gallery-preview-heading" class="section-title" style="margin: 0;">Project Moments &amp; Photography</h2>
          </div>
          <a href="<?= esc_url(home_url('/gallery')) ?>" class="btn btn-primary" style="text-decoration: none;">
            View Full Gallery (All Photos) &rarr;
          </a>
        </div>

        <!-- 6–8 Dynamic Photos Rendered from gallery.json -->
        <div id="homepage-gallery-strip" class="gallery-grid" aria-live="polite">
          <!-- Rendered dynamically by assets/js/gallery.js -->
        </div>

        <div style="text-align: center; margin-top: 2rem;">
          <p style="font-size: 0.88rem; color: var(--text-light); font-style: italic;">
            Photos published with the consent of the people shown.
          </p>
        </div>
      </div>
    </section>

    <!-- SECTION 5: LATEST NEWS & UPDATES (3 Latest Posts) -->
    <section class="section" aria-labelledby="news-heading">
      <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
          <div>
            <span class="section-eyebrow">Dissemination</span>
            <h2 id="news-heading" class="section-title" style="margin: 0;">News &amp; Updates</h2>
          </div>
          <a href="<?= esc_url(home_url('/news')) ?>" class="btn btn-outline" style="text-decoration: none;">
            See All News &rarr;
          </a>
        </div>

        <!-- Top 3 News Cards Rendered dynamically by assets/js/main.js?v=20261028 -->
        <div id="homepage-news-grid" class="news-grid">
          <!-- Fallback or dynamic items -->
          <article class="news-card">
            <img class="news-card-thumb" src="<?= esc_url(gh_asset('images/booklet-cover.jpg')) ?>" alt="Booklet Cover" loading="lazy">
            <div class="news-card-body">
              <div class="news-card-meta">
                <span>🗓 October 2025</span>
                <span class="badge badge-completed">OER Publication</span>
              </div>
              <h3 class="news-card-title"><a href="<?= esc_url(home_url('/news')) ?>">Official Green Horizon Educational Booklet Published</a></h3>
              <p class="news-card-summary">The flagship open-access Educational Booklet 'Youth Voices for Climate Action Through Drone Technology' is now available for download.</p>
              <a href="<?= esc_url(home_url('/news')) ?>" class="news-card-action">Read more &rarr;</a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- SECTION 6: CONSORTIUM MAP -->
    <section class="section section-warm" aria-labelledby="consortium-heading">
      <div class="container">
        <div class="section-header">
          <span class="section-eyebrow">Transnational Partnership</span>
          <h2 id="consortium-heading" class="section-title">Where We Worked</h2>
          <p class="section-subtitle">
            Connecting youth across Germany, Romania, and Türkiye: Bonn (DE), Mersin (TR), and Brașov (RO).
          </p>
        </div>

        <div class="map-wrapper">
          <div id="consortium-map" aria-label="Interactive consortium map of Germany, Romania, and Türkiye"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
          <div class="card" style="padding: 1.25rem;">
            <h4 style="color: var(--primary); margin-bottom: 0.3rem;">Bonn, Germany 🇩🇪</h4>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
              <strong>Integrational e.V.</strong> — Project coordinator; VR photo exhibition, local workshops and dissemination.
            </p>
          </div>
          <div class="card" style="padding: 1.25rem;">
            <h4 style="color: var(--primary); margin-bottom: 0.3rem;">Brașov, Romania 🇷🇴</h4>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
              <strong>Asociația Empower Plus</strong> — Training course host (A2) and documentary series.
            </p>
          </div>
          <div class="card" style="padding: 1.25rem;">
            <h4 style="color: var(--primary); margin-bottom: 0.3rem;">Mersin, Türkiye 🇹🇷</h4>
            <p style="font-size: 0.88rem; color: var(--text-muted); margin: 0;">
              <strong>IESA</strong> — Booklet lead; host of the Mersin dissemination conference and final meeting.
            </p>
          </div>
        </div>
      </div>
    </section>
<?php
get_footer();
