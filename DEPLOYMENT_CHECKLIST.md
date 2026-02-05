# Quick Deployment Checklist

## Before Upload
- [ ] Run `prepare-deployment.bat` (Windows) or `prepare-deployment.sh` (Linux/Mac)
- [ ] Create database backup: `php artisan db:backup` (if you have data)
- [ ] Export database to SQL file for import on hosting
- [ ] Test application locally one final time

## Required Files to Edit on Server
- [ ] `.env` - Configure for production (use .env.production.example as template)
- [ ] `public/index.php` - Update paths if not using symlink
- [ ] `.htaccess` - Already included in public folder

## On Shared Hosting
- [ ] Create MySQL database via cPanel
- [ ] Create database user and assign to database
- [ ] Upload and extract files
- [ ] Move Laravel folder outside public_html
- [ ] Link or copy public folder contents to public_html
- [ ] Edit `.env` with database credentials
- [ ] Generate APP_KEY: `php artisan key:generate --force`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Run seeders: `php artisan db:seed --class=SettingsSeeder --force`
- [ ] Create storage link: `php artisan storage:link --force`
- [ ] Set permissions: `chmod -R 775 storage bootstrap/cache`
- [ ] Cache configs: `php artisan optimize`

## Post-Deployment Testing
- [ ] Visit homepage
- [ ] Test login/register
- [ ] Test file upload (artwork)
- [ ] Test chatbot
- [ ] Test admin panel
- [ ] Check all navigation links
- [ ] Test on mobile device

## Production Settings Checklist
- [ ] APP_ENV=production
- [ ] APP_DEBUG=false
- [ ] APP_URL set to your domain
- [ ] GEMINI_API_KEY configured
- [ ] Database credentials correct
- [ ] Storage folder writable
- [ ] HTTPS enabled (SSL certificate)

## Common Issues
1. **500 Error**: Check .env file exists, APP_KEY set, permissions correct
2. **Assets not loading**: Run `npm run build` locally, check APP_URL
3. **Database error**: Verify credentials, check if DB exists
4. **Routes not working**: Check .htaccess, enable mod_rewrite

## Support Commands
```bash
# Check status
php artisan about

# Clear everything
php artisan optimize:clear

# Rebuild caches
php artisan optimize

# View logs
tail -f storage/logs/laravel.log
```

---
📄 See DEPLOYMENT_GUIDE.md for detailed instructions
