/**
 * GREEN HORIZON — Add Exhibition Photo Utility
 * Usage: node scripts/add-photo.js "Title" "Category" "Location" "Coords" "Altitude" "Caption"
 */

const fs = require('fs');
const path = require('path');

const galleryPath = path.join(__dirname, '../assets/data/gallery.json');

function addPhoto(title, category, country, location, coords, altitude, caption, is360 = false) {
  if (!title || !location) {
    console.error('Error: Photo title and location are required.');
    process.exit(1);
  }

  const raw = fs.readFileSync(galleryPath, 'utf8');
  const gallery = JSON.parse(raw);

  const id = `gallery-${Date.now().toString().slice(-4)}`;

  const newPhoto = {
    id,
    title,
    category: category || 'Landscapes',
    country: country || 'European Union',
    location,
    coordinates: coords || '50°00\'00"N 10°00\'00"E',
    altitude: altitude || '100m AGL',
    shutter: '1/500s',
    aperture: 'f/2.8',
    iso: '100',
    sensor: '48MP Drone Camera Sensor',
    fov: '84°',
    theme: category || 'Ecological Field Documentation',
    caption: caption || title,
    is360: Boolean(is360),
    status: 'Project Media // Verified Flight Record'
  };

  gallery.push(newPhoto);
  fs.writeFileSync(galleryPath, JSON.stringify(gallery, null, 2), 'utf8');

  console.log(`[Success] Photo added to exhibition: "${title}" (ID: ${id})`);
  console.log(`Total items in exhibition gallery: ${gallery.length}`);
}

const args = process.argv.slice(2);
if (args.length >= 2) {
  addPhoto(args[0], args[1], args[2], args[3], args[4], args[5], args[6], args[7]);
} else {
  module.exports = { addPhoto };
}
