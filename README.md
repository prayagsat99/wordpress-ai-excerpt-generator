# 🚀 WordPress AI Excerpt Generator (Gemini Powered)

Automatically generate SEO-friendly blog excerpts for WordPress posts using Google Gemini AI in a single click.

This plugin scans your website for posts that do not have excerpts, reads the article content, and generates short compelling summaries designed to improve click-through rate, SEO snippets, and content presentation.

What normally takes hours of manual writing can now be completed in seconds.

---

# ✨ Features

## ⚡ One-Click AI Excerpt Generation

Generate excerpts for hundreds or thousands of blog posts instantly.

The plugin automatically:

1. Scans all posts
2. Detects posts missing excerpts
3. Sends content to Google Gemini AI
4. Generates engaging summaries
5. Updates the WordPress excerpt field

---

## 🤖 Powered by Google Gemini AI

Uses the fast and efficient model:

**Gemini 2.5 Flash Lite**

Prompt used:

> Write a 22–28 word blog excerpt encouraging readers to click the article. Do not repeat the title.

This produces high-quality click-driving summaries perfect for:

- Blog archive pages
- Search result snippets
- Homepage previews
- Content feeds

---

## 📊 Live Progress Tracking

The plugin includes a real-time dashboard with:

- Progress bar
- Number of posts processed
- Live generation logs
- Generated titles
- Error tracking

---

## 🧠 Smart Batch Processing

To prevent server overload, the plugin processes posts in batches of 10.

Benefits:

✔ Prevents server crashes  
✔ Avoids API throttling  
✔ Works smoothly with large websites  
✔ Efficient processing for thousands of posts

---

## 🔐 Built-in Daily API Limit

The plugin includes a daily usage control system.

Example configuration inside the plugin:

WAEG_DAILY_LIMIT = 300

Once the limit is reached, generation automatically stops until the next day.

This prevents accidental API overuse.

---

# 📈 SEO Benefits

Adding excerpts improves:

✔ Blog feed quality  
✔ Search engine previews  
✔ Click-through rate  
✔ Content readability  
✔ User engagement

Search engines prefer pages with structured previews instead of random content snippets.

---

# 🧩 How It Works

Scan Posts  
↓  
Find posts missing excerpts  
↓  
Send title + content to Gemini AI  
↓  
Generate 22–28 word excerpt  
↓  
Update WordPress post_excerpt field

Everything happens directly inside the WordPress admin dashboard.

---

# 🛠 Installation

1. Download the plugin.

2. Upload it to:

/wp-content/plugins/prayag-smart-excerpt-maker/

3. Activate the plugin in:

WordPress Dashboard → Plugins

4. Open the tool from:

Dashboard → Smart Excerpts

---

# 🔑 Setup (Add Your Gemini API Key)

1. Get a free API key from  
https://aistudio.google.com

2. Open the plugin page.

3. Enter your Gemini API Key.

4. Save the key.

The plugin is now ready to generate excerpts.

---

# 💰 Estimated API Cost

This plugin is designed to use very few tokens.

Each request sends approximately ~1500 characters of content.

Gemini Flash Lite is extremely inexpensive.

| Posts | Estimated Cost |
|------|---------------|
| 100 | $0 |
| 1,000 | ~$0.10 |
| 5,000 | ~$0.50 |
| 10,000 | ~$1 |

In many cases the entire process fits within Google's free tier.

---

# 🧪 Example Scenario

Example blog:

1500 articles

Manual excerpt writing:

5–6 hours

Using this plugin:

2–3 minutes

Estimated cost:

$0 – $0.20 for 2000 blog posts

---

# 👨‍💻 Who Should Use This Plugin

Perfect for:

🧑‍💻 WordPress developers  
📈 SEO agencies  
✍️ Bloggers  
🏢 Content teams  
🌐 Large content websites  
🛍 WooCommerce blog stores  

Especially useful for sites with hundreds or thousands of posts.

---

# ⚙️ Technical Overview

WordPress hooks used:

admin_menu  
wp_ajax_waeg_scan_posts  
wp_ajax_waeg_generate_batch

Frontend components include:

✔ AJAX batch generation  
✔ progress tracking  
✔ live logging  
✔ smart request handling

---

# 🔍 SEO Keywords

This repository targets searches like:

- wordpress ai plugin
- wordpress excerpt generator
- ai excerpt generator wordpress
- gemini wordpress plugin
- auto generate wordpress excerpts
- wordpress ai content automation
- ai blog summary wordpress

---

# 🔒 Security Notes

Never publish your API key publicly.

Each user must add their own Gemini API key in plugin settings.

---

# 🚧 Future Improvements

Planned upgrades:

✔ Custom AI prompts  
✔ Multi-language support  
✔ WooCommerce product excerpts  
✔ Page excerpt generation  
✔ Token usage analytics  
✔ Scheduled automation  
✔ Background processing

---

# ⚠ Disclaimer

This plugin is an early Version 2 release and may receive improvements and updates over time.

Users should test the plugin in a staging environment before using it on production websites.

The author is not responsible for API charges, content output, data loss, or site issues resulting from the use of this plugin.

Use at your own discretion.

---

# 📜 License

This project is provided as-is without warranty.

You are free to use, modify, and improve this plugin.

---

# 👤 Author

Prayag Sathyanath 
Digital Transformation Specialist
Brand Strategist  
WordPress Developer  
AI Automation Enthusiast

https://prayagsat.com/

---

## ☕ Support This Project

If this plugin helped you save time, consider supporting development.

🇮🇳 India (UPI):
pegzat99-1@okaxis

🌍 Global
PayPal: https://www.paypal.com/paypalme/prayagsat

⭐ Please consider starring the repository on GitHub. Thank you.