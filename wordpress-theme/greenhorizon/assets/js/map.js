/**
 * GREEN HORIZON — Interactive Consortium Map Script
 * Powered by Leaflet.js with Light Booklet Aesthetic
 * Coordinator: Integrational e.V. (Bonn, Germany)
 * Partners: IESA (Mersin, Türkiye) & Asociația Empower Plus (Brașov, Romania)
 */

function initConsortiumMap() {
  const mapContainer = document.getElementById('consortium-map');
  if (!mapContainer) return;

  // Check if Leaflet L is loaded
  if (typeof L === 'undefined') {
    mapContainer.innerHTML = `
      <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
        <p>Interactive Map loading... (Consortium: Germany, Türkiye, Romania)</p>
      </div>
    `;
    return;
  }

  // European Center coordinates
  const europeCenter = [46.5, 20.0];
  const map = L.map('consortium-map', {
    center: europeCenter,
    zoom: 4,
    minZoom: 3,
    maxZoom: 9,
    scrollWheelZoom: false,
    zoomControl: true
  });

  // Carto Voyager map tiles with authorized API key
  L.tileLayer('https://basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png?key=cb1_4wb9_1_5f04b77a17cfcdda07ed5f5a', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions" target="_blank" rel="noopener noreferrer">CARTO</a>',
    maxZoom: 19
  }).addTo(map);

  // Consortium Partners Data (Bonn, Mersin, Brașov)
  const partners = [
    {
      id: 'de',
      name: 'Integrational e.V.',
      role: 'Project Coordinator',
      country: 'Germany',
      city: 'Bonn',
      coords: [50.7374, 7.0982],
      desc: 'Project coordinator; VR photo exhibition, local workshops and dissemination.',
      link: 'partners#integrational'
    },
    {
      id: 'ro',
      name: 'Asociația Empower Plus',
      role: 'Project Partner',
      country: 'Romania',
      city: 'Brașov',
      coords: [45.6579, 25.6012], // Brașov training location
      desc: 'Training course host (A2) and documentary series.',
      link: 'partners#empower-plus'
    },
    {
      id: 'tr',
      name: 'Yenilikçi Eğitim Bilim ve Sanat Derneği (IESA)',
      role: 'Project Partner',
      country: 'Türkiye',
      city: 'Mersin',
      coords: [36.8121, 34.6415],
      desc: 'Booklet lead; host of the Mersin dissemination conference and final meeting.',
      link: 'partners#iesa'
    }
  ];

  // Custom Pulsing DivIcon
  const createPulseIcon = () => {
    return L.divIcon({
      className: 'map-pulse-marker',
      html: `
        <div class="marker-pulse"></div>
        <div class="marker-pin"></div>
      `,
      iconSize: [24, 24],
      iconAnchor: [12, 12]
    });
  };

  const markers = [];

  partners.forEach(partner => {
    const marker = L.marker(partner.coords, { icon: createPulseIcon() }).addTo(map);
    
    const popupContent = `
      <div class="map-partner-popup">
        <span class="popup-role">${partner.role}</span>
        <h4>${partner.name}</h4>
        <p style="margin: 0.2rem 0 0.5rem 0; color: #1B5E20; font-weight: 600; font-size: 0.85rem;">
          📍 ${partner.city}, ${partner.country}
        </p>
        <p style="font-size: 0.88rem; color: #4B5563; line-height: 1.45;">${partner.desc}</p>
        <a href="${partner.link}">Explore Partner Profile &rarr;</a>
      </div>
    `;

    marker.bindPopup(popupContent, { maxWidth: 300 });
    markers.push({ partner, marker });
  });

  // Connect Partners with Geodesic Flight Vectors
  const flightPathCoordinates = [
    [50.7374, 7.0982],   // Bonn (Germany)
    [45.6579, 25.6012],  // Brașov (Romania)
    [36.8121, 34.6415],  // Mersin (Türkiye)
    [50.7374, 7.0982]    // Loop back to Germany
  ];

  L.polyline(flightPathCoordinates, {
    color: '#1B5E20',
    weight: 2.5,
    opacity: 0.7,
    dashArray: '6, 8',
    lineCap: 'round'
  }).addTo(map);

  // Enable Interactive Controls from DOM if buttons exist
  window.zoomToPartner = function(code) {
    const item = markers.find(m => m.partner.id === code);
    if (item) {
      map.flyTo(item.partner.coords, 7, { duration: 1.5 });
      item.marker.openPopup();
    }
  };

  window.resetConsortiumMap = function() {
    map.flyTo(europeCenter, 4, { duration: 1.5 });
  };
}

// Auto-run when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  if (typeof L !== 'undefined') {
    initConsortiumMap();
  } else {
    window.addEventListener('load', initConsortiumMap);
  }
});
