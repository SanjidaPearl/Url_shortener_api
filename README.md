# 📌 URL Shortener API (Laravel + Sanctum)

A simple **URL Shortener REST API** built with Laravel and Sanctum.  
Users can **register, login, shorten long URLs, and fetch their shortened URLs**. Authentication is handled using Laravel Sanctum tokens.  

---
## 🚀 Features
- User Registration & Login with Sanctum Authentication  
- Generate unique short codes for long URLs  
- Fetch all shortened URLs for authenticated users  
- Basic validation & error handling  

---
## ⚙️ Project Setup

### 1. Clone the repository
```bash
git clone https://github.com/your-username/url-shortener-api.git
cd url-shortener-api
### 2. Install dependencies
composer install
### 3. Copy environment file & generate app key
cp .env.example .env
php artisan key:generate
### 4. Setup database
Update .env with DB credentials
### 5. Run migrations
php artisan migrate
### 6. Install Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
### 7. Run the server
php artisan serve
API will be available at: http://127.0.0.1:8000/api
📬 API Endpoints
1️⃣ Register User

POST /api/register
Request
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "123456"
}

Response
{
    "status": true,
    "message": "User registered successfully!",
    "data": {
        "name": "John Doe",
        "email": "john@example.com",
        "updated_at": "2025-09-20T13:18:35.000000Z",
        "created_at": "2025-09-20T13:18:35.000000Z",
        "id": 2
    }
}
2️⃣ Login User
POST /api/login
Request
{
  "email": "john@example.com",
  "password": "123456"
}
Response
{
    "status": true,
    "message": "Login successful",
    "token": "3|g...",
    "data": {
        "id": 2,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-09-20T13:18:35.000000Z",
        "updated_at": "2025-09-20T13:18:35.000000Z"
    }
}
3️⃣ Fetch User’s Shortened URLs
GET /api/urls
Headers
Authorization: Bearer <token>
Response
{
    "status": true,
    "data": [
        {
            "id": 4,
            "user_id": 2,
            "original_url": "https://example.com/some/long/path/kl",
            "short_code": "4",
            "visits": 0,
            "created_at": "2025-09-20T13:23:44.000000Z",
            "updated_at": "2025-09-20T13:23:44.000000Z"
        },
        {
            "id": 5,
            "user_id": 2,
            "original_url": "https://www.geeksforgeeks.org/quizzes/variable-declaration-and-scope-gq/",
            "short_code": "5",
            "visits": 2,
            "created_at": "2025-09-20T13:26:18.000000Z",
            "updated_at": "2025-09-20T13:26:31.000000Z"
        }
    ]
}
4️⃣ Shorten a URL
POST /api/shorten
Headers
Authorization: Bearer <token>
Request
{
    "original_url": "https://www.geeksforgeeks.org/quizzes/variable-declaration-and-scope-gq/"
}
Response
{
    "status": true,
    "message": "URL shortened successfully",
    "data": {
        "original_url": "https://www.geeksforgeeks.org/quizzes/variable-declaration-and-scope-gq/",
        "short_url": "http://127.0.0.1:8000/sh/5",
        "visits": null
    }
}
