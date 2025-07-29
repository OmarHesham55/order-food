# Order-Food 🍽️

A Laravel-based restaurant ordering system that allows users to browse meals, add them to a cart, and place orders online. It includes an admin panel for managing restaurants, meals, categories, and user orders. The system uses AJAX and Laravel sessions for a smooth user experience.

---

## 🚀 Features

- 🧑‍🍳 Admin Dashboard for managing:
  - Restaurants
  - Meals
  - Categories
  - Orders

- 🛒 Authenticated User Experience:
  - Browse restaurants and meals
  - Add meals to cart (AJAX-based)
  - View and clear cart
  - Place orders and view order history

- 🔒 Secure Authentication using Laravel Breeze (or Jetstream, if used)
- 🖼 Image upload system for meals and restaurants
- 📦 Uses SessionStorage for cart operations
- ⚡ AJAX-powered interactions for smooth UX

---

## 📦 Installation

```bash
git clone https://github.com/yourusername/order-food.git
cd order-food
composer install
cp .env.example .env
php artisan migrate
php artisan serve
