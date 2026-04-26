# Create Admin User - YanKicks Dashboard

This guide shows you how to create an admin user that can access the YanKicks admin dashboard.

## Option 1: Using SQL Script (Fastest)

### For Quick Setup with Default Admin:

1. Execute the `create_admin_user.sql` script:

**Via MySQL Command Line:**
```bash
mysql -u if0_41537934 -p if0_41537934_yankicks < create_admin_user.sql
```

**Via phpMyAdmin:**
- Upload/import `create_admin_user.sql` file
- Or copy-paste the SQL commands into the SQL tab

**Default Admin Credentials:**
- **Email:** admin@yankicks.com
- **Password:** YanKicks123!

### After Creation:
1. Navigate to: http://localhost/YanKicks_Improved/login-register.php
2. Click "Sign In"
3. Enter the admin email and password
4. You'll be redirected to the admin dashboard

---

## Option 2: Using PHP Utility Script (More Flexible)

This tool allows you to create multiple admins or promote existing users to admin.

### Web Interface Method:

1. Access the utility in your browser:
   ```
   http://localhost:8000/create_admin_utility.php
   ```

2. Choose from three options:
   - **Create Admin:** Create a brand new admin user
   - **Promote User:** Convert an existing regular user to admin
   - **View Admins:** See all current admin users

3. Fill in the required information and submit

### CLI Method (Command Line):

```bash
php create_admin_utility.php
```

Then follow the interactive prompts to:
- Create a new admin user
- Make an existing user an admin
- View all admins
- Exit

---

## How Admin Access Works

The system checks:
1. User must be logged in (session exists)
2. User's role must be `'admin'` in the database
3. User is not banned

The admin dashboard automatically redirects non-admin users to the login page.

---

## Admin Dashboard Features

Once logged in as admin, you can:

- **Overview:** View sales analytics, revenue, and statistics
- **Manage Products:** Add, edit, delete products
- **Manage Users:** View users, ban/unban accounts
- **Manage Orders:** Track and update order status
- **Product Categories:** View product distribution by category

---

## Changing Admin Password

If you need to change the admin password after creation:

### Method 1: Using the PHP Utility
1. Access `create_admin_utility.php` in web browser
2. Log in with current credentials
3. Create a new admin user with different credentials

### Method 2: Direct Database Update
```sql
UPDATE users SET password = PASSWORD('new_password_here') 
WHERE email = 'admin@yankicks.com';
```

### Method 3: Using PHP Password Hashing
```php
<?php
$new_password = 'YourNewPassword123!';
$hashed = password_hash($new_password, PASSWORD_DEFAULT);
echo $hashed; // Copy this and use in SQL UPDATE
?>
```

---

## Security Notes

⚠️ **Important:**
- Never share admin credentials with unauthorized users
- Change the default admin password immediately after first login
- Use strong passwords (mix of uppercase, lowercase, numbers, symbols)
- The system uses bcrypt hashing for password security
- Passwords with `password_hash()` are one-way encrypted

---

## Troubleshooting

**Problem:** "Email already exists" error
- **Solution:** Use a different email address

**Problem:** Can't log in after creating admin
- **Solution:** Double-check email and password are correct

**Problem:** Can't access admin dashboard
- **Solution:** Make sure user role is set to 'admin' in the database

**Problem:** SQL script won't execute
- **Solution:** Make sure you have:
  - Connected to the correct database (`yankicks`)
  - Proper database credentials
  - MySQL/MariaDB running

---

## Database Reference

Admin users are stored in the `users` table with:
- `role` = 'admin'
- `password` = bcrypt hashed password
- `banned_until` = NULL (not banned)

Example query to verify admin exists:
```sql
SELECT id, full_name, email, role FROM users WHERE role = 'admin';
```
