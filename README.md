# Admin Panel FLS Beaute

Admin Panel FLS Beaute is a website that provides an admin panel for FLS Beaute, specifically designed during an independent study internship at Deus Code. This admin panel is equipped with multi-user features, including roles for superadmin, distributor, and seller, allowing for efficient management of sales and products. With an intuitive interface, this admin panel supports effective management, ensuring that each user can perform their functions easily and in an organized manner.

## Tech Stack

- **Laravel 8**
- **MySQL Database**

## Features

- Main features available in this application:
  - Product Management
  - Account Management
  - Sales Management
  - Report Management
  - Notification
  - Product returns Management
  - Cash Opname

## Installation

Follow the steps below to clone and run the project in your local environment:

1. Clone repository:

    ```bash
    git clone https://github.com/Akbarwp/AdminPanel-FLS-Beaute.git
    ```

2. Install dependencies use Composer and NPM:

    ```bash
    composer install
    npm install
    ```

3. Copy file `.env.example` to `.env`:

    ```bash
    cp .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Setup database in the `.env` file:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run migration database:

    ```bash
    php artisan migrate
    ```
7. Run seeder database:

    ```bash
    php artisan db:seed
    ```

8. Run website:

    ```bash
    npm run watch
    php artisan serve
    ```

## Screenshot

- ### **Login page**

<img src="https://github.com/user-attachments/assets/0a000b0a-1850-4d2e-bb45-66eb66b36850" alt="Halaman Login" width="" />
<br><br>

- ### **Dashboard page**

<img src="https://github.com/user-attachments/assets/3b2e80a8-685a-49b8-beab-eead808ba9d2" alt="Halaman Dashboard" width="" />
&nbsp;&nbsp;&nbsp;
<img src="https://github.com/user-attachments/assets/54b04d97-41ba-4a13-b1e9-71025eea68ea" alt="Halaman Dashboard" width="" />
&nbsp;&nbsp;&nbsp;
<img src="https://github.com/user-attachments/assets/f03ac189-ce0b-474b-a2ff-65f3caf42e04" alt="Halaman Dashboard" width="" />
<br><br>
