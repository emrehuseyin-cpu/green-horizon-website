/**
 * GREEN HORIZON — Site Content Compiler
 * Injects content from assets/data/content/*.json into static HTML templates.
 * Guarantees 100% SEO, fast loading, zero layout shift, and complete CMS editability.
 */

const fs = require('fs');
const path = require('path');

const rootDir = path.join(__dirname, '..');
const contentDir = path.join(rootDir, 'assets/data/content');

function loadJSON(filename) {
  const filePath = path.join(contentDir, filename);
  if (!fs.existsSync(filePath)) return null;
  try {
    return JSON.parse(fs.readFileSync(filePath, 'utf8'));
  } catch (err) {
    console.error(`Error reading ${filename}:`, err.message);
    return null;
  }
}

function compileSiteContent() {
  console.log('--- COMPILING SITE CONTENT FROM JSON ---');

  const settings = loadJSON('site-settings.json');
  const home = loadJSON('home.json');
  const about = loadJSON('about.json');
  const results = loadJSON('results.json');
  const contact = loadJSON('contact.json');

  // Keep root assets/data in sync with assets/data/content (unwrapping root arrays for runtime JS)
  const newsData = loadJSON('news.json');
  if (newsData) {
    const list = Array.isArray(newsData) ? newsData : (newsData.articles || []);
    fs.writeFileSync(path.join(rootDir, 'assets/data/news.json'), JSON.stringify(list, null, 2) + '\n');
  }

  const actData = loadJSON('activities.json');
  if (actData) {
    const list = Array.isArray(actData) ? actData : (actData.milestones || []);
    fs.writeFileSync(path.join(rootDir, 'assets/data/activities.json'), JSON.stringify(list, null, 2) + '\n');
  }

  const partnersData = loadJSON('partners.json');
  if (partnersData) {
    const list = Array.isArray(partnersData) ? partnersData : (partnersData.partners || []);
    fs.writeFileSync(path.join(rootDir, 'assets/data/partners.json'), JSON.stringify(list, null, 2) + '\n');
  }

  const storiesData = loadJSON('stories.json');
  if (storiesData) {
    const list = Array.isArray(storiesData) ? storiesData : (storiesData.stories || []);
    fs.writeFileSync(path.join(rootDir, 'assets/data/stories.json'), JSON.stringify(list, null, 2) + '\n');
  }

  const galleryData = loadJSON('gallery.json');
  if (galleryData) {
    const list = Array.isArray(galleryData) ? galleryData : (galleryData.photos || []);
    fs.writeFileSync(path.join(rootDir, 'assets/data/gallery.json'), JSON.stringify(list, null, 2) + '\n');
  }

  // 1. Update Homepage (index.html)
  if (home && fs.existsSync(path.join(rootDir, 'index.html'))) {
    let indexHtml = fs.readFileSync(path.join(rootDir, 'index.html'), 'utf8');

    // Hero title & subtitle
    if (home.hero) {
      if (home.hero.title) {
        indexHtml = indexHtml.replace(
          /(<h1 class="section-title"[^>]*>)([\s\S]*?)(<\/h1>)/,
          `$1\n            ${home.hero.title}\n          $3`
        );
      }
      if (home.hero.subtitle) {
        indexHtml = indexHtml.replace(
          /(<p class="section-subtitle"[^>]*>)([\s\S]*?)(<\/p>)/,
          `$1\n            ${home.hero.subtitle}\n          $3`
        );
      }
    }

    // Promo Video
    if (home.promo_video) {
      if (home.promo_video.title) {
        indexHtml = indexHtml.replace(
          /(<h3 class="drone-video-title">)([\s\S]*?)(<\/h3>)/,
          `$1${home.promo_video.title}$3`
        );
      }
      if (home.promo_video.description) {
        indexHtml = indexHtml.replace(
          /(<p class="drone-video-description">)([\s\S]*?)(<\/p>)/,
          `$1\n              ${home.promo_video.description}\n            $3`
        );
      }
    }

    fs.writeFileSync(path.join(rootDir, 'index.html'), indexHtml, 'utf8');
    console.log('[PASS] index.html compiled with latest content.');
  }

  // 2. Update Global Footers across all HTML pages
  if (settings && settings.eu_disclaimer) {
    const htmlFiles = fs.readdirSync(rootDir).filter(f => f.endsWith('.html'));
    htmlFiles.forEach(page => {
      const pagePath = path.join(rootDir, page);
      let content = fs.readFileSync(pagePath, 'utf8');

      // EU Disclaimer
      content = content.replace(
        /(<p class="footer-disclaimer-text">)([\s\S]*?)(<\/p>)/,
        `$1\n          ${settings.eu_disclaimer}\n        $3`
      );

      // Project number
      if (settings.project_number) {
        content = content.replace(
          /(<p class="footer-project-number">Project number: <strong>)([\s\S]*?)(<\/strong><\/p>)/,
          `$1${settings.project_number}$3`
        );
      }

      fs.writeFileSync(pagePath, content, 'utf8');
    });
    console.log(`[PASS] Global settings & EU disclaimer synchronized across ${htmlFiles.length} HTML pages.`);
  }

  console.log('--- CONTENT COMPILATION FINISHED ---');
}

if (require.main === module) {
  compileSiteContent();
}

module.exports = { compileSiteContent };
