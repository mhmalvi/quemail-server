# QueMail Server

The backend API for the QueMail email marketing platform. Built with Laravel 10, it handles email campaign orchestration, template management, scheduled bulk mailing, subscriber tracking, and delivery analytics.

## Features

- **Email Campaign Engine** — Create, schedule, and dispatch bulk email campaigns with queue-based processing
- **Template Management** — CRUD operations for reusable email templates with image upload support
- **Scheduled Mailing** — Cron-driven bulk mail scheduling with configurable delivery windows
- **Subscriber Management** — Subscribe/unsubscribe handling with QueLead integration
- **Email Tracking** — Open tracking via pixel, delivery status monitoring, and bounce detection
- **Campaign Analytics** — Per-campaign email counts, delivery rates, and historical records
- **Dynamic Mail Configuration** — Per-user SMTP settings for multi-tenant email sending
- **Rate Limiting** — Built-in mail limitation counting to stay within provider quotas
- **Queue Processing** — Laravel job queues for non-blocking email dispatch
- **API Authentication** — Sanctum-based token authentication with company-level middleware

## Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 10 |
| Language | PHP 8.1+ |
| Authentication | Laravel Sanctum |
| Queue | Laravel Queue (database/Redis) |
| Mail | SwiftMailer |
| Database | MySQL/PostgreSQL |

## Prerequisites

- PHP 8.1+
- Composer
- MySQL 8.0+ or PostgreSQL
- Redis (optional, for queue driver)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/mhmalvi/quemail-server.git
cd quemail-server
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database and mail configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=quemail
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Start the Server

```bash
php artisan serve
```

### 6. Start the Queue Worker

```bash
php artisan queue:work
```

## API Endpoints

### Email Operations

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/send-mail` | Send email to recipients |
| POST | `/api/mail-schedule-store` | Schedule a bulk mail campaign |
| POST | `/api/email-history` | Retrieve email sending history |
| POST | `/api/email-history-details` | Get detailed delivery records |
| POST | `/api/email-counts-on-today` | Get today's email send count |

### Template Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/save-template` | Create a new template |
| POST | `/api/get-template` | Retrieve templates |
| PUT | `/api/update-template` | Update an existing template |
| POST | `/api/delete-template` | Delete a template |

### Dynamic Mail Settings

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/save-mail` | Save SMTP configuration |
| GET | `/api/get-mail/{user_id}` | Get user mail settings |
| PUT | `/api/update-mail/{id}` | Update mail settings |
| POST | `/api/delete-mail` | Remove mail settings |

### Subscriber Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/queleads-subscribe` | Subscribe a contact |
| POST | `/api/queleads-unsubscribe` | Unsubscribe a contact |
| POST | `/api/unsubscribe` | Process unsubscribe request |

### Scheduling

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/scheduled-jobs` | List scheduled mail jobs |
| POST | `/api/scheduled-mails` | List scheduled mail details |

## Project Structure

```
quemail-server/
├── app/
│   ├── Console/Commands/         # Artisan commands (ScheduleBulkMail)
│   ├── Http/
│   │   ├── Controllers/          # API controllers
│   │   ├── Middleware/            # Auth and company middleware
│   │   └── Requests/             # Form request validation
│   ├── Jobs/                     # Queue jobs (SendQueueEmail)
│   ├── Mail/                     # Mailable classes
│   ├── Models/                   # Eloquent models
│   ├── Policies/                 # Authorization policies
│   └── Services/                 # Business logic services
├── database/migrations/          # Database schema migrations
├── routes/api.php                # API route definitions
├── config/                       # Laravel configuration
└── composer.json
```

## Related Projects

- [quemail-client](https://github.com/mhmalvi/quemail-client) — Frontend dashboard (Next.js)
- [quemail-templates](https://github.com/mhmalvi/quemail-templates) — HTML email template collection

## License

This project is open source and available under the [MIT License](LICENSE).
