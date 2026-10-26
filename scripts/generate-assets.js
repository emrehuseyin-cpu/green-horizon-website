const fs = require('fs');
const path = require('path');

// 1. Hero Aerial Graphic
const heroSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 900" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="sky-dark" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" stop-color="#040b09" />
      <stop offset="40%" stop-color="#071411" />
      <stop offset="80%" stop-color="#0d2820" />
      <stop offset="100%" stop-color="#123C2F" />
    </linearGradient>
    <linearGradient id="river-glow" x1="0%" y1="0%" x2="100%" y2="50%">
      <stop offset="0%" stop-color="#23C9AB" stop-opacity="0.9" />
      <stop offset="50%" stop-color="#B7FF4A" stop-opacity="0.8" />
      <stop offset="100%" stop-color="#005a46" stop-opacity="0.3" />
    </linearGradient>
    <linearGradient id="hud-teal" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#23C9AB" stop-opacity="0.8"/>
      <stop offset="100%" stop-color="#B7FF4A" stop-opacity="0.9"/>
    </linearGradient>
    <pattern id="topo-grid" width="60" height="60" patternUnits="userSpaceOnUse">
      <path d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(35, 201, 171, 0.08)" stroke-width="1"/>
      <circle cx="60" cy="0" r="1.5" fill="rgba(183, 255, 74, 0.25)"/>
    </pattern>
    <radialGradient id="vignette" cx="50%" cy="50%" r="70%">
      <stop offset="40%" stop-color="transparent" />
      <stop offset="100%" stop-color="#071411" stop-opacity="0.85" />
    </radialGradient>
  </defs>

  <!-- Sky and Terrain background -->
  <rect width="1600" height="900" fill="url(#sky-dark)" />
  <rect width="1600" height="900" fill="url(#topo-grid)" />

  <!-- Abstract Aerial Landscape / Mountain Ridges and Topographic Contours -->
  <g opacity="0.35">
    <path d="M-100,550 Q250,420 600,520 T1300,480 Q1500,420 1700,500 L1700,900 L-100,900 Z" fill="#0d2b22" />
    <path d="M-100,620 Q300,500 750,600 T1450,560 Q1580,520 1700,610 L1700,900 L-100,900 Z" fill="#123C2F" />
    <path d="M-100,700 Q400,620 900,680 T1500,640 Q1620,620 1700,700 L1700,900 L-100,900 Z" fill="#184b3b" />
  </g>

  <!-- Meandering River / Wetland Vector -->
  <path d="M 1650,450 C 1300,480 1100,600 850,580 S 550,750 300,720 S 50,850 -50,880" fill="none" stroke="url(#river-glow)" stroke-width="18" stroke-linecap="round" opacity="0.75" filter="drop-shadow(0 0 16px rgba(35,201,171,0.5))"/>
  <path d="M 1650,450 C 1300,480 1100,600 850,580 S 550,750 300,720 S 50,850 -50,880" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" opacity="0.8"/>

  <!-- Topographic Contour Lines -->
  <g fill="none" stroke="rgba(35, 201, 171, 0.2)" stroke-width="1.2">
    <path d="M 100,400 Q 400,320 800,430 T 1500,360" stroke-dasharray="4 4"/>
    <path d="M 80,480 Q 450,390 850,500 T 1550,440" />
    <path d="M 50,560 Q 500,470 900,580 T 1600,510" stroke-dasharray="8 6"/>
    <path d="M 0,640 Q 550,550 950,650 T 1650,590" />
    <path d="M -50,720 Q 600,630 1000,730 T 1700,670" stroke-dasharray="2 4"/>
  </g>

  <!-- Flight Path Vectors -->
  <path d="M 200,280 L 520,310 L 880,240 L 1260,350 L 1480,290" fill="none" stroke="#B7FF4A" stroke-width="2" stroke-dasharray="6 6" opacity="0.7"/>
  
  <!-- Waypoints -->
  <g fill="#B7FF4A">
    <circle cx="200" cy="280" r="4"/>
    <circle cx="520" cy="310" r="4"/>
    <circle cx="880" cy="240" r="4"/>
    <circle cx="1260" cy="350" r="4"/>
    <circle cx="1480" cy="290" r="4"/>
  </g>
  <text x="210" y="275" fill="#B7FF4A" font-family="monospace" font-size="11">WP-01 [RHINE]</text>
  <text x="530" y="305" fill="#B7FF4A" font-family="monospace" font-size="11">WP-02 [BONN]</text>
  <text x="890" y="235" fill="#B7FF4A" font-family="monospace" font-size="11">WP-03 [CARPATHIAN]</text>
  <text x="1270" y="345" fill="#B7FF4A" font-family="monospace" font-size="11">WP-04 [TUZ GÖLÜ]</text>

  <!-- Drone HUD Center Reticle -->
  <g transform="translate(800, 450)">
    <!-- Primary Circular Reticle -->
    <circle cx="0" cy="0" r="140" fill="none" stroke="rgba(35, 201, 171, 0.4)" stroke-width="1.5" stroke-dasharray="12 8"/>
    <circle cx="0" cy="0" r="90" fill="none" stroke="rgba(183, 255, 74, 0.3)" stroke-width="1"/>
    <circle cx="0" cy="0" r="30" fill="none" stroke="#B7FF4A" stroke-width="1.5"/>
    <circle cx="0" cy="0" r="3" fill="#B7FF4A"/>

    <!-- Crosshairs with gaps -->
    <line x1="-160" y1="0" x2="-45" y2="0" stroke="#23C9AB" stroke-width="1.5"/>
    <line x1="45" y1="0" x2="160" y2="0" stroke="#23C9AB" stroke-width="1.5"/>
    <line x1="0" y1="-160" x2="0" y2="-45" stroke="#23C9AB" stroke-width="1.5"/>
    <line x1="0" y1="45" x2="0" y2="160" stroke="#23C9AB" stroke-width="1.5"/>

    <!-- Corner target brackets -->
    <path d="M-60,-40 L-70,-40 L-70,-50" fill="none" stroke="#B7FF4A" stroke-width="2"/>
    <path d="M60,-40 L70,-40 L70,-50" fill="none" stroke="#B7FF4A" stroke-width="2"/>
    <path d="M-60,40 L-70,40 L-70,50" fill="none" stroke="#B7FF4A" stroke-width="2"/>
    <path d="M60,40 L70,40 L70,50" fill="none" stroke="#B7FF4A" stroke-width="2"/>

    <!-- Pitch ladder marks -->
    <line x1="-25" y1="-20" x2="25" y2="-20" stroke="rgba(35, 201, 171, 0.6)" stroke-width="1"/>
    <line x1="-15" y1="-10" x2="15" y2="-10" stroke="rgba(35, 201, 171, 0.4)" stroke-width="1"/>
    <line x1="-15" y1="10" x2="15" y2="10" stroke="rgba(35, 201, 171, 0.4)" stroke-width="1"/>
    <line x1="-25" y1="20" x2="25" y2="20" stroke="rgba(35, 201, 171, 0.6)" stroke-width="1"/>

    <text x="75" y="-12" fill="#B7FF4A" font-family="monospace" font-size="11" font-weight="bold">+03.4° PITCH</text>
    <text x="-140" y="-12" fill="#23C9AB" font-family="monospace" font-size="11">ALT: 124m</text>
  </g>

  <!-- Vignette overlay for filmic depth -->
  <rect width="1600" height="900" fill="url(#vignette)" pointer-events="none"/>
</svg>`;

fs.writeFileSync(path.join(__dirname, '../assets/images/hero/aerial-landscape.svg'), heroSvg);

// 2. Generate Gallery & Exhibition Images
function generateExhibitSvg(title, location, coords, alt, themeColor, details) {
  return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="bg-grad-${alt}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#05100d" />
      <stop offset="50%" stop-color="#0c251d" />
      <stop offset="100%" stop-color="#123C2F" />
    </linearGradient>
    <pattern id="grid-${alt}" width="40" height="40" patternUnits="userSpaceOnUse">
      <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(35, 201, 171, 0.08)" stroke-width="0.8"/>
    </pattern>
  </defs>

  <rect width="800" height="500" fill="url(#bg-grad-${alt})" />
  <rect width="800" height="500" fill="url(#grid-${alt})" />

  <!-- Terrain Flow Contours -->
  <path d="M0,320 Q200,220 400,300 T800,260 L800,500 L0,500 Z" fill="#0d2e23" opacity="0.6"/>
  <path d="M0,380 Q250,300 500,370 T800,340 L800,500 L0,500 Z" fill="#154536" opacity="0.7"/>
  <path d="M0,430 Q300,390 600,430 T800,410 L800,500 L0,500 Z" fill="#1b5946" opacity="0.8"/>

  <!-- Topographic Curvature Lines -->
  <g fill="none" stroke="${themeColor}" stroke-width="1.2" opacity="0.35">
    <path d="M 40,240 Q 240,160 480,250 T 800,190" stroke-dasharray="4 4"/>
    <path d="M 20,290 Q 280,210 520,300 T 800,240" />
    <path d="M 0,350 Q 320,270 560,360 T 800,300" stroke-dasharray="6 3"/>
  </g>

  <!-- Drone Focus Box -->
  <rect x="250" y="140" width="300" height="180" fill="none" stroke="${themeColor}" stroke-width="1" stroke-dasharray="8 6" opacity="0.4"/>
  <g stroke="${themeColor}" stroke-width="2">
    <path d="M 245,150 L 245,135 L 260,135" fill="none"/>
    <path d="M 555,150 L 555,135 L 540,135" fill="none"/>
    <path d="M 245,310 L 245,325 L 260,325" fill="none"/>
    <path d="M 555,310 L 555,325 L 540,325" fill="none"/>
  </g>
  <circle cx="400" cy="230" r="18" fill="none" stroke="${themeColor}" stroke-width="1.5"/>
  <circle cx="400" cy="230" r="3" fill="${themeColor}"/>

  <!-- Telemetry Overlay Ribbon -->
  <rect x="20" y="20" width="760" height="42" rx="6" fill="rgba(7, 20, 17, 0.85)" stroke="rgba(35, 201, 171, 0.25)" stroke-width="1"/>
  <text x="35" y="45" fill="#B7FF4A" font-family="'Space Grotesk', monospace" font-size="12" font-weight="700">● LIVE FLIGHT TELEMETRY</text>
  <text x="240" y="45" fill="#E2E8F0" font-family="monospace" font-size="11">ALT: ${alt}</text>
  <text x="360" y="45" fill="#E2E8F0" font-family="monospace" font-size="11">GPS: ${coords}</text>
  <text x="590" y="45" fill="#23C9AB" font-family="monospace" font-size="11">SENS: ${details}</text>

  <!-- Bottom Label Badge -->
  <rect x="20" y="420" width="760" height="60" rx="6" fill="rgba(7, 20, 17, 0.9)" stroke="rgba(35, 201, 171, 0.3)" stroke-width="1"/>
  <text x="35" y="446" fill="#FFFFFF" font-family="'Space Grotesk', sans-serif" font-size="15" font-weight="700">${title}</text>
  <text x="35" y="466" fill="#94A3B8" font-family="'Inter', sans-serif" font-size="11">${location} // Project Media Placeholder</text>
  <rect x="660" y="434" width="105" height="28" rx="4" fill="rgba(183,255,74,0.15)" stroke="#B7FF4A" stroke-width="1"/>
  <text x="672" y="452" fill="#B7FF4A" font-family="monospace" font-size="10" font-weight="bold">UAV CAPTURE</text>
</svg>`;
}

const exhibits = [
  { id: 'gallery-01', title: 'Rhine Valley Meander at Twilight', loc: 'Middle Rhine Gorge, Germany', coords: '50°12\'44"N 07°43\'21"E', alt: '118m AGL', color: '#23C9AB', sens: '48MP 1/1.3" CMOS' },
  { id: 'gallery-02', title: 'Salt Crust Textures of Lake Tuz', loc: 'Lake Tuz Basin, Türkiye', coords: '38°48\'09"N 33°19\'54"E', alt: '145m AGL', color: '#B7FF4A', sens: '20MP Hasselblad' },
  { id: 'gallery-03', title: 'Carpathian Ridge Ancient Beech Canopy', loc: 'Făgăraș Mountains, Romania', coords: '45°38\'22"N 24°41\'05"E', alt: '96m AGL', color: '#23C9AB', sens: '48MP Quad-Bayer' },
  { id: 'gallery-04', title: 'Flight Calibration & Sensor Orientation', loc: 'Bonn Field Lab, Germany', coords: '50°44\'10"N 07°05\'58"E', alt: '15m AGL', color: '#B7FF4A', sens: '120° FOV Ultra-Wide' },
  { id: 'gallery-05', title: 'Anatolian Agricultural Irrigation Interfaces', loc: 'Konya Steppe, Türkiye', coords: '37°52\'11"N 32°29\'01"E', alt: '130m AGL', color: '#23C9AB', sens: '48MP Telephoto' },
  { id: 'gallery-06', title: 'Transnational Youth Media Lab in Session', loc: 'Brașov Youth Hub, Romania', coords: '44°19\'40"N 23°47\'30"E', alt: 'Ground Lab', color: '#B7FF4A', sens: '35mm Cine Sensor' }
];

exhibits.forEach(ex => {
  const svg = generateExhibitSvg(ex.title, ex.loc, ex.coords, ex.alt, ex.color, ex.sens);
  fs.writeFileSync(path.join(__dirname, `../assets/images/exhibition/${ex.id}.svg`), svg);
});

// 3. 360 Degree Equirectangular Panorama Demo Asset
const vrSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 800" width="1600" height="800">
  <defs>
    <linearGradient id="vr-sky" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" stop-color="#020806"/>
      <stop offset="35%" stop-color="#071b14"/>
      <stop offset="55%" stop-color="#123C2F"/>
      <stop offset="85%" stop-color="#0a1f18"/>
      <stop offset="100%" stop-color="#040d0a"/>
    </linearGradient>
    <pattern id="vr-grid" width="80" height="80" patternUnits="userSpaceOnUse">
      <path d="M 80 0 L 0 0 0 80" fill="none" stroke="rgba(35, 201, 171, 0.09)" stroke-width="1"/>
    </pattern>
  </defs>

  <rect width="1600" height="800" fill="url(#vr-sky)"/>
  <rect width="1600" height="800" fill="url(#vr-grid)"/>

  <!-- 360 Panoramic Curved Landscape Horizon -->
  <path d="M 0,440 Q 200,380 400,430 T 800,420 T 1200,450 T 1600,440 L 1600,800 L 0,800 Z" fill="#0d2b21"/>
  <path d="M 0,510 Q 300,460 600,500 T 1200,480 T 1600,510 L 1600,800 L 0,800 Z" fill="#123C2F"/>
  <path d="M 0,590 Q 250,550 500,580 T 1000,570 T 1600,590 L 1600,800 L 0,800 Z" fill="#174839"/>

  <!-- Compass degree ticks along 360 axis -->
  <g fill="none" stroke="#23C9AB" stroke-width="1.5" opacity="0.6">
    <line x1="0" y1="400" x2="1600" y2="400"/>
    <line x1="200" y1="390" x2="200" y2="410"/>
    <line x1="400" y1="385" x2="400" y2="415"/>
    <line x1="600" y1="390" x2="600" y2="410"/>
    <line x1="800" y1="385" x2="800" y2="415"/>
    <line x1="1000" y1="390" x2="1000" y2="410"/>
    <line x1="1200" y1="385" x2="1200" y2="415"/>
    <line x1="1400" y1="390" x2="1400" y2="410"/>
  </g>
  <g fill="#B7FF4A" font-family="monospace" font-size="14" text-anchor="middle">
    <text x="0" y="375">0° [N]</text>
    <text x="400" y="375">90° [E]</text>
    <text x="800" y="375">180° [S]</text>
    <text x="1200" y="375">270° [W]</text>
    <text x="1600" y="375">360° [N]</text>
  </g>

  <!-- Visual Hotspots -->
  <g transform="translate(420, 320)">
    <circle cx="0" cy="0" r="24" fill="rgba(183, 255, 74, 0.2)" stroke="#B7FF4A" stroke-width="2"/>
    <circle cx="0" cy="0" r="6" fill="#B7FF4A"/>
    <text x="35" y="5" fill="#FFFFFF" font-family="'Space Grotesk', sans-serif" font-size="13" font-weight="700">HOTSPOT 01: Forest Canopy Health</text>
  </g>

  <g transform="translate(1080, 280)">
    <circle cx="0" cy="0" r="24" fill="rgba(35, 201, 171, 0.2)" stroke="#23C9AB" stroke-width="2"/>
    <circle cx="0" cy="0" r="6" fill="#23C9AB"/>
    <text x="35" y="5" fill="#FFFFFF" font-family="'Space Grotesk', sans-serif" font-size="13" font-weight="700">HOTSPOT 02: Alluvial Riverbed Dynamics</text>
  </g>

  <!-- Telemetry banner -->
  <rect x="500" y="700" width="600" height="60" rx="8" fill="rgba(7, 20, 17, 0.9)" stroke="#23C9AB" stroke-width="1.5"/>
  <text x="800" y="725" fill="#B7FF4A" font-family="'Space Grotesk', monospace" font-size="14" font-weight="700" text-anchor="middle">360° IMMERSIVE AERIAL VR SPHERE</text>
  <text x="800" y="746" fill="#E2E8F0" font-family="monospace" font-size="11" text-anchor="middle">GREEN HORIZON CARPATHIAN BIOME // DRAG TO ROTATE</text>
</svg>`;

fs.writeFileSync(path.join(__dirname, '../assets/images/exhibition/vr-panorama-equirectangular.svg'), vrSvg);

// 4. Educational Booklet Cover SVG
const bookletSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 850" width="600" height="850">
  <defs>
    <linearGradient id="book-bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#040b09"/>
      <stop offset="40%" stop-color="#0c251d"/>
      <stop offset="85%" stop-color="#123C2F"/>
      <stop offset="100%" stop-color="#061611"/>
    </linearGradient>
  </defs>

  <rect width="600" height="850" rx="8" fill="url(#book-bg)" stroke="rgba(35, 201, 171, 0.4)" stroke-width="2"/>

  <!-- Decorative Top Banner -->
  <rect x="40" y="40" width="520" height="36" fill="rgba(18, 60, 47, 0.6)" rx="4" stroke="rgba(183, 255, 74, 0.3)"/>
  <text x="60" y="63" fill="#B7FF4A" font-family="monospace" font-size="12" font-weight="bold">ERASMUS+ KA210-YOU // SMALL-SCALE PARTNERSHIP</text>

  <!-- Drone Emblem on Cover -->
  <g transform="translate(300, 260)">
    <circle cx="0" cy="0" r="110" fill="none" stroke="rgba(35, 201, 171, 0.3)" stroke-width="2" stroke-dasharray="8 6"/>
    <circle cx="0" cy="0" r="80" fill="rgba(18, 60, 47, 0.5)" stroke="#B7FF4A" stroke-width="2"/>
    <circle cx="0" cy="0" r="12" fill="#B7FF4A"/>
    
    <!-- Rotors -->
    <circle cx="-50" cy="-50" r="18" fill="none" stroke="#23C9AB" stroke-width="2"/>
    <circle cx="50" cy="-50" r="18" fill="none" stroke="#23C9AB" stroke-width="2"/>
    <circle cx="-50" cy="50" r="18" fill="none" stroke="#23C9AB" stroke-width="2"/>
    <circle cx="50" cy="50" r="18" fill="none" stroke="#23C9AB" stroke-width="2"/>

    <line x1="-70" y1="0" x2="70" y2="0" stroke="#B7FF4A" stroke-width="1.5"/>
    <line x1="0" y1="-70" x2="0" y2="70" stroke="#B7FF4A" stroke-width="1.5"/>
  </g>

  <!-- Main Title -->
  <text x="50" y="460" fill="#FFFFFF" font-family="'Space Grotesk', sans-serif" font-size="34" font-weight="800">GREEN HORIZON</text>
  <text x="50" y="500" fill="#B7FF4A" font-family="'Space Grotesk', sans-serif" font-size="22" font-weight="700">EDUCATIONAL BOOKLET</text>
  <text x="50" y="535" fill="#23C9AB" font-family="'Inter', sans-serif" font-size="15" font-weight="600">Youth Voices for Climate Action Through Drone Technology</text>

  <!-- Description text -->
  <text x="50" y="585" fill="#94A3B8" font-family="'Inter', sans-serif" font-size="13">A Comprehensive Practical Guide for Youth Workers, Educators &amp; Young Leaders:</text>
  <text x="50" y="610" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 01: European Climate Challenges &amp; Youth Perspectives</text>
  <text x="50" y="632" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 02: Fundamentals of UAV Technology &amp; Flight Operations</text>
  <text x="50" y="654" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 03: EASA Open Category Regulations &amp; Safety Protocols</text>
  <text x="50" y="676" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 04: Aerial Photography &amp; Cinematic Storytelling</text>
  <text x="50" y="698" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 05: Environmental Data Gathering &amp; Ethical Media</text>
  <text x="50" y="720" fill="#E2E8F0" font-family="'Inter', sans-serif" font-size="12">• Module 06: Non-Formal Workshop Blueprints &amp; Assessment</text>

  <!-- Bottom partner indicators -->
  <line x1="40" y1="760" x2="560" y2="760" stroke="rgba(35, 201, 171, 0.3)" stroke-width="1"/>
  <text x="50" y="785" fill="#94A3B8" font-family="'Space Grotesk', monospace" font-size="11">CONSORTIUM: Integrational e.V. (DE) | IESA (TR) | Empower Plus (RO)</text>
  <text x="50" y="805" fill="#1B5E20" font-family="sans-serif" font-size="10" font-weight="bold">CO-FUNDED BY THE EUROPEAN UNION</text>
</svg>`;

fs.writeFileSync(path.join(__dirname, '../assets/images/resources/booklet-cover.svg'), bookletSvg);

console.log("All graphic assets successfully generated.");
