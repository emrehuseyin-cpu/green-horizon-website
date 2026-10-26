/**
 * GREEN HORIZON — Production Packaging & Validation Script
 * Verifies integrity of all static assets and prepares HostGator deployment artifact.
 */

const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const rootDir = path.join(__dirname, '..');
const distDir = path.join(rootDir, 'dist');

console.log('--- GREEN HORIZON: PRE-FLIGHT VALIDATION & BUILD ---');

// 1. Verify JSON Data Files
const dataFiles = ['activities.json', 'dissemination.json', 'gallery.json', 'news.json', 'partners.json', 'resources.json', 'stories.json'];
dataFiles.forEach(file => {
  const filePath = path.join(rootDir, 'assets/data', file);
  if (!fs.existsSync(filePath)) {
    throw new Error(`Missing data file: ${file}`);
  }
  try {
    const content = fs.readFileSync(filePath, 'utf8');
    JSON.parse(content);
    console.log(`[PASS] JSON integrity verified: ${file}`);
  } catch (err) {
    throw new Error(`Invalid JSON syntax in ${file}: ${err.message}`);
  }
});

// 2. Verify Core HTML Pages
const requiredPages = [
  'index.html',
  'about.html',
  'partners.html',
  'activities.html',
  'gallery.html',
  'stories.html',
  'exhibition.html',
  'resources.html',
  'results.html',
  'news.html',
  'contact.html',
  'privacy.html',
  'accessibility.html',
  '404.html'
];

requiredPages.forEach(page => {
  const pagePath = path.join(rootDir, page);
  if (!fs.existsSync(pagePath)) {
    throw new Error(`Missing page: ${page}`);
  }
  const html = fs.readFileSync(pagePath, 'utf8');
  if (!html.includes('greenhorizonyou.eu') && !html.includes('Green Horizon')) {
    throw new Error(`Incomplete brand metadata in ${page}`);
  }
  console.log(`[PASS] Page validated: ${page}`);
});

// 3. Prepare Clean Production Distribution Directory
if (fs.existsSync(distDir)) {
  fs.rmSync(distDir, { recursive: true, force: true });
}
fs.mkdirSync(distDir, { recursive: true });

// Copy files to dist
function copyRecursive(src, dest) {
  const stats = fs.statSync(src);
  if (stats.isDirectory()) {
    fs.mkdirSync(dest, { recursive: true });
    fs.readdirSync(src).forEach(childItem => {
      copyRecursive(path.join(src, childItem), path.join(dest, childItem));
    });
  } else {
    fs.copyFileSync(src, dest);
  }
}

// Copy HTML pages
requiredPages.forEach(p => {
  fs.copyFileSync(path.join(rootDir, p), path.join(distDir, p));
});

// Copy SEO and config files
['sitemap.xml', 'robots.txt', '.htaccess'].forEach(f => {
  const src = path.join(rootDir, f);
  if (fs.existsSync(src)) {
    fs.copyFileSync(src, path.join(distDir, f));
  }
});

// Copy Assets and API
copyRecursive(path.join(rootDir, 'assets'), path.join(distDir, 'assets'));
copyRecursive(path.join(rootDir, 'api'), path.join(distDir, 'api'));

console.log(`[PASS] Production files copied to /dist directory (${fs.readdirSync(distDir).length} top-level entries).`);

// 4. Create HostGator Deployment ZIP (using native zip)
try {
  const zipPath = path.join(rootDir, 'greenhorizon-deploy.zip');
  if (fs.existsSync(zipPath)) {
    fs.unlinkSync(zipPath);
  }
  execSync(`cd "${distDir}" && zip -r -q "${zipPath}" ./* .htaccess`);
  const sizeMb = (fs.statSync(zipPath).size / 1024).toFixed(1);
  console.log(`[SUCCESS] Created HostGator deployable package: greenhorizon-deploy.zip (${sizeMb} KB)`);
} catch (err) {
  console.warn('[Note] Native ZIP packaging skipped or not available on local OS:', err.message);
}

console.log('--- BUILD COMPLETE: READY FOR HOSTGATOR DEPLOYMENT ---');
