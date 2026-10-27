/**
 * GREEN HORIZON — Automatic Activity Photos Resizing Utility
 * Generates web-optimized versions (max 1600px wide) while keeping original files untouched.
 */

const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const activitiesRoot = path.join(__dirname, '../assets/activities');

function findPhotosJsonFiles(dir) {
  let results = [];
  if (!fs.existsSync(dir)) return results;
  const list = fs.readdirSync(dir);
  list.forEach(file => {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);
    if (stat.isDirectory()) {
      if (file !== 'resized') {
        results = results.concat(findPhotosJsonFiles(fullPath));
      }
    } else if (file === 'photos.json') {
      results.push(fullPath);
    }
  });
  return results;
}

function resizePhotos() {
  console.log('--- Checking Activity Photos for Auto-Resizing (max 1600px) ---');
  
  // Check available tool
  let tool = null;
  try {
    execSync('sips --version', { stdio: 'ignore' });
    tool = 'sips';
  } catch (e) {
    try {
      execSync('convert -version', { stdio: 'ignore' });
      tool = 'convert';
    } catch (e2) {
      tool = null;
    }
  }

  const jsonFiles = findPhotosJsonFiles(activitiesRoot);
  let totalProcessed = 0;

  jsonFiles.forEach(jsonPath => {
    const folder = path.dirname(jsonPath);
    try {
      const content = fs.readFileSync(jsonPath, 'utf8');
      const items = JSON.parse(content);
      if (!Array.isArray(items) || items.length === 0) return;

      const resizedDir = path.join(folder, 'resized');
      if (!fs.existsSync(resizedDir)) {
        fs.mkdirSync(resizedDir, { recursive: true });
      }

      items.forEach(item => {
        if (!item.file) return;
        const srcFile = path.join(folder, item.file);
        const destFile = path.join(resizedDir, item.file);

        if (!fs.existsSync(srcFile)) {
          console.warn(`[Notice] File referenced in photos.json not found: ${srcFile}`);
          return;
        }

        // Only generate if destination doesn't exist or source is newer
        const srcStat = fs.statSync(srcFile);
        let needResize = true;
        if (fs.existsSync(destFile)) {
          const destStat = fs.statSync(destFile);
          if (destStat.mtime >= srcStat.mtime) {
            needResize = false;
          }
        }

        if (needResize && tool === 'sips') {
          try {
            // Resize preserving aspect ratio with max dimension 1600
            fs.copyFileSync(srcFile, destFile);
            execSync(`sips -Z 1600 "${destFile}"`, { stdio: 'ignore' });
            console.log(`[Resized] Max 1600px generated for: ${path.relative(activitiesRoot, srcFile)}`);
            totalProcessed++;
          } catch (err) {
            console.error(`Error resizing ${srcFile}:`, err.message);
          }
        } else if (needResize && tool === 'convert') {
          try {
            execSync(`convert "${srcFile}" -resize "1600x1600>" "${destFile}"`, { stdio: 'ignore' });
            console.log(`[Resized] Max 1600px generated for: ${path.relative(activitiesRoot, srcFile)}`);
            totalProcessed++;
          } catch (err) {
            console.error(`Error resizing ${srcFile}:`, err.message);
          }
        }
      });
    } catch (err) {
      console.warn(`Could not parse ${jsonPath}:`, err.message);
    }
  });

  console.log(`[Complete] Photo check finished. Processed ${totalProcessed} images.`);
}

if (require.main === module) {
  resizePhotos();
}

module.exports = { resizePhotos };
