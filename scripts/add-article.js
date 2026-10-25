/**
 * GREEN HORIZON — Add Article Utility
 * Usage: node scripts/add-article.js "Article Title" "Category" "Author" "Summary" "Content"
 */

const fs = require('fs');
const path = require('path');

const newsPath = path.join(__dirname, '../assets/data/news.json');

function addArticle(title, category, author, summary, content, tags = ['Erasmus+', 'Youth Work']) {
  if (!title || !summary) {
    console.error('Error: Article title and summary are required.');
    process.exit(1);
  }

  const raw = fs.readFileSync(newsPath, 'utf8');
  const news = JSON.parse(raw);

  const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
  const id = `news-${Date.now()}`;
  const date = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });

  const newArticle = {
    id,
    title,
    slug,
    date,
    category: category || 'Project Update',
    author: author || 'Consortium Secretariat',
    summary,
    content: content || summary,
    tags: Array.isArray(tags) ? tags : tags.split(',').map(t => t.trim()),
    badge: 'Update'
  };

  news.unshift(newArticle);
  fs.writeFileSync(newsPath, JSON.stringify(news, null, 2), 'utf8');

  console.log(`[Success] Article added: "${title}" (ID: ${id})`);
  console.log(`Total articles in archive: ${news.length}`);
}

// Check CLI parameters
const args = process.argv.slice(2);
if (args.length >= 2) {
  addArticle(args[0], args[1], args[2], args[3], args[4], args[5]);
} else {
  module.exports = { addArticle };
}
