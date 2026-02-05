# SHARED HOSTING DEPLOYMENT GUIDE
# Academic Artworks Archive - Laravel Application

## REQUIREMENTS
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer (to prepare locally before upload)
- SSH access (recommended) or FTP/File Manager

---

## STEP 1: PREPARE APPLICATION LOCALLY

### 1.1 Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 1.2 Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 1.3 Create Production .env from .env.example
Create a `.env.production` file with these settings:

```env
APP_NAME="Academic Artworks Archive"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Gemini API for Chatbot
GEMINI_API_KEY=your_gemini_api_key_here

# Mail Configuration (Optional - for password reset)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## STEP 2: UPLOAD TO SHARED HOSTING

### Option A: Using SSH (Recommended)
```bash
# Zip your project (excluding unnecessary files)
zip -r artwork.zip . -x "node_modules/*" ".git/*" "storage/logs/*" "tests/*"

# Upload via SCP
scp artwork.zip user@yourdomain.com:~/

# SSH into server
ssh user@yourdomain.com

# Unzip
unzip artwork.zip -d artwork
```

### Option B: Using FTP/cPanel File Manager
1. Compress the entire project folder (excluding: node_modules, .git, tests)
2. Upload via FTP to your hosting account
3. Extract on the server

---

## STEP 3: CONFIGURE SHARED HOSTING

### 3.1 Folder Structure
Most shared hosting uses `public_html` as the web root. You need:

```
/home/username/
├── artwork/              (Laravel app - outside public_html)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/          (this needs to be linked)
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
└── public_html/         (web root - point here)
```

### 3.2 Move Files to Correct Location

**Option 1: Symlink Method (if supported)**
```bash
# Move Laravel to parent directory
mv artwork /home/username/

# Remove default public_html content
rm -rf /home/username/public_html/*

# Symlink public folder to public_html
ln -s /home/username/artwork/public/* /home/username/public_html/
```

**Option 2: Copy Public Contents**
```bash
# Copy public folder contents to public_html
cp -r /home/username/artwork/public/* /home/username/public_html/

# Edit public_html/index.php to point to correct paths
```

### 3.3 Edit index.php in public_html
If you copied (Option 2), edit `/home/username/public_html/index.php`:

Change:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

To:
```php
require __DIR__.'/../artwork/vendor/autoload.php';
$app = require_once __DIR__.'/../artwork/bootstrap/app.php';
```

---

## STEP 4: DATABASE SETUP

### 4.1 Create Database via cPanel
1. Login to cPanel
2. Go to "MySQL Databases"
3. Create new database: `username_artwork`
4. Create database user
5. Add user to database with ALL PRIVILEGES

### 4.2 Import Database
```bash
# On server (if you have SSH)
mysql -u username_artwork -p username_artwork < database.sql

# Or use cPanel phpMyAdmin to import
```

### 4.3 Run Migrations (if fresh install)
```bash
cd /home/username/artwork
php artisan migrate --force
php artisan db:seed --class=SettingsSeeder --force
php artisan db:seed --class=CategoryIconSeeder --force
```

---

## STEP 5: SET PERMISSIONS

```bash
# Set proper permissions
chmod -R 755 /home/username/artwork
chmod -R 775 /home/username/artwork/storage
chmod -R 775 /home/username/artwork/bootstrap/cache

# If www-data or apache user
chown -R www-data:www-data /home/username/artwork/storage
chown -R www-data:www-data /home/username/artwork/bootstrap/cache
```

---

## STEP 6: CONFIGURE .ENV

### 6.1 Copy Production Environment
```bash
cd /home/username/artwork
cp .env.production .env
```

### 6.2 Generate Application Key (if not set)
```bash
php artisan key:generate --force
```

### 6.3 Update .env with Your Details
- Set correct APP_URL (your domain)
- Set database credentials
- Set GEMINI_API_KEY
- Set mail credentials (if using)

---

## STEP 7: STORAGE LINK

```bash
# Create symbolic link for storage
php artisan storage:link --force
```

---

## STEP 8: OPTIMIZATION FOR PRODUCTION

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## STEP 9: CLEAR CACHES (if needed)

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## TROUBLESHOOTING

### Issue: 500 Internal Server Error
- Check `.env` file exists and APP_KEY is set
- Check folder permissions (storage and bootstrap/cache)
- Enable debug temporarily: `APP_DEBUG=true` in .env
- Check error logs: `storage/logs/laravel.log`

### Issue: Public files not loading
- Run: `php artisan storage:link`
- Check symlink exists: `ls -la public/storage`

### Issue: Routes not working
- Make sure `.htaccess` exists in public directory
- Enable mod_rewrite in Apache
- Clear route cache: `php artisan route:clear`

### Issue: Database connection failed
- Verify database credentials in .env
- Check if database exists
- Test connection: `php artisan migrate:status`

### Issue: Assets not loading (CSS/JS)
- Run: `npm run build` locally before upload
- Check APP_URL in .env matches your domain
- Clear browser cache

---

## MAINTENANCE MODE

### Enable Maintenance
```bash
php artisan down --secret="your-secret-token"
# Access via: https://yourdomain.com/your-secret-token
```

### Disable Maintenance
```bash
php artisan up
```

---

## PERFORMANCE TIPS

1. **Enable OPcache** (ask hosting provider)
2. **Use Redis/Memcached** for caching (if available)
3. **Enable CDN** for static assets
4. **Compress images** before upload
5. **Enable Gzip** compression in .htaccess

---

## BACKUP STRATEGY

### Database Backup
```bash
# Create backup
mysqldump -u username -p database_name > backup_$(date +%F).sql

# Automate via cron (cPanel Cron Jobs)
0 2 * * * mysqldump -u username -p database_name > ~/backups/db_$(date +\%F).sql
```

### Files Backup
- Backup storage/app/public (uploaded files)
- Backup .env file
- Full backup weekly via cPanel Backup

---

## SECURITY CHECKLIST

- ✅ APP_DEBUG=false in production
- ✅ Strong APP_KEY generated
- ✅ Secure database credentials
- ✅ HTTPS enabled (SSL certificate)
- ✅ Storage permissions set correctly
- ✅ .env file not accessible via web
- ✅ Keep Laravel and dependencies updated

---

## POST-DEPLOYMENT VERIFICATION

1. Visit your domain: https://yourdomain.com
2. Test login/register functionality
3. Upload a test artwork
4. Test chatbot functionality
5. Check admin panel access
6. Verify email functionality (if configured)
7. Test all major features

---

## QUICK COMMAND REFERENCE

```bash
# Cache everything
php artisan optimize

# Clear everything
php artisan optimize:clear

# Check application status
php artisan about

# View current configuration
php artisan config:show

# Queue worker (if using)
php artisan queue:work --daemon

# Schedule runner (add to cron)
* * * * * cd /home/username/artwork && php artisan schedule:run >> /dev/null 2>&1
```

---

## SUPPORT

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check server error logs (cPanel Error Log)
3. Enable debug mode temporarily
4. Contact hosting provider for server-specific issues

---

**Deployment Date**: {{ date }}
**Laravel Version**: 10.x
**PHP Version Required**: 8.1+
