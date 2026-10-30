<?php
/**
 * Template Name: Contact Us
 *
 * GREEN HORIZON — Official WordPress Theme
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="section-hero booklet-bg-pattern">
      <div class="container" style="text-align: center;">
        <span class="section-eyebrow">Get In Touch</span>
        <h1 class="section-title">Contact the Consortium</h1>
        <p class="section-subtitle" style="max-width: 820px; margin: 0 auto;">
          Inquiries regarding project outcomes, educational materials, or collaboration in future European youth initiatives.
        </p>
      </div>
    </section>

    <!-- Contact Form & Info Grid -->
    <section class="section" style="padding-top: 1.5rem;">
      <div class="container">
        <div style="display: grid; grid-template-columns: 1.3fr 0.9fr; gap: 3rem; align-items: start;">
          
          <!-- Contact Form -->
          <div class="card card-accent-green">
            <h2 style="font-size: 1.5rem; margin-bottom: 1.25rem; color: var(--primary);">Send a Message</h2>

            <form id="green-horizon-contact-form" action="api/contact.php" method="POST">
              <div style="display: none;" aria-hidden="true">
                <input type="text" id="website_hp" name="website_hp" tabindex="-1" autocomplete="off">
              </div>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                  <label for="contact-name" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem;">Full Name *</label>
                  <input type="text" id="contact-name" name="name" required placeholder="Your Name" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-family: var(--font-body);">
                </div>

                <div>
                  <label for="contact-email" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem;">Email Address *</label>
                  <input type="email" id="contact-email" name="email" required placeholder="you@example.org" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-family: var(--font-body);">
                </div>
              </div>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                  <label for="contact-country" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem;">Country / Region</label>
                  <select id="contact-country" name="country" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-family: var(--font-body); background: #FFFFFF;">
                    <option value="Germany">Germany 🇩🇪</option>
                    <option value="Türkiye">Türkiye 🇹🇷</option>
                    <option value="Romania">Romania 🇷🇴</option>
                    <option value="Other European Country">Other European Country</option>
                    <option value="International">International</option>
                  </select>
                </div>

                <div>
                  <label for="contact-subject" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem;">Subject *</label>
                  <input type="text" id="contact-subject" name="subject" required placeholder="e.g. Booklet usage / Cooperation" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-family: var(--font-body);">
                </div>
              </div>

              <div style="margin-bottom: 1.25rem;">
                <label for="contact-message" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.4rem;">Message *</label>
                <textarea id="contact-message" name="message" rows="5" required placeholder="Write your message here..." style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); font-family: var(--font-body);"></textarea>
              </div>

              <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.88rem; color: var(--text-muted); cursor: pointer;">
                  <input type="checkbox" required style="margin-top: 0.2rem; accent-color: var(--primary);">
                  <span>I agree that my submitted information is processed for responding to my inquiry in accordance with the <a href="<?= esc_url(home_url('/privacy')) ?>">Privacy Policy</a>.</span>
                </label>
              </div>

              <button type="submit" id="contact-submit-btn" class="btn btn-primary btn-lg" style="width: 100%;">
                Send Message &rarr;
              </button>
            </form>
          </div>

          <!-- Consortium Contact Details -->
          <div>
            <!-- Germany: Coordinator -->
            <div class="card card-accent-leaf" style="margin-bottom: 1.8rem;">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Project Coordinator</span>
              <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--primary);">Integrational e.V.</h3>
              <p style="font-size: 0.8rem; color: var(--text-light); font-weight: 600; margin-bottom: 0.65rem;">
                Coordinator Type: Non-governmental organisation/association/social enterprise
              </p>
              <div style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem;">
                📍 Galileistraße 84, 53177 Bonn, Nordrhein-Westfalen, 🇩🇪 Germany<br>
                <span style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">OID: E10325233</span>
              </div>
              <div style="font-size: 0.9rem; line-height: 1.6; color: var(--text-main);">
                <div><strong>Phone:</strong> <a href="tel:+491784041104">+491784041104</a></div>
                <div><strong>Email:</strong> <a href="mailto:integrationalev@gmail.com">integrationalev@gmail.com</a></div>
              </div>
            </div>

            <!-- Türkiye: Partner Organisation -->
            <div class="card card-accent-leaf" style="margin-bottom: 1.8rem;">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Partner Organisation</span>
              <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--primary);">Yenilikçi Eğitim Bilim ve Sanat Derneği (IESA)</h3>
              <p style="font-size: 0.8rem; color: var(--text-light); font-weight: 600; margin-bottom: 0.65rem;">
                Partner Type: Non-governmental organisation/association/social enterprise
              </p>
              <div style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem;">
                📍 Menteş mahallesi Nevit Kodallı caddesi Öztürk Apartmanı No:96, 33140 Mersin, Mersin, 🇹🇷 Türkiye<br>
                <span style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">OID: E10315828</span>
              </div>
              <div style="font-size: 0.9rem; line-height: 1.6; color: var(--text-main);">
                <div><strong>Website:</strong> <a href="https://innovativeducation.net" target="_blank" rel="noopener noreferrer">https://innovativeducation.net</a></div>
                <div><strong>Phone:</strong> <a href="tel:+905054813591">+905054813591</a></div>
                <div><strong>Email:</strong> <a href="mailto:iesaerasmus@gmail.com">iesaerasmus@gmail.com</a></div>
              </div>
            </div>

            <!-- Romania: Partner Organisation -->
            <div class="card card-accent-leaf" style="margin-bottom: 1.8rem;">
              <span class="badge badge-completed" style="margin-bottom: 0.6rem;">Partner Organisation</span>
              <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--primary);">Asociația Empower Plus</h3>
              <p style="font-size: 0.8rem; color: var(--text-light); font-weight: 600; margin-bottom: 0.65rem;">
                Partner Type: Non-governmental organisation/association/social enterprise
              </p>
              <div style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem;">
                📍 Str. Preciziei, nr. 14, bl. F2, sc. 2, et. 3, ap. 108, 062204 Bucharest, Sector 6, Bucureşti - Ilfov, 🇷🇴 Romania<br>
                <span style="font-size: 0.82rem; color: var(--primary); font-weight: 700;">OID: E10309212</span>
              </div>
              <div style="font-size: 0.9rem; line-height: 1.6; color: var(--text-main);">
                <div><strong>Phone:</strong> <a href="tel:+40773962100">+40773962100</a></div>
                <div><strong>Email:</strong> <a href="mailto:empower.plus.ngo@gmail.com">empower.plus.ngo@gmail.com</a></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
<?php
get_footer();
