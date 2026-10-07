# Puihaha Electric Company - Combined CodeIgniter 4 Project

This project combines the customer-account management functionality from `electric_company` with the public website design from `demoElectric`.

## Main pages
- `/` Home
- `/about` About
- `/services` Services
- `/contact` Contact form
- `/register` Customer registration
- `/login` Staff login
- `/dashboard` Customer account management

## Database
Import `electric_company.sql` into phpMyAdmin. It creates the `electric_company` database plus the `user_accounts`, `users`, and `customer_accounts` tables.

Default staff login:
- Username: `admin`
- Password: `admin123`

## XAMPP
Place the extracted `electric_company` folder in `htdocs`, start Apache and MySQL, import the SQL file, then open:
`http://localhost/electric_company/`

The project is configured to use `http://localhost/electric_company/` as its base URL.
