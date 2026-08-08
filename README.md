# Color Prediction Game

A real-time **Color Prediction Game** (Win Go style) built with **Laravel 12**, 
featuring automatic round generation, live betting, wallet management, 
and a complete admin panel.

---

## Features

### Game
- Real-time 60-second rounds with live countdown timer
- Predict **Color** (Green / Red / Violet), **Number** (0–9), or **Size** (Big / Small)
- Automatic result generation every minute via Laravel Scheduler
- Last 10 seconds betting lock with voice countdown
- Instant Win/Lose popup with balance update (no page reload)
- AJAX-based real-time updates (no page refresh)

### Payout System
| Bet Type | Payout |
|----------|--------|
| Number   | 10x    |
| Color    | 3x     |
| Big/Small| 2x     |

### Color Mapping
| Color  | Numbers |
|--------|---------|
| 🟢 Green  | 1, 3, 7, 9 |
| 🔴 Red    | 2, 4, 6, 8 |
| 🟣 Violet | 0, 5       |

### Wallet System
- UPI-based deposit with UTR verification
- Manual withdrawal requests
- Complete transaction history
- Real-time balance updates

### Admin Panel
- Live round monitoring with betting stats
- Manual result override
- Deposit approval / rejection
- Withdrawal management
- User management (block/unblock)
- User query management

### Help Center
- Complete game guide
- FAQ section
- User query submission form
- Admin email reply system

---

## Tech Stack

| Layer      | Technology          |
|------------|---------------------|
| Backend    | Laravel 12 (PHP 8.2)|
| Frontend   | Blade Templates     |
| Database   | MySQL               |
| Realtime   | AJAX Polling        |
| Scheduler  | Laravel Cron Job    |
| Hosting    | Hostinger           |

---

## Installation

### Requirements
- PHP 8.2+
- Composer
- MySQL
- Laravel 12

### Setup

```bash
# Clone the repo
git clone https://github.com/rahulbhatiwal5-cmyk/laravel-colour-game.git
cd laravel-colour-game

# Install dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure .env
DB_DATABASE=colour-game
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Start scheduler (development)
php artisan schedule:work

# Start server
php artisan serve
```

### Production (Cron Job)
```bash
* * * * * /usr/bin/php /path-to-project/artisan schedule:run >> /dev/null 2>&1
```

## Game Logic

Every 60 seconds:
↓
Cron Job triggers
↓
Result calculated:
Priority 1 → Admin manual result
Priority 2 → Random (< 2 users)
Priority 3 → Min payout number (admin profit)
↓
Winners paid instantly
↓
New round starts automatically

---

##  Disclaimer

> This is a risk-based prediction game for educational purposes.
> Financial loss is possible. Users are solely responsible for their decisions.
> This project is built for learning Laravel development concepts.

---

## Developer

Built with using **Laravel 12**

---

## License

This project is for **educational purposes only**.
