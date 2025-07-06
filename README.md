# Witsawa API

A Laravel-based REST API for user management system with JWT authentication, supporting Investor and Entrepreneur roles.

## Features

- 🔐 JWT Authentication (Login/Register/Logout)
- 👥 User Management (CRUD operations)
- 🎯 Role-based Access (Investor, Entrepreneur, or both)
- 📧 Email validation and uniqueness
- 🔒 Password hashing and confirmation
- 📱 API-first design with JSON responses

## Tech Stack

- **Framework**: Laravel 11
- **Database**: SQLite
- **Authentication**: JWT (tymon/jwt-auth)
- **Language**: PHP 8.x
- **API**: RESTful API

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm (optional, for frontend assets)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd witsawa
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **JWT Secret**
   ```bash
   php artisan jwt:secret
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## API Documentation

### Authentication Endpoints

#### Register
```http
POST /api/register
```

**Request Body:**
```json
{
    "role": ["Investor", "Entrepreneur"],
    "title_name": "Mr.",
    "name": "John",
    "surname": "Doe",
    "date_of_birth": "1990-01-01",
    "phone_number": "1234567890",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "user": {
        "id": 1,
        "role": ["Investor", "Entrepreneur"],
        "title_name": "Mr.",
        "name": "John",
        "surname": "Doe",
        "date_of_birth": "1990-01-01",
        "phone_number": "1234567890",
        "email": "john@example.com",
        "created_at": "2025-07-06T...",
        "updated_at": "2025-07-06T..."
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

#### Login
```http
POST /api/login
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "user": {
        "id": 1,
        "role": ["Investor", "Entrepreneur"],
        "title_name": "Mr.",
        "name": "John",
        "surname": "Doe",
        "date_of_birth": "1990-01-01",
        "phone_number": "1234567890",
        "email": "john@example.com",
        "created_at": "2025-07-06T...",
        "updated_at": "2025-07-06T..."
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

#### Get Current User
```http
GET /api/me
Authorization: Bearer {token}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### User Management Endpoints

All user management endpoints require authentication.

#### Get All Users
```http
GET /api/users
Authorization: Bearer {token}
```

#### Get User by ID
```http
GET /api/users/{id}
Authorization: Bearer {token}
```

#### Create User
```http
POST /api/users
Authorization: Bearer {token}
```

#### Update User
```http
PUT /api/users/{id}
Authorization: Bearer {token}
```

#### Delete User
```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

## Database Schema

### Users Table
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| role | json | User roles (Investor, Entrepreneur) |
| title_name | enum | Title (Mr., Mrs., Miss) |
| name | string | First name |
| surname | string | Last name |
| date_of_birth | date | Birth date |
| phone_number | string (nullable) | Phone number |
| email | string (unique) | Email address |
| password | string (hashed) | Password |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

## Validation Rules

### Registration/User Creation
- **role**: Required, array, values must be "Investor" or "Entrepreneur"
- **title_name**: Required, must be "Mr.", "Mrs.", or "Miss"
- **name**: Required, string
- **surname**: Required, string
- **date_of_birth**: Required, valid date
- **phone_number**: Optional, string
- **email**: Required, valid email, unique
- **password**: Required, minimum 6 characters, confirmed

## Error Handling

The API returns appropriate HTTP status codes:

- `200` - Success
- `201` - Created
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

**Error Response Format:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

## Configuration

### JWT Configuration
JWT settings can be configured in `config/jwt.php`:
- Token TTL (Time to Live)
- Refresh TTL
- Algorithm settings

### Database Configuration
Database settings in `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

## Testing

Run the test suite:
```bash
php artisan test
```

## Development

### Useful Commands
```bash
# Clear all caches
php artisan optimize:clear

# Generate API documentation
php artisan route:list

# Check code style
./vendor/bin/pint

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

### Project Structure
```
app/
├── Http/
│   └── Controllers/
│       ├── AuthController.php    # Authentication logic
│       └── UserController.php    # User CRUD operations
├── Models/
│   └── User.php                  # User model with JWT interface
database/
├── migrations/
│   └── 0001_01_01_000000_create_users_table.php
routes/
├── api.php                       # API routes
config/
├── jwt.php                       # JWT configuration
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, email support@witsawa.com or create an issue in the repository.

---

Made with ❤️ by Witsawa Team
