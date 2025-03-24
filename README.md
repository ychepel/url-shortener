# URL Shortener

URL shortening service built with Laravel 12, featuring both web interface and API endpoints.

## Features

- 🔗 Shorten long URLs to concise, shareable links
- 🎯 Create custom aliases for your URLs
- 📊 Track visit counts for each shortened URL
- 🌐 Clean, responsive web interface
- ⚡ RESTful API endpoints
- ✨ Modern, type-safe codebase with strict typing

## Requirements

- Docker
- Docker Compose
- PHP 8.2+
- Composer

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd url-shortener
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Start the Laravel Sail environment:
```bash
./vendor/bin/sail up -d
```

5. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

6. Run database migrations:
```bash
./vendor/bin/sail artisan migrate
```

## Usage

### Web Interface

1. Visit `http://localhost` in your browser
2. Enter a URL to shorten
3. (Optional) Provide a custom alias
4. Click "Shorten URL"
5. Copy and share your shortened URL

### API Endpoints

#### Create Short URL
```http
POST /api/shorten
Content-Type: application/json

{
    "url": "https://example.com",
    "custom_alias": "my-custom-url" // optional
}
```

Response:
```json
{
    "short_url": "http://localhost/s/abc123",
    "original_url": "https://example.com"
}
```

## Testing

Run the test suite:
```bash
./vendor/bin/sail artisan test
```

## Architecture

The application follows modern Laravel practices:
- Form Request Validation
- Action Classes for business logic
- Feature Tests
- Type-safe code with strict typing
- Tailwind CSS for styling

## License

This project is open-sourced software licensed under the MIT license.
