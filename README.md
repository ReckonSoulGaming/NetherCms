# NetherCMS 🧱🔥
NetherCMS is an open-source Minecraft CMS for modern servers. It lets you manage stores, packages, and in-game commands using a secure plugin system.

⚠️ This project is currently in early development and is not yet production-ready.

## ✨ Features
- Highly customizable Laravel-based Minecraft CMS
- Combined **Store + Forum** system in one platform
- Separate and secure **User** and **Admin** panels
- Built-in **Razorpay** support (Indian payment gateway)  
  *(More gateways planned)*
- Clean and modern **Nether-themed UI**
- Easy-to-use admin dashboard
- Built-in community forum for discussions and announcements
- Forum categories, topics, and replies support
- Admin moderation tools for forum management
- Admin can:
  - Add and manage servers 🖥️
  - Create, edit, and delete store packages 📦
  - Set package images, names, descriptions, and prices 💰
  - Manage users and content 👥
- Users can:
  - Register and manage their profile 👤
  - Purchase packages from the store 🛒
  - Claim purchased packages from their panel 🎁
  - View purchase and claim history 📜
- Package claim system designed for Minecraft server delivery
- Minecraft server integration via **NetherCMS Plugin** *(Coming Soon)* 🔌

## 🧰 Requirements
- PHP 8.1 or higher
- Composer
- MySQL / MariaDB

## 🚀 Installation (Developer Preview)
1. Clone this repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Configure database credentials in `.env`
5. Run `php artisan key:generate`
6. Run `php artisan migrate`

## 📝 To-Do
- [ ] Core CMS structure stabilization
- [ ] User authentication & roles
- [ ] Admin dashboard improvements
- [ ] Minor cleanup & refactoring
- [ ] Web-based installer
- [ ] Documentation & usage guide

## 🚧 Status
Work in progress. Features, structure, and functionality may change at any time.

## 🤝 Contributing
This project is in an early stage. Feedback and suggestions are welcome.

## 📄 License
MIT License
