#!/bin/bash

# Deployment Preparation Script
# Run this before uploading to shared hosting

echo "🚀 Preparing Laravel Application for Deployment..."
echo ""

# Step 1: Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Step 2: Build frontend assets
echo "🎨 Building frontend assets..."
npm install
npm run build

# Step 3: Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Step 4: Optimize for production
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Step 5: Create production .env template
echo "📝 Creating .env.production template..."
cp .env .env.production.example
sed -i 's/APP_ENV=local/APP_ENV=production/' .env.production.example
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env.production.example
sed -i 's/APP_URL=http:\/\/localhost/APP_URL=https:\/\/yourdomain.com/' .env.production.example

# Step 6: Create deployment package
echo "📦 Creating deployment package..."
echo "Excluding: node_modules, .git, tests..."

# Create zip excluding unnecessary files
zip -r artwork-deployment.zip . \
    -x "node_modules/*" \
    -x ".git/*" \
    -x "tests/*" \
    -x "storage/logs/*" \
    -x "storage/framework/cache/*" \
    -x "storage/framework/sessions/*" \
    -x "storage/framework/views/*" \
    -x ".vscode/*" \
    -x ".idea/*" \
    -x "*.log" \
    -x ".env"

echo ""
echo "✅ Deployment package created: artwork-deployment.zip"
echo ""
echo "📋 Next steps:"
echo "1. Upload artwork-deployment.zip to your hosting"
echo "2. Extract the files"
echo "3. Follow DEPLOYMENT_GUIDE.md for complete instructions"
echo ""
echo "🎉 Preparation complete!"
