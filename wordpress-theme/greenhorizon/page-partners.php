<?php
/**
 * Template Name: Project Partners
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Consortium</span>
        <h1 class="section-title">Project Partners</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          Three youth organisations from Germany, Türkiye, and Romania bringing together expertise in non-formal education, camera drone technology, and community climate action.
        </p>
      </div>
    </section>

    <!-- Partner Detailed Profiles -->
    <section class="section" style="padding-top: 2rem;">
      <div class="container">

        <!-- 1. Integrational e.V. (Germany) -->
        <article id="integrational" class="card card-accent-green" style="margin-bottom: 3rem; scroll-margin-top: 140px;">
          <div style="display: grid; grid-template-columns: 240px 1fr; gap: 2.5rem; align-items: start;">
            <div style="text-align: center;">
              <div style="background: var(--bg-warm); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; border: 1px solid var(--border-color);">
                <img src="<?= esc_url(gh_asset('images/partners/integrational-official.png')) ?>" alt="Integrational e.V." style="max-height: 75px; width: auto; object-fit: contain;">
              </div>
              <span class="badge badge-completed" style="margin-bottom: 0.5rem;">Project Coordinator</span>
              <p style="font-size: 0.88rem; color: var(--primary); font-weight: 700; margin: 0.2rem 0;">OID: E10325233</p>
              <p style="font-size: 0.95rem; color: var(--text-main); font-weight: 600; margin: 0;">Bonn, Germany 🇩🇪</p>
            </div>

            <div>
              <h2 style="font-size: 1.75rem; margin-bottom: 0.8rem; color: var(--primary);">Integrational e.V.</h2>
              <p style="color: var(--text-muted); line-height: 1.65; margin-bottom: 1.2rem;">
                Integrational e.V. is a German non-profit organisation based in Bonn. The organisation focuses on youth empowerment, digital literacy, and social inclusion, with a strong commitment to climate advocacy through accessible digital media and civic participation. As project coordinator, Integrational e.V. oversaw overall governance, quality assurance, financial administration, and web platform maintenance.
              </p>
              
              <h4 style="color: var(--primary); font-size: 1.1rem; margin-bottom: 0.6rem;">Key Responsibilities:</h4>
              <ul style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                <li>Overall project management, day-to-day coordination, and quality control (Activity A1).</li>
                <li>Hosting the Kick-Off Transnational Project Meeting in Bonn, Germany (28–29 July 2025).</li>
                <li>Leading the project website development, maintenance, and open-access hosting (Activity A6).</li>
                <li>Conducting German local workshops with 20 youth participants in Bonn (Activity A4, 23 April 2026).</li>
                <li>Administering financial reporting to the German National Agency (DE04 - JUGEND für Europa).</li>
              </ul>

              <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <a href="<?= esc_url(home_url('/contact')) ?>" class="btn btn-secondary btn-sm" style="text-decoration: none;">Contact Coordinator &rarr;</a>
                <span style="font-size: 0.9rem; color: var(--text-light);"><a href="mailto:integrationalev@gmail.com">integrationalev@gmail.com</a> • <a href="tel:+491784041104">+491784041104</a></span>
              </div>
              <p style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.8rem;">
                📍 Galileistraße 84, 53177 Bonn, Nordrhein-Westfalen, Germany • Type: Non-governmental organisation/association/social enterprise
              </p>
            </div>
          </div>
        </article>

        <!-- 2. IESA (Türkiye) -->
        <article id="iesa" class="card card-accent-leaf" style="margin-bottom: 3rem; scroll-margin-top: 140px;">
          <div style="display: grid; grid-template-columns: 240px 1fr; gap: 2.5rem; align-items: start;">
            <div style="text-align: center;">
              <div style="background: var(--bg-warm); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; border: 1px solid var(--border-color);">
                <img src="<?= esc_url(gh_asset('images/partners/iesa-official.png')) ?>" alt="IESA" style="max-height: 75px; width: auto; object-fit: contain;">
              </div>
              <span class="badge badge-completed" style="margin-bottom: 0.5rem;">Partner (Education Lead)</span>
              <p style="font-size: 0.88rem; color: var(--primary); font-weight: 700; margin: 0.2rem 0;">OID: E10315828</p>
              <p style="font-size: 0.95rem; color: var(--text-main); font-weight: 600; margin: 0;">Mersin, Türkiye 🇹🇷</p>
            </div>

            <div>
              <h2 style="font-size: 1.75rem; margin-bottom: 0.8rem; color: var(--primary);">Yenilikçi Eğitim Bilim ve Sanat Derneği (IESA)</h2>
              <p style="color: var(--text-muted); line-height: 1.65; margin-bottom: 1.2rem;">
                Yenilikçi Eğitim Bilim ve Sanat Derneği (Innovative Education, Science and Art Association) is a non-governmental organisation established in Mersin, Türkiye by educators, artists, and innovators. IESA specializes in STEAM methodologies, citizen science, and grassroots youth advocacy. In Green Horizon, IESA authored the Educational Booklet, led internal evaluation, and hosted the Final Dissemination Conference in Mersin.
              </p>
              
              <h4 style="color: var(--primary); font-size: 1.1rem; margin-bottom: 0.6rem;">Key Responsibilities:</h4>
              <ul style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                <li>Lead author for the <em>Green Horizon Educational Booklet</em> (Activity A3).</li>
                <li>Design of pedagogical curricula, camera drone flight practice drills, and safety guidelines.</li>
                <li>Internal quality evaluator and methodology transfer specialist.</li>
                <li>Conducting Turkish local workshops and aerial documentation with 20 youth in Mersin (Activity A4).</li>
                <li>Hosting the Final Transnational Project Meeting and Dissemination Conference in Türkiye (Activity A7).</li>
              </ul>

              <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <a href="https://innovativeducation.net" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="text-decoration: none;">Visit Partner Website &rarr;</a>
                <span style="font-size: 0.9rem; color: var(--text-light);"><a href="mailto:iesaerasmus@gmail.com">iesaerasmus@gmail.com</a> • <a href="tel:+905054813591">+905054813591</a></span>
              </div>
              <p style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.8rem;">
                📍 Menteş mahallesi Nevit Kodallı caddesi Öztürk Apartmanı No:96, 33140 Mersin, Mersin, Türkiye • Type: Non-governmental organisation/association/social enterprise
              </p>
            </div>
          </div>
        </article>

        <!-- 3. Asociația Empower Plus (Romania) -->
        <article id="empower-plus" class="card card-accent-green" style="margin-bottom: 3rem; scroll-margin-top: 140px;">
          <div style="display: grid; grid-template-columns: 240px 1fr; gap: 2.5rem; align-items: start;">
            <div style="text-align: center;">
              <div style="background: var(--bg-warm); border-radius: var(--radius-md); padding: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; border: 1px solid var(--border-color);">
                <img src="<?= esc_url(gh_asset('images/partners/empower-plus-official.png')) ?>" alt="Asociația Empower Plus" style="max-height: 75px; width: auto; object-fit: contain;">
              </div>
              <span class="badge badge-completed" style="margin-bottom: 0.5rem;">Partner (Training &amp; VR Lead)</span>
              <p style="font-size: 0.88rem; color: var(--primary); font-weight: 700; margin: 0.2rem 0;">OID: E10309212</p>
              <p style="font-size: 0.95rem; color: var(--text-main); font-weight: 600; margin: 0;">Brașov, Romania 🇷🇴</p>
            </div>

            <div>
              <h2 style="font-size: 1.75rem; margin-bottom: 0.8rem; color: var(--primary);">Asociația Empower Plus</h2>
              <p style="color: var(--text-muted); line-height: 1.65; margin-bottom: 1.2rem;">
                Asociația Empower Plus is a Romanian youth organisation based in Brașov, focused on empowering young people through non-formal education, audiovisual creativity, environmental awareness, and digital skills. With practical experience in camera drone instruction and digital arts, Empower Plus delivered the Transnational Training Course in Brașov and curated the virtual exhibition.
              </p>
              
              <h4 style="color: var(--primary); font-size: 1.1rem; margin-bottom: 0.6rem;">Key Responsibilities:</h4>
              <ul style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                <li>Designing and delivering the Transnational Training Course for 18 Youth Workers in Brașov (Activity A2, 11–18 October 2025).</li>
                <li>Curating the virtual exhibition on the MetaSteps platform (Activity A5).</li>
                <li>Technical mentoring for youth video editing and documentary post-production.</li>
                <li>Conducting Romanian local workshops with 20 youth participants (Activity A4).</li>
                <li>Organizing Romanian dissemination events and community screenings.</li>
              </ul>

              <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <a href="<?= esc_url(home_url('/contact')) ?>" class="btn btn-secondary btn-sm" style="text-decoration: none;">Contact Empower Plus &rarr;</a>
                <span style="font-size: 0.9rem; color: var(--text-light);"><a href="mailto:empower.plus.ngo@gmail.com">empower.plus.ngo@gmail.com</a> • <a href="tel:+40773962100">+40773962100</a></span>
              </div>
              <p style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.8rem;">
                📍 Str Preciziei, nr 14, bl.F2, sc. 2, et. 3, ap.108, 062204 Bucharest, Sector 6, Bucureşti - Ilfov, Romania • Type: Non-governmental organisation/association/social enterprise
              </p>
            </div>
          </div>
        </article>

      </div>
    </section>
<?php
get_footer();
