# How to Add Photos to Activities

You can add photos to any activity gallery without touching any HTML or CSS code.

---

## 3 Simple Steps

### Step 1: Copy your photo into the activity folder
Place your image file (e.g. `opening-session.jpg`) into the appropriate folder under `/assets/activities/`:

- **A1 Kick-off Meeting:** `/assets/activities/a1-kickoff/`
- **A2 Training Course (Brașov):** `/assets/activities/a2-training-course/`
- **A3 Educational Booklet:** `/assets/activities/a3-booklet/`
- **A4 Local Workshops:**
  - Germany: `/assets/activities/a4-local-workshops/de/`
  - Romania: `/assets/activities/a4-local-workshops/ro/`
  - Türkiye: `/assets/activities/a4-local-workshops/tr/`
- **A5 Films & Photo Exhibition:** `/assets/activities/a5-films-exhibition/`
- **A6 Website & Digital Platform:** `/assets/activities/a6-website/`
- **A7 Dissemination Conferences & Final Meeting:**
  - Germany Conference: `/assets/activities/a7-dissemination-final-meeting/de/`
  - Romania Conference: `/assets/activities/a7-dissemination-final-meeting/ro/`
  - Türkiye Conference: `/assets/activities/a7-dissemination-final-meeting/tr/`
  - Final Partner Meeting: `/assets/activities/a7-dissemination-final-meeting/final-meeting/`

Your original high-resolution photo will be kept untouched.

---

### Step 2: Open `photos.json` in that folder
In the same folder where you copied the photo, open `photos.json` with any text editor (VS Code, TextEdit, Notepad).

---

### Step 3: Add your photo entry and save
Add an entry with your filename and captions:

```json
[
  {
    "file": "opening-session.jpg",
    "caption_en": "Consortium partners during the opening session in Germany",
    "caption_de": "Projektpartner während der Eröffnungssitzung in Deutschland",
    "caption_tr": "Almanya açılış oturumunda proje ortakları",
    "caption_ro": "Partenerii de proiect în timpul sesiunii de deschidere în Germania",
    "credit": "Integrational e.V."
  }
]
```

To add multiple photos, separate each entry with a comma:

```json
[
  {
    "file": "photo1.jpg",
    "caption_en": "Arrival and welcome of participants",
    "caption_de": "Ankunft und Begrüßung der Teilnehmenden",
    "caption_tr": "Katılımcıların varışı ve karşılanması",
    "caption_ro": "Sosirea și întâmpinarea participanților",
    "credit": "Asociația Empower Plus"
  },
  {
    "file": "photo2.jpg",
    "caption_en": "Outdoor flight safety briefing",
    "caption_de": "Sicherheitsunterweisung im Freien",
    "caption_tr": "Açık hava uçuş güvenliği brifingi",
    "caption_ro": "Instructajul de siguranță a zborului în aer liber",
    "credit": "IESA"
  }
]
```

Save the file. **Done!**

---

## How It Works on the Website

1. **Automatic Gallery Display:** Photos appear in the exact order listed in `photos.json`.
2. **Hidden When Empty:** If `photos.json` is empty (`[]`), the gallery section stays completely hidden (no placeholders).
3. **Responsive Grid:** Displays 3 columns on desktop, 2 on tablet, and 1 on phone.
4. **Interactive Lightbox:** Clicking any photo opens a full-screen preview with caption, credits, previous/next arrows, and keyboard support (`Esc`, `←`, `→`).
5. **Multilingual Support:** The caption automatically matches the selected website language (`EN`, `DE`, `TR`, `RO`).
