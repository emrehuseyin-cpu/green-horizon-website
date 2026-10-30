<?php
/**
 * GREEN HORIZON — Official WordPress Theme Functions
 * Erasmus+ KA210-YOU (Project: 2024-3-DE04-KA210-YOU-000293009)
 */

if (!defined('ABSPATH')) exit;

define('GH_THEME_DIR', get_template_directory());
define('GH_THEME_URI', get_template_directory_uri());

// =============================================================================
// 1. THEME SETUP & ASSETS
// =============================================================================
function greenhorizon_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Navigation Menu', 'greenhorizon'),
        'mobile'  => __('Mobile Navigation Menu', 'greenhorizon'),
        'footer'  => __('Footer Quick Links', 'greenhorizon'),
    ]);
}
add_action('after_setup_theme', 'greenhorizon_setup');

function greenhorizon_enqueue_assets() {
    // Leaflet Map CSS & JS
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

    // Theme Stylesheets
    wp_enqueue_style('greenhorizon-main', GH_THEME_URI . '/assets/css/main.css', [], '20261031');
    wp_enqueue_style('greenhorizon-components', GH_THEME_URI . '/assets/css/components.css', ['greenhorizon-main'], '20261031');
    wp_enqueue_style('greenhorizon-style', get_stylesheet_uri(), ['greenhorizon-components'], '1.0.0');

    // Theme Scripts
    wp_enqueue_script('greenhorizon-main-js', GH_THEME_URI . '/assets/js/main.js', [], '20261031', true);
    wp_enqueue_script('greenhorizon-gallery-js', GH_THEME_URI . '/assets/js/gallery.js', [], '20261031', true);

    if (is_front_page()) {
        wp_enqueue_script('greenhorizon-map-js', GH_THEME_URI . '/assets/js/map.js', ['leaflet-js'], '20261031', true);
    }

    if (is_page('news')) {
        wp_enqueue_script('greenhorizon-news-js', GH_THEME_URI . '/assets/js/news.js', [], '20261031', true);
    }

    // Pass asset root URL to JavaScript
    wp_localize_script('greenhorizon-main-js', 'GreenHorizon', [
        'themeUri' => GH_THEME_URI,
        'assetsUri' => GH_THEME_URI . '/assets',
        'ajaxUrl' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'greenhorizon_enqueue_assets');

// Asset URL Helper
function gh_asset($path) {
    return GH_THEME_URI . '/assets/' . ltrim($path, '/');
}

// Option getter with default fallback
function gh_get_option($key, $default = '') {
    $options = get_option('greenhorizon_options', []);
    return $options[$key] ?? $default;
}

// =============================================================================
// 2. AUTOMATIC INITIALIZATION & PAGE SETUP (Runs on Theme Activation)
// =============================================================================
function greenhorizon_after_switch_theme() {
    // 1. Create default pages with templates
    $pages = [
        'home' => [
            'title' => 'Home',
            'template' => 'front-page.php',
            'is_front' => true
        ],
        'about' => [
            'title' => 'About the Project',
            'template' => 'page-about.php'
        ],
        'partners' => [
            'title' => 'Project Partners',
            'template' => 'page-partners.php'
        ],
        'activities' => [
            'title' => 'Activities & Timeline',
            'template' => 'page-activities.php'
        ],
        'gallery' => [
            'title' => 'Photo Gallery',
            'template' => 'page-gallery.php'
        ],
        'stories' => [
            'title' => 'Climate Stories',
            'template' => 'page-stories.php'
        ],
        'exhibition' => [
            'title' => 'Virtual Exhibition',
            'template' => 'page-exhibition.php'
        ],
        'resources' => [
            'title' => 'Educational Resources',
            'template' => 'page-resources.php'
        ],
        'results' => [
            'title' => 'Project Results',
            'template' => 'page-results.php'
        ],
        'news' => [
            'title' => 'News & Updates',
            'template' => 'page-news.php'
        ],
        'contact' => [
            'title' => 'Contact Us',
            'template' => 'page-contact.php'
        ],
        'privacy' => [
            'title' => 'Privacy Policy',
            'template' => 'page-privacy.php'
        ],
        'accessibility' => [
            'title' => 'Accessibility Statement',
            'template' => 'page-accessibility.php'
        ]
    ];

    $frontPageId = 0;
    foreach ($pages as $slug => $p) {
        $existing = get_page_by_path($slug);
        if (!$existing) {
            $pageId = wp_insert_post([
                'post_type'    => 'page',
                'post_title'   => $p['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_content' => ''
            ]);
            if ($pageId && !empty($p['template'])) {
                update_post_meta($pageId, '_wp_page_template', $p['template']);
            }
            if (!empty($p['is_front'])) {
                $frontPageId = $pageId;
            }
        } else {
            if (!empty($p['template'])) {
                update_post_meta($existing->ID, '_wp_page_template', $p['template']);
            }
            if (!empty($p['is_front'])) {
                $frontPageId = $existing->ID;
            }
        }
    }

    if ($frontPageId) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $frontPageId);
    }

    // 2. Import initial default options from JSON if not set
    if (!get_option('greenhorizon_options')) {
        $homeJson = GH_THEME_DIR . '/assets/data/content/home.json';
        $resultsJson = GH_THEME_DIR . '/assets/data/content/results.json';
        $settingsJson = GH_THEME_DIR . '/assets/data/content/site-settings.json';

        $homeData = file_exists($homeJson) ? json_decode(file_get_contents($homeJson), true) : [];
        $resultsData = file_exists($resultsJson) ? json_decode(file_get_contents($resultsJson), true) : [];
        $settingsData = file_exists($settingsJson) ? json_decode(file_get_contents($settingsJson), true) : [];

        $defaults = [
            // General & EU
            'project_number' => $settingsData['project_number'] ?? '2024-3-DE04-KA210-YOU-000293009',
            'coordinator_name' => $settingsData['coordinator_name'] ?? 'Integrational e.V. (Bonn, Germany)',
            'contact_email' => $settingsData['contact_email'] ?? 'integrational.ev@gmail.com',
            'eu_disclaimer' => $settingsData['eu_disclaimer'] ?? 'Co-funded by the European Union. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or the German National Agency JUGEND für Europa. Neither the European Union nor the granting authority can be held responsible for them.',
            'copyright_text' => $settingsData['copyright_text'] ?? 'Project results are published under the Creative Commons licence CC BY-SA 4.0.',

            // Homepage Hero
            'hero_flags_text' => $homeData['hero']['flags_text'] ?? 'Germany 🇩🇪 • Romania 🇷🇴 • Türkiye 🇹🇷',
            'hero_title' => $homeData['hero']['title'] ?? 'GREEN HORIZON: YOUTH VOICES FOR CLIMATE ACTION THROUGH DRONE TECHNOLOGY',
            'hero_subtitle' => $homeData['hero']['subtitle'] ?? 'An Erasmus+ youth partnership equipping young people and youth workers with practical skills in camera drone piloting, environmental photography, and visual storytelling to document climate challenges and drive community action.',

            // Promo Video
            'promo_eyebrow' => $homeData['promo_video']['eyebrow'] ?? 'Aerial Perspective',
            'promo_heading' => $homeData['promo_video']['heading'] ?? 'Our Project from Above',
            'promo_title' => $homeData['promo_video']['title'] ?? 'Green Horizon: Official Promotional Video',
            'promo_description' => $homeData['promo_video']['description'] ?? 'The official promotional film of Green Horizon captures transnational youth climate advocacy and aerial drone perspectives across Germany, Romania, and Türkiye.',
            'promo_video_url' => GH_THEME_URI . '/assets/video/campaign-1-footage.mp4',
            'promo_poster_url' => GH_THEME_URI . '/assets/video/poster-promo.jpg',

            // Documentary Film 1 (Germany)
            'film_1_country' => 'Germany',
            'film_1_duration' => '31 seconds',
            'film_1_title' => 'Reduce & Reconnect: Aerial Perspectives & Youth Eco-Action in Bonn',
            'film_1_desc' => 'Youth participants in Bonn capture aerial drone views of urban lake ecosystems and parklands, raising smartphone banners to advocate for conscious consumption (“REDUCE”) and Erasmus+ youth-led climate responsibility.',
            'film_1_video_url' => GH_THEME_URI . '/assets/video/campaign-germany.mp4',
            'film_1_poster_url' => GH_THEME_URI . '/assets/video/poster-germany.jpg',

            // Documentary Film 2 (Romania)
            'film_2_country' => 'Romania',
            'film_2_duration' => '54 seconds',
            'film_2_title' => 'Stop Water Contamination: Aerial Guardians of Carpathian Valleys',
            'film_2_desc' => 'Romanian youth teams deploy camera drones above mountain parklands in Brașov, pairing sweeping canopy views with an urgent on-camera call to safeguard freshwater reserves and stop water contamination.',
            'film_2_video_url' => GH_THEME_URI . '/assets/video/campaign-romania.mp4',
            'film_2_poster_url' => GH_THEME_URI . '/assets/video/poster-romania.jpg',

            // Documentary Film 3 (Türkiye)
            'film_3_country' => 'Türkiye',
            'film_3_duration' => '67 seconds',
            'film_3_title' => 'Stop Plastic Waste: Youth Recycling & Circular Action in Mersin',
            'film_3_desc' => 'Young advocates in Mersin take to public spaces with grassroots campaign signs—“RECYCLE” and “STOP PLASTIC WASTE”—highlighting the daily battle against single-use plastics and mobilizing youth for circular waste management.',
            'film_3_video_url' => GH_THEME_URI . '/assets/video/campaign-turkiye.mp4',
            'film_3_poster_url' => GH_THEME_URI . '/assets/video/poster-turkiye.jpg',

            // VR Exhibition (Result 3)
            'vr_title' => 'VR-Enhanced Photo Exhibition: Climate Landscapes from Above',
            'vr_meta' => 'Presented July 2026 • Online since October 2026',
            'vr_description' => 'An interactive 3D virtual reality exhibition space displaying drone photography, environmental field portraits, and behind-the-scenes youth actions across partner regions.',
            'vr_embed_url' => 'https://metasteps.com/viewer/embed/832a0a3b-4ea0-413d-9b47-d9eccd1e1459?showSignIn=0&showCommunications=0&showOrbitButton=0&showSettingsButton=0&showSoundButton=0&showLikeButton=0&forceOrbitCamera=0',

            // Educational Booklet (Result 1)
            'booklet_title' => 'Educational Booklet on Drone Operation, Photography and Climate Change Mitigation',
            'booklet_license' => 'CC BY-SA 4.0',
            'booklet_en' => GH_THEME_URI . '/assets/downloads/green-horizon-booklet-en.pdf',
            'booklet_de' => GH_THEME_URI . '/assets/downloads/green-horizon-booklet-de.pdf',
            'booklet_tr' => GH_THEME_URI . '/assets/downloads/green-horizon-booklet-tr.pdf',
            'booklet_ro' => GH_THEME_URI . '/assets/downloads/green-horizon-booklet-ro.pdf'
        ];

        update_option('greenhorizon_options', $defaults);
    }

    // 3. Import initial News Articles into native WordPress Posts
    $newsJson = GH_THEME_DIR . '/assets/data/content/news.json';
    if (file_exists($newsJson) && count(get_posts(['post_type' => 'post', 'numberposts' => 1])) === 0) {
        $newsData = json_decode(file_get_contents($newsJson), true);
        $articles = $newsData['articles'] ?? (is_array($newsData) ? $newsData : []);
        foreach ($articles as $art) {
            $catId = wp_create_category($art['category'] ?? 'Project News');
            wp_insert_post([
                'post_type'    => 'post',
                'post_title'   => $art['title'] ?? 'News Update',
                'post_content' => $art['full_text'] ?? $art['summary'] ?? '',
                'post_excerpt' => $art['summary'] ?? '',
                'post_status'  => 'publish',
                'post_date'    => !empty($art['date']) ? date('Y-m-d H:i:s', strtotime($art['date'])) : current_time('mysql'),
                'post_category'=> [$catId]
            ]);
        }
    }
}
add_action('after_switch_theme', 'greenhorizon_after_switch_theme');

// =============================================================================
// 3. WORDPRESS ADMIN SETTINGS PANEL ("Green Horizon Settings")
// =============================================================================
function greenhorizon_add_admin_menu() {
    add_menu_page(
        'Green Horizon Settings',
        '🌿 Green Horizon',
        'manage_options',
        'greenhorizon-settings',
        'greenhorizon_settings_page_html',
        'dashicons-palmtree',
        25
    );
}
add_action('admin_menu', 'greenhorizon_add_admin_menu');

function greenhorizon_register_settings() {
    register_setting('greenhorizon_options_group', 'greenhorizon_options', [
        'sanitize_callback' => 'greenhorizon_sanitize_options'
    ]);
}
add_action('admin_init', 'greenhorizon_register_settings');

function greenhorizon_sanitize_options($input) {
    // Sanitizes all options safely
    $sanitized = [];
    foreach ($input as $key => $val) {
        if (strpos($key, 'url') !== false) {
            $sanitized[$key] = esc_url_raw($val);
        } elseif (strpos($key, 'desc') !== false || strpos($key, 'text') !== false || strpos($key, 'disclaimer') !== false) {
            $sanitized[$key] = sanitize_textarea_field($val);
        } else {
            $sanitized[$key] = sanitize_text_field($val);
        }
    }
    return $sanitized;
}

// Admin CSS & Media Uploader Enqueue
function greenhorizon_admin_assets($hook) {
    if ($hook !== 'toplevel_page_greenhorizon-settings') return;
    wp_enqueue_media();
    wp_enqueue_style('gh-admin-css', GH_THEME_URI . '/assets/css/wp-admin.css', [], '1.0.0');
    wp_enqueue_script('gh-admin-js', GH_THEME_URI . '/assets/js/wp-admin.js', ['jquery'], '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'greenhorizon_admin_assets');

// Settings Page HTML Rendering
function greenhorizon_settings_page_html() {
    if (!current_user_can('manage_options')) return;
    $opt = get_option('greenhorizon_options', []);
    ?>
    <div class="wrap gh-admin-wrap">
        <div class="gh-admin-header">
            <img src="<?= esc_url(gh_asset('images/logo-greenhorizon-emblem.png')) ?>" alt="Green Horizon" class="gh-admin-logo">
            <div>
                <h1>Green Horizon — Visual Content Control</h1>
                <p>Erasmus+ KA210-YOU • Edit all website titles, videos, booklet links, and EU notices visually.</p>
            </div>
        </div>

        <?php settings_errors(); ?>

        <form method="post" action="options.php" class="gh-admin-form">
            <?php settings_fields('greenhorizon_options_group'); ?>

            <!-- Navigation Tabs -->
            <div class="gh-tabs-nav">
                <button type="button" class="gh-tab-btn active" data-tab="hero">🏠 Homepage Hero</button>
                <button type="button" class="gh-tab-btn" data-tab="promo">🎥 Promotional Video</button>
                <button type="button" class="gh-tab-btn" data-tab="films">🎬 Campaign Films (Result 2)</button>
                <button type="button" class="gh-tab-btn" data-tab="booklet">📖 Educational Booklet</button>
                <button type="button" class="gh-tab-btn" data-tab="vr">🥽 VR Exhibition</button>
                <button type="button" class="gh-tab-btn" data-tab="general">🏛️ EU Disclaimer &amp; General</button>
            </div>

            <!-- TAB 1: HOMEPAGE HERO -->
            <div class="gh-tab-content active" id="tab-hero">
                <h2>Homepage Hero Section</h2>
                <table class="form-table">
                    <tr>
                        <th>Flags Bar Text</th>
                        <td><input type="text" name="greenhorizon_options[hero_flags_text]" class="large-text" value="<?= esc_attr($opt['hero_flags_text'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Hero Title</th>
                        <td><input type="text" name="greenhorizon_options[hero_title]" class="large-text" value="<?= esc_attr($opt['hero_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Hero Subtitle</th>
                        <td><textarea name="greenhorizon_options[hero_subtitle]" rows="4" class="large-text"><?= esc_textarea($opt['hero_subtitle'] ?? '') ?></textarea></td>
                    </tr>
                </table>
            </div>

            <!-- TAB 2: PROMOTIONAL VIDEO -->
            <div class="gh-tab-content" id="tab-promo">
                <h2>Official Promotional Video</h2>
                <table class="form-table">
                    <tr>
                        <th>Video Title</th>
                        <td><input type="text" name="greenhorizon_options[promo_title]" class="large-text" value="<?= esc_attr($opt['promo_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Video Description</th>
                        <td><textarea name="greenhorizon_options[promo_description]" rows="4" class="large-text"><?= esc_textarea($opt['promo_description'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>MP4 Video File URL</th>
                        <td>
                            <input type="text" name="greenhorizon_options[promo_video_url]" id="gh_promo_video" class="regular-text" value="<?= esc_attr($opt['promo_video_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_promo_video" data-type="video">Select / Upload Video</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Poster Image URL</th>
                        <td>
                            <input type="text" name="greenhorizon_options[promo_poster_url]" id="gh_promo_poster" class="regular-text" value="<?= esc_attr($opt['promo_poster_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_promo_poster" data-type="image">Select / Upload Poster</button>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TAB 3: CAMPAIGN FILMS -->
            <div class="gh-tab-content" id="tab-films">
                <h2>Youth Climate Campaign Documentaries (Result 2)</h2>
                
                <h3>🇩🇪 Film 1: Germany (Bonn Parklands)</h3>
                <table class="form-table">
                    <tr>
                        <th>Title</th>
                        <td><input type="text" name="greenhorizon_options[film_1_title]" class="large-text" value="<?= esc_attr($opt['film_1_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><input type="text" name="greenhorizon_options[film_1_duration]" value="<?= esc_attr($opt['film_1_duration'] ?? '31 seconds') ?>"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea name="greenhorizon_options[film_1_desc]" rows="3" class="large-text"><?= esc_textarea($opt['film_1_desc'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>MP4 Video</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_1_video_url]" id="gh_film_1_v" class="regular-text" value="<?= esc_attr($opt['film_1_video_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_1_v" data-type="video">Upload Video</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Poster Image</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_1_poster_url]" id="gh_film_1_p" class="regular-text" value="<?= esc_attr($opt['film_1_poster_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_1_p" data-type="image">Upload Poster</button>
                        </td>
                    </tr>
                </table>

                <hr>
                <h3>🇷🇴 Film 2: Romania (Carpathian Valleys)</h3>
                <table class="form-table">
                    <tr>
                        <th>Title</th>
                        <td><input type="text" name="greenhorizon_options[film_2_title]" class="large-text" value="<?= esc_attr($opt['film_2_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><input type="text" name="greenhorizon_options[film_2_duration]" value="<?= esc_attr($opt['film_2_duration'] ?? '54 seconds') ?>"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea name="greenhorizon_options[film_2_desc]" rows="3" class="large-text"><?= esc_textarea($opt['film_2_desc'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>MP4 Video</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_2_video_url]" id="gh_film_2_v" class="regular-text" value="<?= esc_attr($opt['film_2_video_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_2_v" data-type="video">Upload Video</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Poster Image</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_2_poster_url]" id="gh_film_2_p" class="regular-text" value="<?= esc_attr($opt['film_2_poster_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_2_p" data-type="image">Upload Poster</button>
                        </td>
                    </tr>
                </table>

                <hr>
                <h3>🇹🇷 Film 3: Türkiye (Mersin)</h3>
                <table class="form-table">
                    <tr>
                        <th>Title</th>
                        <td><input type="text" name="greenhorizon_options[film_3_title]" class="large-text" value="<?= esc_attr($opt['film_3_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td><input type="text" name="greenhorizon_options[film_3_duration]" value="<?= esc_attr($opt['film_3_duration'] ?? '67 seconds') ?>"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea name="greenhorizon_options[film_3_desc]" rows="3" class="large-text"><?= esc_textarea($opt['film_3_desc'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>MP4 Video</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_3_video_url]" id="gh_film_3_v" class="regular-text" value="<?= esc_attr($opt['film_3_video_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_3_v" data-type="video">Upload Video</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Poster Image</th>
                        <td>
                            <input type="text" name="greenhorizon_options[film_3_poster_url]" id="gh_film_3_p" class="regular-text" value="<?= esc_attr($opt['film_3_poster_url'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_film_3_p" data-type="image">Upload Poster</button>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TAB 4: EDUCATIONAL BOOKLET -->
            <div class="gh-tab-content" id="tab-booklet">
                <h2>Educational Booklet Downloads (Result 1)</h2>
                <table class="form-table">
                    <tr>
                        <th>English Edition (PDF)</th>
                        <td>
                            <input type="text" name="greenhorizon_options[booklet_en]" id="gh_b_en" class="regular-text" value="<?= esc_attr($opt['booklet_en'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_b_en" data-type="application/pdf">Upload PDF</button>
                        </td>
                    </tr>
                    <tr>
                        <th>German Edition (PDF)</th>
                        <td>
                            <input type="text" name="greenhorizon_options[booklet_de]" id="gh_b_de" class="regular-text" value="<?= esc_attr($opt['booklet_de'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_b_de" data-type="application/pdf">Upload PDF</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Turkish Edition (PDF)</th>
                        <td>
                            <input type="text" name="greenhorizon_options[booklet_tr]" id="gh_b_tr" class="regular-text" value="<?= esc_attr($opt['booklet_tr'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_b_tr" data-type="application/pdf">Upload PDF</button>
                        </td>
                    </tr>
                    <tr>
                        <th>Romanian Edition (PDF)</th>
                        <td>
                            <input type="text" name="greenhorizon_options[booklet_ro]" id="gh_b_ro" class="regular-text" value="<?= esc_attr($opt['booklet_ro'] ?? '') ?>">
                            <button type="button" class="button gh-media-upload-btn" data-target="#gh_b_ro" data-type="application/pdf">Upload PDF</button>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- TAB 5: VR EXHIBITION -->
            <div class="gh-tab-content" id="tab-vr">
                <h2>Virtual Reality Exhibition (Result 3)</h2>
                <table class="form-table">
                    <tr>
                        <th>Exhibition Title</th>
                        <td><input type="text" name="greenhorizon_options[vr_title]" class="large-text" value="<?= esc_attr($opt['vr_title'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Meta / Date</th>
                        <td><input type="text" name="greenhorizon_options[vr_meta]" class="large-text" value="<?= esc_attr($opt['vr_meta'] ?? '') ?>"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><textarea name="greenhorizon_options[vr_description]" rows="3" class="large-text"><?= esc_textarea($opt['vr_description'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>MetaSteps Embed URL</th>
                        <td><input type="text" name="greenhorizon_options[vr_embed_url]" class="large-text" value="<?= esc_attr($opt['vr_embed_url'] ?? '') ?>"></td>
                    </tr>
                </table>
            </div>

            <!-- TAB 6: GENERAL & EU DISCLAIMER -->
            <div class="gh-tab-content" id="tab-general">
                <h2>Erasmus+ Project Information &amp; Official EU Disclaimer</h2>
                <table class="form-table">
                    <tr>
                        <th>Project Number</th>
                        <td><input type="text" name="greenhorizon_options[project_number]" class="regular-text" value="<?= esc_attr($opt['project_number'] ?? '2024-3-DE04-KA210-YOU-000293009') ?>"></td>
                    </tr>
                    <tr>
                        <th>Coordinator Name</th>
                        <td><input type="text" name="greenhorizon_options[coordinator_name]" class="regular-text" value="<?= esc_attr($opt['coordinator_name'] ?? 'Integrational e.V. (Bonn, Germany)') ?>"></td>
                    </tr>
                    <tr>
                        <th>Contact Email</th>
                        <td><input type="email" name="greenhorizon_options[contact_email]" class="regular-text" value="<?= esc_attr($opt['contact_email'] ?? 'integrational.ev@gmail.com') ?>"></td>
                    </tr>
                    <tr>
                        <th>Official EU Disclaimer</th>
                        <td><textarea name="greenhorizon_options[eu_disclaimer]" rows="5" class="large-text"><?= esc_textarea($opt['eu_disclaimer'] ?? '') ?></textarea></td>
                    </tr>
                    <tr>
                        <th>Copyright Notice</th>
                        <td><input type="text" name="greenhorizon_options[copyright_text]" class="large-text" value="<?= esc_attr($opt['copyright_text'] ?? '') ?>"></td>
                    </tr>
                </table>
            </div>

            <?php submit_button('💾 Save All Green Horizon Settings', 'primary large'); ?>
        </form>
    </div>
    <?php
}
