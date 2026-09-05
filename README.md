# Kids Daily Routine & Habit Tracker 🐾

A modern, gamified single-page application (SPA) built to help parents establish daily routines for infants and toddlers. When a child completes a daily task (like brushing their teeth), the app securely fetches a random animal image via API and awards it as a visual badge.

## 🚀 Tech Stack

*   **Backend:** Laravel 11, PHP 8.2
*   **Frontend:** React, Tailwind CSS, Inertia.js
*   **Database:** SQLite / MySQL
*   **External API:** Dog CEO API (Reward fetching)

## ✨ Core Features & Concepts Demonstrated

*   **Inertia.js Integration:** Built as a monolithic SPA. React components receive data directly from Laravel controllers without needing to manage complex REST API endpoints or state via Axios.
*   **Eloquent Polymorphic Relationships:** The reward system uses a flexible polymorphic schema. A `Badge` model can be awarded to either a `Routine` or a `Habit` using a single database table (`badgeable_id`, `badgeable_type`).
*   **Secure File Storage:** Instead of hotlinking external images, the app utilizes Laravel's HTTP Client to download API images securely to local public storage via the `Storage` facade.
*   **Task Scheduling:** Features a custom Artisan console command (`php artisan habits:reset`) scheduled via `routes/console.php` to automatically clear completed habits and delete orphaned image files every night at midnight.
*   **Service Classes:** External API logic is abstracted away from controllers into a dedicated `RewardService` to ensure clean architecture.

## 💻 Local Setup Instructions

1. Clone the repository:
   ```bash
   git clone [https://github.com/umang48/kid-routine-tracker.git](https://github.com/umang48/kid-routine-tracker.git)
   cd kid-routine-tracker