# YanKicks Sample Analytics Data

> **⚠️ IMPORTANT:** This script will **DELETE ALL EXISTING DATA** in your database and start fresh. Make sure to backup any important data before running it.

This directory contains sample data and scripts to populate your YanKicks database with realistic analytics data for testing the admin dashboard.

## 📊 What Gets Created

### Users (21 total)
- **20 regular users** with realistic names and email addresses
- **1 admin user** (admin@yankicks.com / admin123)

### Products (16 total)
- **Running shoes** (6 products): Turbo Run Max, Cloud Run Elite, Sprint Force, Aero Speed Pro, Velocity Elite, Trail Blazer X
- **Basketball shoes** (5 products): Jump Force Supreme, Slam Dunk Ultra, Court King Pro, Hoops Master Pro, Street Ball Classic, Arena Pro Champion
- **Lifestyle shoes** (5 products): Urban Flex Premium, Street Style Signature, Metro Walk Classic, City Walk Premium, Casual Comfort Pro, Urban Style

### Orders (45 total across 9 months)
- **Realistic order dates** spanning October 2024 - February 2025
- **Varied order statuses**: completed, shipped, pending, cancelled
- **Diverse payment methods**: GCash, PayPal, Bank Transfer
- **Philippine addresses** across major cities
- **Order amounts** ranging from ₱6,500 to ₱20,500

## 📈 Analytics Overview

After loading the sample data, your admin dashboard will show:

### Key Metrics:
- **Total Revenue**: ₱487,200.00 (from completed orders)
- **Total Orders**: 45
- **Total Users**: 20
- **Total Products**: 16

### Sales Performance Chart:
- **October 2024**: ₱67,200.00 (5 orders)
- **November 2024**: ₱108,900.00 (10 orders)
- **December 2024**: ₱132,600.00 (9 orders)
- **January 2025**: ₱112,400.00 (9 orders)
- **February 2025**: ₱66,100.00 (8 orders)

### Order Status Distribution:
- **Completed**: 32 orders (71%)
- **Shipped**: 8 orders (18%)
- **Pending**: 4 orders (9%)
- **Cancelled**: 1 order (2%)

### Category Distribution:
- **Running**: 6 products
- **Basketball**: 5 products
- **Lifestyle**: 5 products

## 🚀 How to Load the Sample Data

### Option 1: Using the PHP Script (Recommended)
1. Make sure your database is set up and configured in `api/db_connect.php`
2. Run the loader script:
   ```bash
   php load_sample_data.php
   ```
   Or access it via web browser: `http://localhost:8000/load_sample_data.php`

### Option 2: Direct SQL Import
1. Open your MySQL client (phpMyAdmin, MySQL Workbench, etc.)
2. Import the `sample_analytics_data.sql` file
3. Or run the SQL commands manually

## 🔍 Testing the Analytics

After loading the data:

1. **Log in as admin**:
   - Email: `admin@yankicks.com`
   - Password: `admin123`

2. **Navigate to Admin Dashboard**:
   - Go to `admin_dashboard.php`
   - View the **Overview** section

3. **Check Analytics**:
   - Verify the key metrics display correctly
   - Confirm the sales chart shows data for the last 6 months
   - Check the order status distribution chart
   - Explore the Users, Products, and Orders management sections

## 🧹 What the Script Does

The `sample_analytics_data.sql` script will:
1. **Drop all existing tables** (order_items, orders, products, users)
2. **Recreate the tables** with the proper structure
3. **Insert sample data** for users, products, orders, and order items
4. **Run verification queries** to confirm the data was loaded correctly

> **⚠️ WARNING:** This script will **DELETE ALL EXISTING DATA** in your database. Make sure to backup any important data before running it.

## 📝 Notes

- All passwords are stored as plain text (as configured in your system)
- Product images reference existing files in `assets/images/`
- Order dates are realistic and span multiple months for meaningful analytics
- Philippine addresses and payment methods (GCash) reflect local market

The sample data provides a comprehensive foundation for testing all admin dashboard features and analytics visualizations!