
# Cuisine Website

A modern web application for discovering, sharing, and managing recipes. Built with Laravel, JavaScript, SCSS, and more.

## Table of Contents

- [About](#about)
- [Features](#features)
- [Demo](#demo)
- [Screenshots](#screenshots)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

---

## About

**Cuisine Website** is a web application designed to help users find, share, and manage recipes from various cuisines around the world. It provides a user-friendly interface for browsing recipes, adding favorites, and sharing your own creations.

## Features

- User authentication & profiles
- Browse and search recipes by category
- Add, edit, and delete your own recipes
- Favorite and rate recipes
- Responsive design for mobile and desktop

## Demo

[Live Demo Link](#) <!-- Add the link if available -->

## Screenshots

<!-- Include images/screenshots of your app here -->
![Home Page](screenshots/home.png)
![Recipe Detail](screenshots/recipe-detail.png)

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** JavaScript, HTML, CSS, SCSS
- **Database:** MySQL (or specify your DB)
- **Other:** Blade templates, Bootstrap, etc.

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/farhanfahrezyy/cuisine-website.git
   cd cuisine-website
   ```
2. Install dependencies:
   ```
   composer install
   npm install
   ```
3. Configure environment:
   - Copy `.env.example` to `.env` and update credentials.
   - Generate app key:
     ```
     php artisan key:generate
     ```
4. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```
5. Build assets:
   ```
   npm run dev
   ```
6. Start the development server:
   ```
   php artisan serve
   ```

## Usage

- Register or log in to your account.
- Browse or search recipes.
- Add, edit, or delete your own recipes.
- Favorite recipes you like.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request. For major changes, open an issue first to discuss what you would like to change.

See [CONTRIBUTING.md](CONTRIBUTING.md) for more information.

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for more information.

---

Let me know if you want more sections or if you’d like me to tailor this further for your project specifics!
