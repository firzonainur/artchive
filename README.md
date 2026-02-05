# Academic Artworks Archive

A Laravel-based web application for managing and showcasing academic artworks with an AI-powered chatbot assistant.

## Features

- 🎨 **Artwork Management**: Upload, categorize, and showcase academic artworks
- 🤖 **AI Chatbot**: Intelligent assistant powered by Google Gemini API
- 📚 **Learning Materials**: Educational content and tutorials
- 🔬 **Research Publications**: Manage and display academic research
- 🖼️ **Virtual Exhibition**: Immersive 3D artwork viewing experience
- 👥 **User Management**: Role-based access control for admins and users
- 📊 **Analytics Dashboard**: Track visitor statistics and engagement
- 💬 **Comments System**: Interactive discussions on artworks
- 🏷️ **Categories & Techniques**: Organize artworks by type and medium

## Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM
- Google Gemini API Key

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/yourusername/artwork.git
cd artwork
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install JavaScript dependencies
```bash
npm install
```

### 4. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure your `.env` file
```env
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

GEMINI_API_KEY=your_gemini_api_key_here
```

### 6. Create database and run migrations
```bash
php artisan migrate
```

### 7. Seed the database (optional)
```bash
php artisan db:seed --class=SettingsSeeder
php artisan db:seed --class=CategoryIconSeeder
```

### 8. Create storage link
```bash
php artisan storage:link
```

### 9. Build frontend assets
```bash
npm run dev
# or for production
npm run build
```

### 10. Start the development server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Admin Access

After installation, you may need to create an admin user manually or use Laravel Tinker:

```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = Hash::make('password');
$user->is_admin = true;
$user->save();
```

## Configuration

### Chatbot Setup

1. Get a Gemini API key from [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Add to `.env`: `GEMINI_API_KEY=your_api_key_here`
3. Enable/disable chatbot from Admin Panel → Settings

### File Storage

Uploaded files are stored in `storage/app/public`. The storage link must be created:
```bash
php artisan storage:link
```

## Development

### Running tests
```bash
php artisan test
```

### Code style
```bash
./vendor/bin/pint
```

### Clear caches
```bash
php artisan optimize:clear
```

## Deployment

See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) for detailed shared hosting deployment instructions.

Quick deployment steps:
1. Run `prepare-deployment.bat` (Windows) or `prepare-deployment.sh` (Linux/Mac)
2. Upload to hosting
3. Configure production environment
4. Run migrations and optimizations

## Technologies Used

- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Tailwind CSS, Alpine.js, Blade Templates
- **Database**: MySQL
- **AI**: Google Gemini API
- **3D Viewer**: A-Frame (for Virtual Exhibition)
- **Charts**: Chart.js

## Project Structure

```
artwork/
├── app/                # Application logic
├── database/           # Migrations and seeders
├── public/             # Web root
├── resources/          # Views, CSS, JS
├── routes/             # Route definitions
├── storage/            # File storage
└── vendor/             # Composer dependencies
```

## Key Features Details

### Admin Panel
- Dashboard with analytics
- User management
- Artwork moderation
- Category management
- Learning materials CRUD
- Global settings (chatbot toggle)

### Chatbot
- Context-aware responses
- Artwork recommendations with links
- Multi-content type support (artworks, learning materials, research)
- Real-time enable/disable from admin
- Markdown formatting support

### Virtual Exhibition
- 3D immersive environment
- Interactive artwork viewing
- VR-ready interface

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email security@yourdomain.com instead of using the issue tracker.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- Developed by: Your Name
- Framework: [Laravel](https://laravel.com)
- AI: [Google Gemini](https://ai.google.dev)

## Support

For support, email support@yourdomain.com or open an issue on GitHub.
