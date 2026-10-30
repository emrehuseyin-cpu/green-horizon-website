<?php
/**
 * Template Name: Activities & Timeline
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
        <span class="section-eyebrow">Work Plan 2025–2026</span>
        <h1 class="section-title">Project Activities &amp; Timeline</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          All seven Erasmus+ work packages (A1–A7) implemented across the project period (1 May 2025 – 31 August 2026).
        </p>
      </div>
    </section>

    <!-- Project Activities Roadmap (Vertical Timeline) -->
    <section class="section" style="padding-top: 2rem;">
      <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
          <span class="section-eyebrow">Erasmus+ KA210-YOU • Official Roadmap</span>
          <h2 class="section-title">Chronological Timeline of Activities</h2>
          <p class="section-subtitle">
            A record of all project mobilities, training sessions, local youth workshops, publications, and final conferences across Germany, Romania, and Türkiye.
          </p>
        </div>

        <!-- Timeline Controls: Filter Pills & Quick Jump -->
        <div class="timeline-controls-bar" role="toolbar" aria-label="Activity timeline controls">
          <div class="timeline-filter-pills" role="tablist" aria-label="Filter activities by type">
            <button class="timeline-filter-btn active" data-filter="all" role="tab" aria-selected="true">All Activities (8)</button>
            <button class="timeline-filter-btn" data-filter="mobilities" role="tab" aria-selected="false">Mobilities &amp; Meetings (3)</button>
            <button class="timeline-filter-btn" data-filter="workshops" role="tab" aria-selected="false">Workshops &amp; Production (2)</button>
            <button class="timeline-filter-btn" data-filter="outcomes" role="tab" aria-selected="false">Outcomes &amp; Conferences (3)</button>
          </div>
          <div class="timeline-quick-jump">
            <span class="quick-jump-label">Quick Jump:</span>
            <div class="quick-jump-pills" aria-label="Jump directly to milestone number">
              <a href="#act-kickoff" class="quick-jump-pill" title="1. Kick-off Meeting">1</a>
              <a href="#act-training-course" class="quick-jump-pill" title="2. Training Course">2</a>
              <a href="#act-booklet" class="quick-jump-pill" title="3. Climate Booklet">3</a>
              <a href="#act-workshops" class="quick-jump-pill" title="4. Local Workshops (Türkiye · Germany · Romania)">4</a>
              <a href="#act-production" class="quick-jump-pill" title="5. Documentaries &amp; Photos">5</a>
              <a href="#act-conferences" class="quick-jump-pill" title="6. Dissemination Conferences (Romania · Türkiye · Germany)">6</a>
              <a href="#act-final-meeting" class="quick-jump-pill" title="7. Final Partner Meeting">7</a>
              <a href="#act-vr-launch" class="quick-jump-pill" title="8. VR Exhibition Online">8</a>
            </div>
          </div>
        </div>

        <div class="timeline-roadmap">
  <!-- Milestone 1: Kick-off Meeting -->
  <div class="timeline-milestone" id="act-kickoff" data-category="mobilities">
    <div class="timeline-milestone-marker">1</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Kick-off Meeting</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Germany</span>
                <span style="margin: 0 0.35rem;">•</span>
                <span>👥 Participants: <strong>[number of participants]</strong></span>
              </div>
            </div>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">28–29 July 2025</span>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
            Project coordinators, communication leads, and youth workers met in Germany to launch the Green Horizon partnership. The consortium aligned on work packages, established quality and risk monitoring protocols, and agreed on the training course curriculum.
          </p>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Kick-off Meeting -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a1-kickoff"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 2: Training Course on Drone Operation, Photography and Video Editing -->
  <div class="timeline-milestone" id="act-training-course" data-category="mobilities">
    <div class="timeline-milestone-marker">2</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Training Course on Drone Operation, Photography and Video Editing</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Brașov, Romania</span>
                <span style="margin: 0 0.35rem;">•</span>
                <span>👥 Participants: <strong>18 youth workers from 3 countries</strong></span>
              </div>
            </div>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">11–18 October 2025</span>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
            An intensive 8-day training course hosted by Asociația Empower Plus bringing together 18 youth workers from Germany, Romania, and Türkiye. Participants received hands-on training in camera drone flight safety, photographic framing, and video post-production to act as multipliers.
          </p>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Training Course -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a2-training-course"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 3: Booklet on Drone Operation, Photography and Effective Ways to Mitigate Climate Change -->
  <div class="timeline-milestone" id="act-booklet" data-category="outcomes">
    <div class="timeline-milestone-marker">3</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Booklet on Drone Operation, Photography and Effective Ways to Mitigate Climate Change</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Digital Publication (Open Access)</span>
              </div>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
            A comprehensive Educational Booklet co-authored by the partnership covering climate change mitigation concepts, photography composition, and drone operation safety rules. Includes 6 practical flight drills and a printable field checklist.
          </p>
          <div>
            <a href="<?= esc_url(gh_asset('downloads/Green_Horizon_Booklet_Official.pdf')) ?>" download class="btn btn-primary btn-sm" style="text-decoration: none;">
              📖 Download Educational Booklet (PDF) (CC BY-SA 4.0) &darr;
            </a>
          </div>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Booklet -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a3-booklet"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 4: Local Workshops (Multi-Country Switcher) -->
  <div class="timeline-milestone" id="act-workshops" data-category="workshops">
    <div class="timeline-milestone-marker">4</div>
    <div class="timeline-milestone-content card-accent-green country-switcher-container">
      <div class="country-switcher-header">
        <div>
          <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Local Youth Workshops</h2>
          <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
            <span>📍 Türkiye • Germany • Romania</span>
            <span style="margin: 0 0.35rem;">•</span>
            <span>📅 19–29 April 2026</span>
          </div>
        </div>
        <div class="country-nav-pills" role="tablist" aria-label="Select workshop country">
          <button class="country-nav-btn active" data-country-target="workshop-pane-tr" role="tab" aria-selected="true">
            <span>🇹🇷 Türkiye</span>
            <span class="country-nav-date">19 Apr</span>
          </button>
          <button class="country-nav-btn" data-country-target="workshop-pane-de" role="tab" aria-selected="false">
            <span>🇩🇪 Germany</span>
            <span class="country-nav-date">23 Apr</span>
          </button>
          <button class="country-nav-btn" data-country-target="workshop-pane-ro" role="tab" aria-selected="false">
            <span>🇷🇴 Romania</span>
            <span class="country-nav-date">29 Apr</span>
          </button>
        </div>
      </div>

      <!-- Workshop Tab 1: Türkiye -->
      <div class="country-tab-pane active" id="workshop-pane-tr">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Local Workshop – Türkiye</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Türkiye</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">19 April 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              Organized by IESA, trained youth workers guided local youth in camera drone flight basics, environmental observation, and photographic composition. Participants documented local coastal and urban ecological topics.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Local Workshop Türkiye -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a4-local-workshops/tr"></div>
          </div>
        </div>
      </div>

      <!-- Workshop Tab 2: Germany -->
      <div class="country-tab-pane" id="workshop-pane-de">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Local Workshop – Germany</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Germany</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">23 April 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              Hosted by Integrational e.V., local young people learned camera drone safety, flight controls, and visual storytelling methods to observe riverbank habitats and urban green spaces.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Local Workshop Germany -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a4-local-workshops/de"></div>
          </div>
        </div>
      </div>

      <!-- Workshop Tab 3: Romania -->
      <div class="country-tab-pane" id="workshop-pane-ro">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Local Workshop – Romania</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Romania</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">29 April 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              Organized by Asociația Empower Plus, young participants practiced camera drone piloting, video capture, and photo framing to document local environmental realities.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Local Workshop Romania -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a4-local-workshops/ro"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 5: Documentary Series Production & Exhibition Photo Selection -->
  <div class="timeline-milestone" id="act-production" data-category="workshops">
    <div class="timeline-milestone-marker">5</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Documentary Series Production &amp; Exhibition Photo Selection</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Germany, Romania, and Türkiye</span>
                <span style="margin: 0 0.35rem;">•</span>
                <span>👥 Participants: <strong>[number of participants]</strong></span>
              </div>
            </div>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">May–July 2026</span>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
            Young people worked in local production teams to film, edit, and finalize the documentary series and curate high-resolution drone photography for the dissemination conferences and exhibition.
          </p>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Documentary Series Production & Photo Exhibition -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a5-films-exhibition"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 6: Dissemination Conferences (Multi-Country Switcher) -->
  <div class="timeline-milestone" id="act-conferences" data-category="outcomes">
    <div class="timeline-milestone-marker">6</div>
    <div class="timeline-milestone-content card-accent-green country-switcher-container">
      <div class="country-switcher-header">
        <div>
          <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">National Dissemination Conferences</h2>
          <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
            <span>📍 Romania • Türkiye • Germany</span>
            <span style="margin: 0 0.35rem;">•</span>
            <span>📅 17–25 July 2026</span>
          </div>
        </div>
        <div class="country-nav-pills" role="tablist" aria-label="Select conference country">
          <button class="country-nav-btn active" data-country-target="conf-pane-ro" role="tab" aria-selected="true">
            <span>🇷🇴 Romania</span>
            <span class="country-nav-date">17 Jul</span>
          </button>
          <button class="country-nav-btn" data-country-target="conf-pane-tr" role="tab" aria-selected="false">
            <span>🇹🇷 Türkiye</span>
            <span class="country-nav-date">22 Jul</span>
          </button>
          <button class="country-nav-btn" data-country-target="conf-pane-de" role="tab" aria-selected="false">
            <span>🇩🇪 Germany</span>
            <span class="country-nav-date">25 Jul</span>
          </button>
        </div>
      </div>

      <!-- Conference Tab 1: Romania -->
      <div class="country-tab-pane active" id="conf-pane-ro">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Dissemination Conference – Romania</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Romania</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">17 July 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              Asociația Empower Plus hosted the national dissemination event where youth-created documentary films and the Green Horizon photo exhibition were presented to local community members, educators, and stakeholders.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Dissemination Conference Romania -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a7-dissemination-final-meeting/ro"></div>
          </div>
        </div>
      </div>

      <!-- Conference Tab 2: Türkiye -->
      <div class="country-tab-pane" id="conf-pane-tr">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Dissemination Conference – Türkiye</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Türkiye</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">22 July 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              IESA organized the national dissemination conference in Türkiye, showcasing the project results, screening the documentary short films, and exhibiting photographs of local climate challenges to community stakeholders.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Dissemination Conference Türkiye -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a7-dissemination-final-meeting/tr"></div>
          </div>
        </div>
      </div>

      <!-- Conference Tab 3: Germany -->
      <div class="country-tab-pane" id="conf-pane-de">
        <div class="timeline-milestone-grid">
          <div class="milestone-info-col">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
              <div>
                <h3 style="font-size: 1.2rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Dissemination Conference – Germany</h3>
                <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                  <span>📍 Germany</span>
                  <span style="margin: 0 0.35rem;">•</span>
                  <span>👥 Participants: <strong>[number of participants]</strong></span>
                </div>
              </div>
              <div style="text-align: right;">
                <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">25 July 2026</span>
              </div>
            </div>
            <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
              Integrational e.V. presented the final project results, screening the youth documentaries and displaying the photography collection to local youth leaders, educators, and community representatives.
            </p>
          </div>
          <div class="milestone-media-col">
            <!-- Photo Gallery for Dissemination Conference Germany -->
            <div class="activity-photo-gallery" data-activity-folder="assets/activities/a7-dissemination-final-meeting/de"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 7: Final Partner Meeting -->
  <div class="timeline-milestone" id="act-final-meeting" data-category="mobilities">
    <div class="timeline-milestone-marker">7</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">Final Partner Meeting</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Mersin, Türkiye</span>
                <span style="margin: 0 0.35rem;">•</span>
                <span>👥 Participants: <strong>[number of participants]</strong></span>
              </div>
            </div>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">31 July – 1 August 2026</span>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0;">
            Representatives from Integrational e.V., Asociația Empower Plus, and IESA met in Mersin to evaluate all project results, review participant feedback, finalize reporting procedures, and plan future collaboration.
          </p>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Final Partner Meeting -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a7-dissemination-final-meeting/final-meeting"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Milestone 8: VR Exhibition Online Launch -->
  <div class="timeline-milestone" id="act-vr-launch" data-category="outcomes">
    <div class="timeline-milestone-marker">8</div>
    <div class="timeline-milestone-content card-accent-green">
      <div class="timeline-milestone-grid">
        <div class="milestone-info-col">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 0.75rem;">
            <div>
              <h2 style="font-size: 1.35rem; margin: 0 0 0.2rem 0; color: var(--primary); font-family: var(--font-heading);">VR Exhibition Online Launch</h2>
              <div style="font-size: 0.88rem; color: var(--text-light); font-weight: 600;">
                <span>📍 Online (MetaSteps Virtual Gallery)</span>
                <span style="margin: 0 0.35rem;">•</span>
                <span>👥 Participants: <strong>Open to the public worldwide</strong></span>
              </div>
            </div>
            <div style="text-align: right;">
              <span style="font-family: var(--font-heading); font-size: 1.05rem; color: var(--primary); font-weight: 700; display: block; white-space: nowrap;">October 2026</span>
            </div>
          </div>

          <p style="font-size: 0.96rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">
            The digital version of the photo exhibitions presented at the conferences went live online in October 2026. It allows visitors worldwide to take a guided virtual tour of youth drone photography and explore climate change in Germany, Romania, and Türkiye from above.
          </p>
          <div>
            <a href="<?= esc_url(home_url('/exhibition')) ?>" class="btn btn-primary btn-sm" style="text-decoration: none;">
              🕶 Visit the VR Exhibition &rarr;
            </a>
          </div>
        </div>
        <div class="milestone-media-col">
          <!-- Photo Gallery for Website & Digital Platform -->
          <div class="activity-photo-gallery" data-activity-folder="assets/activities/a6-website"></div>
        </div>
      </div>
    </div>
  </div>
</div>
      </div>
    </section>
<?php
get_footer();
