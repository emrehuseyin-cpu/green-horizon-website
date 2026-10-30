/**
 * GREEN HORIZON — Internationalization (i18n) Architecture
 * Multi-Language Framework: English (Default), German, Turkish, Romanian
 */

const i18nTranslations = {
  en: {
    nav_home: 'Home',
    nav_about: 'About',
    nav_partners: 'Partners',
    nav_activities: 'Activities',
    nav_stories: 'Climate Stories',
    nav_exhibition: 'Virtual Exhibition',
    nav_resources: 'Resources',
    nav_news: 'News',
    nav_contact: 'Contact',
    hero_headline: 'See Climate Change From a New Perspective.',
    hero_subtitle: 'Empowering Youth Voices Through Drone Technology, Digital Storytelling and Climate Action.',
    btn_explore: 'Explore Our Mission',
    btn_discover: 'Discover Climate Stories'
  },
  de: {
    nav_home: 'Startseite',
    nav_about: 'Über das Projekt',
    nav_partners: 'Partner',
    nav_activities: 'Aktivitäten',
    nav_stories: 'Klimageschichten',
    nav_exhibition: 'Virtuelle Ausstellung',
    nav_resources: 'Ressourcen',
    nav_news: 'Aktuelles',
    nav_contact: 'Kontakt',
    hero_headline: 'Klimawandel aus einer neuen Perspektive sehen.',
    hero_subtitle: 'Stärkung von Jugendstimmen durch Drohnentechnologie, digitales Storytelling und Klimaschutz.',
    btn_explore: 'Unsere Mission entdecken',
    btn_discover: 'Klimageschichten entdecken'
  },
  tr: {
    nav_home: 'Ana Sayfa',
    nav_about: 'Hakkında',
    nav_partners: 'Ortaklar',
    nav_activities: 'Faaliyetler',
    nav_stories: 'İklim Hikayeleri',
    nav_exhibition: 'Sanal Sergi',
    nav_resources: 'Kaynaklar',
    nav_news: 'Haberler',
    nav_contact: 'İletişim',
    hero_headline: 'İklim Değişikliğine Yeni Bir Perspektiften Bakın.',
    hero_subtitle: 'İHA Teknolojisi, Dijital Hikaye Anlatımı ve İklim Eylemi ile Gençlerin Sesini Güçlendiriyoruz.',
    btn_explore: 'Misyonumuzu Keşfedin',
    btn_discover: 'İklim Hikayelerini Keşfedin'
  },
  ro: {
    nav_home: 'Acasă',
    nav_about: 'Despre Proiect',
    nav_partners: 'Parteneri',
    nav_activities: 'Activități',
    nav_stories: 'Povești Climatice',
    nav_exhibition: 'Expoziție Virtuală',
    nav_resources: 'Resurse',
    nav_news: 'Noutăți',
    nav_contact: 'Contact',
    hero_headline: 'Privește Schimbările Climatice dintr-o Nouă Perspectivă.',
    hero_subtitle: 'Împuternicirea Tinerilor prin Tehnologia Dronelor, Povestire Digitală și Acțiune Climatică.',
    btn_explore: 'Descoperă Misiunea Noastră',
    btn_discover: 'Descoperă Poveștile Climatice'
  }
};

let currentLang = localStorage.getItem('gh_lang') || 'en';

function initI18n() {
  const langBtn = document.getElementById('lang-switch-btn');
  const langMenu = document.getElementById('lang-switch-menu');
  if (!langBtn || !langMenu) return;

  langBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    langMenu.classList.toggle('open');
  });

  document.addEventListener('click', () => {
    langMenu.classList.remove('open');
  });

  langMenu.querySelectorAll('.lang-item-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const selected = btn.getAttribute('data-lang');
      setLanguage(selected);
    });
  });

  // Apply saved language if not english
  if (currentLang !== 'en') {
    applyLanguage(currentLang);
  }
}

function setLanguage(lang) {
  if (!i18nTranslations[lang]) return;
  currentLang = lang;
  localStorage.setItem('gh_lang', lang);
  applyLanguage(lang);
}

function applyLanguage(lang) {
  const dict = i18nTranslations[lang];
  if (!dict) return;

  const activeCodeEl = document.getElementById('current-lang-code');
  if (activeCodeEl) activeCodeEl.textContent = lang.toUpperCase();

  // Update active state in menu
  document.querySelectorAll('.lang-item-btn').forEach(btn => {
    if (btn.getAttribute('data-lang') === lang) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });

  // Translate all marked elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (dict[key]) {
      el.textContent = dict[key];
    }
  });

  if (typeof initActivityGalleries === 'function') {
    initActivityGalleries();
  }

  console.log(`[Green Horizon i18n] Language switched to: ${lang}`);
}

document.addEventListener('DOMContentLoaded', initI18n);
