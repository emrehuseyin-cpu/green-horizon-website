/**
 * GREEN HORIZON — Automatic Activity Photos Synchronizer
 * Scans activity folders, detects any newly added image files,
 * and automatically registers them in photos.json with multilingual captions.
 */

const fs = require('fs');
const path = require('path');

const activitiesRoot = path.join(__dirname, '../assets/activities');

const activityDefaults = {
  'a1-kickoff': {
    title: 'A1 Kick-Off Meeting',
    credit: 'Integrational e.V.',
    caption_en: 'Kick-off meeting session and consortium planning in Germany',
    caption_de: 'Auftakttreffen und Konsortiumsplanung in Deutschland',
    caption_tr: 'Almanya başlangıç toplantısı ve konsorsiyum planlama oturumu',
    caption_ro: 'Sesiune a întâlnirii de lansare și planificarea consorțiului în Germania'
  },
  'a2-training-course': {
    title: 'A2 Training Course (Brașov)',
    credit: 'Asociația Empower Plus',
    caption_en: 'Transnational youth training course and drone flight practice in Brașov, Romania',
    caption_de: 'Transnationaler Jugendtrainingskurs und Drohnenflugpraxis in Brașov, Rumänien',
    caption_tr: 'Brașov Romanya da uluslararası gençlik eğitim kursu ve drone uçuş uygulaması',
    caption_ro: 'Curs de formare transnațional pentru tineret și practică de zbor cu drona în Brașov, România'
  },
  'a3-booklet': {
    title: 'A3 Educational Booklet',
    credit: 'Yenilikçi Eğitim Bilim ve Sanat Derneği',
    caption_en: 'Development and review of the Green Horizon Educational Booklet',
    caption_de: 'Entwicklung und Überprüfung des Green Horizon Bildungshandbuchs',
    caption_tr: 'Green Horizon Eğitim Kitapçığı geliştirme ve değerlendirme çalışması',
    caption_ro: 'Dezvoltarea și revizuirea manualului educațional Green Horizon'
  },
  'a4-local-workshops/de': {
    title: 'A4 Local Workshops (Germany)',
    credit: 'Integrational e.V.',
    caption_en: 'Local youth workshop and outdoor environmental monitoring in Bonn, Germany',
    caption_de: 'Lokaler Jugendworkshop und Umweltmonitoring in Bonn, Deutschland',
    caption_tr: 'Bonn Almanya da yerel gençlik çalıştayı ve açık alan çevre izleme faaliyeti',
    caption_ro: 'Atelier local de tineret și monitorizare a mediului în Bonn, Germania'
  },
  'a4-local-workshops/ro': {
    title: 'A4 Local Workshops (Romania)',
    credit: 'Asociația Empower Plus',
    caption_en: 'Local youth workshop and mountain forest observation in Brașov, Romania',
    caption_de: 'Lokaler Jugendworkshop und Bergwaldbeobachtung in Brașov, Rumänien',
    caption_tr: 'Brașov Romanya da yerel gençlik çalıştayı ve dağ ormanı gözlem faaliyeti',
    caption_ro: 'Atelier local de tineret și observare a pădurilor montane în Brașov, România'
  },
  'a4-local-workshops/tr': {
    title: 'A4 Local Workshops (Türkiye)',
    credit: 'Yenilikçi Eğitim Bilim ve Sanat Derneği',
    caption_en: 'Local youth workshop and coastal eco-action in Mersin, Türkiye',
    caption_de: 'Lokaler Jugendworkshop und Küsten-Öko-Aktion in Mersin, Türkei',
    caption_tr: 'Mersin Türkiye de yerel gençlik çalıştayı ve kıyı çevre koruma faaliyeti',
    caption_ro: 'Atelier local de tineret și acțiune ecologică costieră în Mersin, Turcia'
  },
  'a5-films-exhibition': {
    title: 'A5 Films & VR Exhibition',
    credit: 'Green Horizon Consortium',
    caption_en: 'Production and curation of climate campaign films and VR exhibition',
    caption_de: 'Produktion und Kuration von Klimakampagnenfilmen und VR-Ausstellung',
    caption_tr: 'İklim kampanyası filmleri ve VR sergisinin prodüksiyon ve küratörlük çalışması',
    caption_ro: 'Producția și curatorierea filmelor campaniei climatice și expoziției VR'
  },
  'a6-website': {
    title: 'A6 Digital Platform',
    credit: 'Green Horizon Consortium',
    caption_en: 'Interactive website, digital storytelling and open-access resources',
    caption_de: 'Interaktive Website, digitales Storytelling und Open-Access-Ressourcen',
    caption_tr: 'Etkileşimli web sitesi, dijital hikaye anlatımı ve açık erişimli kaynaklar',
    caption_ro: 'Platformă web interactivă, povești digitale și resurse cu acces deschis'
  },
  'a7-dissemination-final-meeting/de': {
    title: 'A7 Dissemination (Germany)',
    credit: 'Integrational e.V.',
    caption_en: 'National dissemination conference and stakeholder presentation in Germany',
    caption_de: 'Nationale Verbreitungskonferenz und Stakeholder-Präsentation in Deutschland',
    caption_tr: 'Almanya ulusal yaygınlaştırma konferansı ve paydaş sunumu',
    caption_ro: 'Conferință națională de diseminare și prezentare pentru factorii interesați în Germania'
  },
  'a7-dissemination-final-meeting/ro': {
    title: 'A7 Dissemination (Romania)',
    credit: 'Asociația Empower Plus',
    caption_en: 'National dissemination conference and youth showcase in Romania',
    caption_de: 'Nationale Verbreitungskonferenz und Jugendpräsentation in Rumänien',
    caption_tr: 'Romanya ulusal yaygınlaştırma konferansı ve gençlik sergisi',
    caption_ro: 'Conferință națională de diseminare și prezentare de tineret în România'
  },
  'a7-dissemination-final-meeting/tr': {
    title: 'A7 Dissemination (Türkiye)',
    credit: 'Yenilikçi Eğitim Bilim ve Sanat Derneği',
    caption_en: 'National dissemination conference and public exhibition in Türkiye',
    caption_de: 'Nationale Verbreitungskonferenz und öffentliche Ausstellung in der Türkei',
    caption_tr: 'Türkiye ulusal yaygınlaştırma konferansı ve halka açık sergi faaliyeti',
    caption_ro: 'Conferință națională de diseminare și expoziție publică în Turcia'
  },
  'a7-dissemination-final-meeting/final-meeting': {
    title: 'A7 Final Partner Meeting',
    credit: 'Green Horizon Consortium',
    caption_en: 'Transnational project evaluation, reporting and impact synthesis',
    caption_de: 'Transnationale Projektevaluierung, Berichterstattung und Wirkungssynthese',
    caption_tr: 'Uluslararası proje değerlendirmesi, raporlama ve etki sentezi toplantısı',
    caption_ro: 'Evaluarea transnațională a proiectului, raportarea și sinteza impactului'
  }
};

function formatCaption(filename, baseText) {
  const cleanName = path.parse(filename).name
    .replace(/[-_]+/g, ' ')
    .replace(/\b\w/g, l => l.toUpperCase());
  return `${baseText} — ${cleanName}`;
}

function syncPhotos() {
  console.log('--- SYNCING ACTIVITY PHOTOS TO PHOTOS.JSON ---');
  let totalNew = 0;

  for (const [subPath, meta] of Object.entries(activityDefaults)) {
    const dir = path.join(activitiesRoot, subPath);
    if (!fs.existsSync(dir)) continue;

    const jsonPath = path.join(dir, 'photos.json');
    let items = [];
    if (fs.existsSync(jsonPath)) {
      try {
        items = JSON.parse(fs.readFileSync(jsonPath, 'utf8'));
        if (!Array.isArray(items)) items = [];
      } catch (e) {
        items = [];
      }
    }

    // 1. Prune entries from photos.json if the file was deleted from disk
    const initialCount = items.length;
    items = items.filter(it => it.file && fs.existsSync(path.join(dir, it.file)));
    const prunedCount = initialCount - items.length;
    let modified = prunedCount > 0;

    const existingFiles = new Set(items.map(it => it.file));
    const allFiles = fs.readdirSync(dir);

    const imageExts = new Set(['.jpg', '.jpeg', '.png', '.webp', '.JPG', '.JPEG', '.PNG', '.WEBP']);
    const newImages = allFiles.filter(f => {
      const ext = path.extname(f);
      return imageExts.has(ext) && !f.startsWith('.') && !existingFiles.has(f);
    });

    if (newImages.length > 0) {
      newImages.forEach(img => {
        items.push({
          file: img,
          caption_en: formatCaption(img, meta.caption_en),
          caption_de: formatCaption(img, meta.caption_de),
          caption_tr: formatCaption(img, meta.caption_tr),
          caption_ro: formatCaption(img, meta.caption_ro),
          credit: meta.credit
        });
        totalNew++;
      });
      modified = true;
    }

    if (modified) {
      fs.writeFileSync(jsonPath, JSON.stringify(items, null, 2) + '\n', 'utf8');
      if (prunedCount > 0) {
        console.log(`[Pruned] Removed ${prunedCount} deleted photo(s) from ${meta.title} (${subPath}/photos.json)`);
      }
      if (newImages.length > 0) {
        console.log(`[Synced] Added ${newImages.length} photo(s) to ${meta.title} (${subPath}/photos.json)`);
      }
    }
  }

  console.log(`[Complete] Auto-sync finished. Registered ${totalNew} new photo(s) across activities.`);
}

if (require.main === module) {
  syncPhotos();
}

module.exports = { syncPhotos };
