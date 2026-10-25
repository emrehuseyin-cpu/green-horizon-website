/**
 * GREEN HORIZON — Interactive Consortium Map Script
 * Powered by Leaflet.js with Dark-Tech Customization
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

  // Dark-matter high-contrast base map tiles
  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 19
  }).addTo(map);

  // Consortium Partners Data
  const partners = [
    {
      id: 'de',
      name: 'Integrational e.V.',
      role: 'Project Coordinator',
      country: 'Germany',
      city: 'Bonn / Berlin',
      coords: [50.7374, 7.0982],
      desc: 'Oversees overall project governance, financial administration, and the Transnational Drone Operation & Video Editing Training Course.',
      link: 'partners.html#integrational'
    },
    {
      id: 'tr',
      name: 'IESA (Yenilikçi Eğitim Bilim ve Sanat Derneği)',
      role: 'Project Partner',
      country: 'Türkiye',
      city: 'Ankara / Istanbul',
      coords: [39.9334, 32.8597],
      desc: 'Leads technological and educational module development, the Educational Booklet on Drones & Climate Storytelling, and regional youth workshops.',
      link: 'partners.html#iesa'
    },
    {
      id: 'ro',
      name: 'Asociația Empower Plus',
      role: 'Project Partner',
      country: 'Romania',
      city: 'Craiova / Bucharest',
      coords: [44.3302, 23.7949],
      desc: 'Leads the 360° Virtual Reality (VR) Climate Exhibition, youth dissemination campaigns, and regional Carpathian forest monitoring.',
      link: 'partners.html#empower-plus'
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
        <p style="margin: 0.2rem 0 0.5rem 0; color: #23C9AB; font-family: monospace; font-size: 0.8rem;">
          📍 ${partner.city}, ${partner.country}
        </p>
        <p>${partner.desc}</p>
        <a href="${partner.link}">Explore Partner Profile &rarr;</a>
      </div>
    `;

    marker.bindPopup(popupContent, { maxWidth: 300 });
    markers.push({ partner, marker });
  });

  // Connect Partners with Animated Futuristic Geodesic Flight Vectors
  const flightPathCoordinates = [
    [50.7374, 7.0982],   // Germany
    [44.3302, 23.7949],  // Romania
    [39.9334, 32.8597],  // Türkiye
    [50.7374, 7.0982]    // Loop back to Germany
  ];

  L.polyline(flightPathCoordinates, {
    color: '#23C9AB',
    weight: 2,
    opacity: 0.6,
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
  // If Leaflet script is loaded asynchronously, retry if needed
  if (typeof L !== 'undefined') {
    initConsortiumMap();
  } else {
    window.addEventListener('load', initConsortiumMap);
  }
});
