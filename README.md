# MyPasswords

MyPasswords is a password management application that allows users to securely store their encrypted passwords.

## Features

- Secure storage of encrypted passwords
- Addition, updating, and deletion of passwords
- Viewing all stored passwords

## Technologies Used

- Laravel
- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Installation

1. Clone the repository:
 
   ```bash
   git clone https://github.com/your-username/MyPasswords.git
2. Install dependencies:
  
   ```bash
   cd MyPasswords
   composer install
   npm install
3. Copy the .env.example file to .env and configure the database:
    
    ```bash
    cp .env.example .env
4. Generate the application key:
    
    ```bash
    php artisan key:generate
5. Run database migrations to create necessary tables:

    ```bash
    php artisan migrate
6. Start the development server:
   
   ```bash
   php artisan serve
   npm run dev
Access the aplication at http://localhost:8000.

## Contribution

Contributions are welcome! Feel free to open an issue or submit a pull request. Keep in mind that I'm still learning the basics.

## License

This project is licensed under the MIT License.

