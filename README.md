# Green Horizon — Complete Website Platform

> **Project Title:** Green Horizon: Youth Voices for Climate Action Through Drone Technology  
> **Programme:** Erasmus+ KA210-YOU — Small-scale Partnerships in Youth  
> **Project Period:** 1 May 2025 – 31 August 2026 (16 Months)  
> **Official Domain:** [https://greenhorizonyou.eu](https://greenhorizonyou.eu)  
> **Hosting Provider:** HostGator (cPanel Shared Hosting)  

---

## 1. Project Overview & Consortium

Green Horizon equips young Europeans and youth workers with practical skills in drone technology, aerial photography, video post-production, and digital storytelling to document regional climate change impacts and catalyze grassroots environmental advocacy.

### The Consortium Partnership
1. **Integrational e.V. (Germany)** — *Project Coordinator* (Bonn / Berlin)
   - Oversees general governance, financial monitoring, and coordinates the Transnational Training Course (A2).
2. **Yenilikçi Eğitim Bilim ve Sanat Derneği / IESA (Türkiye)** — *Project Partner* (Mersin / Istanbul)
   - Leads technological and educational module development and authors the *Green Horizon Educational Booklet* (A3).
3. **Asociația Empower Plus (Romania)** — *Project Partner* (Brașov / Bucharest)
   - Leads the *Virtual Reality Climate Exhibition* (A6) and coordinates European dissemination campaigns.

---

## 2. Design System & Tech Aesthetic

The platform is designed with a **futuristic climate-tech aesthetic**, blending an environmental documentary platform with interactive science exhibition and European innovation branding:

- **Deep Abyssal Dark Background:** `#071411`
- **Forest Green Foundation:** `#123C2F`
- **Electric Green Accents:** `#B7FF4A`
- **Teal / Tech Accents:** `#23C9AB`
- **Typography:**
  - Headings: `Space Grotesk`
  - Body: `Inter`
  - HUD / Telemetry / GPS: `JetBrains Mono` / Monospace
- **Drone HUD Overlays:** Target brackets, live simulated GPS/altitude telemetry ribbons, animated scanning radar, crosshairs, and flight mode indicators.
- **Glassmorphism:** Frosted translucent navigation and content cards (`backdrop-filter: blur(14px)`, `rgba(18,60,47,0.32)`).
- **Accessibility:** Tested for WCAG 2.1 Level AA conformance with high-contrast text, keyboard focus outlines (`:focus-visible`), and screen reader landmarks.

---

## 3. Website Structure & Pages

The website consists of 11 fully functional, responsive, and interconnected pages:

| File | Page Name | Description |
|------|-----------|-------------|
| `index.html` | **Home** | Full cinematic hero with drone HUD overlay, project vision, mission pillars, interactive Europe consortium map, activities preview, and latest updates. |
| `about.html` | **About the Project** | Background, specific objectives (SO1–SO4), target groups, non-formal experiential methodology, and European added value. |
| `partners.html` | **Project Partners** | Dedicated profiles for Integrational e.V., IESA, and Empower Plus with roles, GPS coordinates, and contacts. |
| `activities.html` | **Activities & Timeline** | Chronological 16-month Gantt chart roadmap (A1 to A8) with proposal milestones and transparent status badges. |
| `stories.html` | **Climate Stories** | Aerial field dossiers and documentary video showcase (Rhine Basin, Lake Tuz, Carpathian Forest Canopy). |
| `exhibition.html` | **Virtual Exhibition** | Interactive virtual exhibition and panoramic viewer plus photo gallery with full-screen lightbox and drone EXIF telemetry. |
| `resources.html` | **Educational Resources** | Searchable & filterable repository for the Educational Booklet, Drone Safety Manual, and Facilitator Kits. |
| `news.html` | **News & Updates** | Searchable project announcements archive with article modal reader. |
| `contact.html` | **Contact** | Accessible contact form integrated with HostGator PHP mailer (`api/contact.php`) and consortium emails. |
| `privacy.html` | **Privacy Policy** | Comprehensive GDPR compliance details, server logs, data rights, and cookie policy. |
| `accessibility.html`| **Accessibility Statement**| WCAG 2.1 AA conformance details, contrast ratios, keyboard navigation, and feedback channel. |
| `404.html` | **404 Not Found** | Futuristic "Coordinates Lost" error page with return-to-base navigation. |

---

## 4. Easy Content Management & Long-Term Updates

All dynamic website content is separated into clean, human-readable JSON files in `assets/data/`. You can maintain the website for years without touching HTML or CSS.

### Content Data Sources
- **`assets/data/news.json`**: News articles, announcements, and press releases.
- **`assets/data/gallery.json`**: Photographs, drone telemetry (altitude, GPS, shutter, ISO), and virtual exhibition assets.
- **`assets/data/resources.json`**: Educational booklet syllabus, downloadable PDFs, and facilitator toolkits.
- **`assets/data/stories.json`**: Country-specific climate investigations and video cases.
- **`assets/data/activities.json`**: Gantt timeline work packages and status indicators.
- **`assets/data/partners.json`**: Consortium partner information and responsibilities.

### Updating via Antigravity (Prompt Shortcuts)
You can directly command Antigravity:
- *"Add a new news article about our drone training in Germany."*
- *"Publish five new photographs from our workshop in Türkiye with altitude 110m."*
- *"Update the educational booklet download link."*
- *"Add a new documentary video embed from Romania."*
- *"Translate the homepage navigation into German or Turkish."*
- *"Update the partner section with a new contact person."*

### Updating via CLI Utility Scripts
```bash
# Add a new article
npm run add:news "Youth Workshop Held in Bonn" "Workshops" "Integrational e.V." "Summary text..." "Full article content..."

# Add a photograph to the exhibition
npm run add:photo "Canopy Dieback Survey" "Climate Impact" "Germany" "Eifel National Park" "50°34'N 06°25'E" "95m AGL" "Caption describing the aerial observation"
```

---

## 5. Local Development & Preview

The project requires **no database** and **no running Node.js daemon** in production.

### Starting a Local Preview Server
```bash
# Option 1: Using npm (runs Python HTTP server on port 8080)
npm run preview

# Option 2: Using Python directly
python3 -m http.server 8080

# Option 3: Using Node.js npx serve
npx serve .
```
Then open your browser at `http://localhost:8080`.

### Validating & Building for Deployment
```bash
npm run build
```
This runs pre-flight integrity checks across all HTML and JSON files, regenerates production SVG graphics, and outputs:
1. `dist/` — Clean, ready-to-upload static distribution directory.
2. `greenhorizon-deploy.zip` — Ready-to-upload package for HostGator cPanel.

---

## 6. HostGator Deployment & GitHub Setup

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed step-by-step instructions:
- Verifying your document root (`public_html` vs addon domain directory).
- **Method A:** Manual ZIP upload via HostGator cPanel File Manager.
- **Method B:** Automated deployment using Git Version Control / SFTP.
- GitHub private repository (`green-horizon-website`) synchronization workflow.
- PHP contact form configuration.
- Backup and instant rollback instructions.

---

## 7. Erasmus+ Mandatory Visibility & Legal Notice

This platform has been developed in strict compliance with the **Erasmus+ 2021–2027 Visual Identity and Dissemination Guidelines**:
- Official European Union emblem displayed alongside *"Co-funded by the European Union"*.
- Mandatory European Commission disclaimer embedded across every page and document output:
  > *"Funded by the European Union. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or the German National Agency JUGEND für Europa. Neither the European Union nor the granting authority can be held responsible for them."*
- No made-up statistical achievements or fictitious participant counts. All planned items are clearly marked as *"Content pending upload"* or *"Planned in Project Work Plan"*.
