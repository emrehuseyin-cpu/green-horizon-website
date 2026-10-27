# Green Horizon — HostGator Deployment & GitHub Integration Guide

> **Official Domain:** [https://greenhorizonyou.eu](https://greenhorizonyou.eu)  
> **Hosting Environment:** HostGator cPanel Shared Hosting (Apache + PHP 8.x)  
> **Target Repository:** Private GitHub repo `green-horizon-website`  

---

## 1. Document Root Verification on HostGator

Before uploading or synchronizing files, verify the exact document root for **greenhorizonyou.eu** in your HostGator cPanel.

### How to Check in cPanel:
1. Log in to your **HostGator Customer Portal** and open **cPanel**.
2. In the **Domains** section, click on **Domains** (or **Addon Domains** / **Aliases**).
3. Find `greenhorizonyou.eu` in the list and inspect the **Document Root** column:
   - **Case A (Primary Domain on your HostGator account):**  
     The document root is `/public_html` (or `home/$USER/public_html`).
   - **Case B (Addon Domain on an existing hosting plan):**  
     The document root is typically `/public_html/greenhorizonyou.eu` or `/greenhorizonyou.eu`.

> [!IMPORTANT]
> All files from this repository (or from the generated `dist/` directory) must be deployed into that exact document root directory so visitors visiting `https://greenhorizonyou.eu` receive the site.

---

## 2. GitHub Integration Setup

Initialize and synchronize your workspace with your private GitHub repository `green-horizon-website`.

### Step 1: Create the Private Repository on GitHub
1. Open your browser and go to [https://github.com/new](https://github.com/new).
2. Set **Repository name:** `green-horizon-website`.
3. Select **Private** (recommended to keep draft project files and internal contact structures secure).
4. Do **not** check "Initialize with a README" or ".gitignore" (we have already created tailored versions).
5. Click **Create repository**.

### Step 2: Connect Local Workspace to GitHub
Open your terminal in the project directory (`/Users/emrehuseyinyigit/Desktop/greenhorizon`) and run:

```bash
# 1. Initialize git if not already initialized
git init

# 2. Add all project files
git add .

# 3. Create initial project commit
git commit -m "feat: complete Green Horizon Erasmus+ website platform with drone HUD & 360 VR"

# 4. Set default branch to main
git branch -M main

# 5. Link to your private GitHub repository (replace YOUR-USERNAME with your actual GitHub username)
git remote add origin https://github.com/YOUR-USERNAME/green-horizon-website.git

# 6. Push to GitHub
git push -u origin main
```

### Step 3: Ongoing Editing Workflow in Antigravity
Whenever you ask Antigravity to make changes:
```bash
# Check status
git status

# Commit changes
git add .
git commit -m "update: add news article and new field photos"

# Push to your private GitHub backup
git push origin main
```

---

## 3. HostGator Deployment Methods

We have prepared two fully supported deployment methods.

---

### METHOD A: Manual Deployment via HostGator cPanel File Manager (Recommended & Simplest)

This method requires **no SSH access** and takes under 3 minutes.

#### 1. Generate the Production Release Package
In your project directory, run:
```bash
npm run build
```
This automatically validates all pages and compiles `greenhorizon-deploy.zip` in the root folder.

#### 2. Upload via cPanel File Manager
1. Log in to **HostGator cPanel**.
2. Click **File Manager** (under *Files*).
3. In the directory tree, navigate to the verified document root (e.g. `public_html` or `public_html/greenhorizonyou.eu`).
4. Click **Upload** in the top toolbar.
5. Drag and drop `greenhorizon-deploy.zip`.
6. Once the progress bar reaches 100% (blue/green), return to File Manager.

#### 3. Extract and Activate
1. Right-click on `greenhorizon-deploy.zip` in File Manager and choose **Extract**.
2. Select your document root as the destination directory.
3. Verify that `index.html`, `assets/`, `api/`, and `.htaccess` are directly inside the document root (not nested inside an extra folder).
4. *(Optional)* Delete `greenhorizon-deploy.zip` from File Manager to keep storage tidy.
5. In cPanel, click **Settings** (top-right corner) and ensure **"Show Hidden Files (dotfiles)"** is checked so `.htaccess` is visible.

---

### METHOD B: Automated Deployment via cPanel Git Version Control

If your HostGator cPanel plan includes **Git™ Version Control**:

#### 1. Configure Git in cPanel
1. In cPanel, search for and open **Git™ Version Control** (under *Files*).
2. Click **Create**.
3. Toggle **Clone a Repository**.
4. Enter:
   - **Clone URL:** `https://github.com/YOUR-USERNAME/green-horizon-website.git` (or your SSH URL if configured).
   - **Repository Path:** `/home/YOUR_USER/repositories/green-horizon-website` (outside public_html).
   - **Repository Name:** `green-horizon-website`.
5. Click **Create**.

#### 2. Automatic Deployment via `.cpanel.yml`
The project already includes a production-ready `.cpanel.yml` file:
```yaml
---
deployment:
  tasks:
    - export DEPLOYPATH=/home/$USER/public_html/
    # If using an addon domain, change to:
    # - export DEPLOYPATH=/home/$USER/public_html/greenhorizonyou.eu/
    - /bin/cp -R * $DEPLOYPATH
    - /bin/cp .htaccess $DEPLOYPATH
```
Whenever you push to GitHub:
1. In cPanel **Git™ Version Control**, click **Manage** next to `green-horizon-website`.
2. Click the **Pull or Deploy** tab.
3. Click **Update from Remote** to pull latest changes.
4. Click **Deploy HEAD Commit** to automatically copy the updated website into your live document root.

---

### METHOD C: Secure SFTP / FTP Deployment

If you prefer using an FTP/SFTP client such as **FileZilla**, **Cyberduck**, or **Transmit**:

1. HostGator FTP Connection settings:
   - **Host:** `ftp.greenhorizonyou.eu` or your HostGator server IP / server hostname.
   - **Username:** Your cPanel username (or dedicated FTP account created in cPanel > FTP Accounts).
   - **Port:** `21` (FTP with explicit TLS) or `22` (SFTP if SSH is active).
2. Connect and navigate to your document root (`/public_html`).
3. Upload the contents of the local `dist/` directory directly into the remote document root.

---

## 4. Server Configuration & Contact Form Setup

### 1. Enforcing HTTPS (SSL)
Your domain `greenhorizonyou.eu` must use HTTPS for European Union projects and modern browser security.
- HostGator provides free **AutoSSL** (Let's Encrypt / cPanel SSL).
- In cPanel, verify **SSL/TLS Status** shows a green padlock for `greenhorizonyou.eu`.
- The included `.htaccess` automatically redirects all HTTP traffic to HTTPS.

### 2. Contact Form (`api/contact.php`)
- Standard HostGator cPanel shared hosting natively executes PHP scripts in `api/contact.php`.
- The script sends emails via PHP's native `mail()` to:  
  `info@greenhorizonyou.eu`
- To ensure reliable deliverability, create the email account in cPanel:
  1. Open cPanel > **Email Accounts**.
  2. Click **Create**.
  3. Enter Username: `info` @ `greenhorizonyou.eu`.
  4. Set a strong password.

---

## 5. Backup & Rollback Protocol

Always keep a safe snapshot before publishing significant updates:

### Creating an Instant Backup:
1. In cPanel > **File Manager**, select your document root directory.
2. Click **Compress** (choose ZIP archive).
3. Name it `backup-before-update-YYYY-MM-DD.zip`.
4. Download the backup to your local machine.

### Instant Rollback:
If an issue occurs after an update:
1. Delete the files in the document root (except your backup zip).
2. Right-click your backup zip and choose **Extract**.
3. Your previous live state is restored within seconds.

---

## 6. Pre-Flight Deployment Checklist

Before going live, verify:
- [ ] Run `npm run build` locally to ensure zero syntax or JSON errors.
- [ ] Document root verified in cPanel (`public_html` or addon path).
- [ ] `.htaccess` present in document root (ensures HTTPS and Gzip compression).
- [ ] Test https://greenhorizonyou.eu in desktop and mobile viewports.
- [ ] Test the interactive Europe map (zoom into Germany, Türkiye, Romania).
- [ ] Test Virtual Exhibition Viewer in `exhibition.html`.
- [ ] Submit a test message through `contact.html`.
- [ ] Check EU funding visibility logo and disclaimer on every page.
