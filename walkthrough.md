# Walkthrough - Personal Carbon Footprint Tracker

## Setup Instructions

1.  **Start your Local Web Server**: Ensure you have PHP and MySQL running (e.g., using XAMPP, MAMP, or `php -S`).
2.  **Database Info**:
    - Create a database named `carbon_tracker`.
    - Import the schema from `database/schema.sql`.
    - Update `config/db.php` if your MySQL username/password differs from `root`/` `(empty).

## Verification Steps

### 1. Registration & Login
- Open `http://localhost:8000/public/index.php` (adjust port if needed).
- Click "Register here".
- Create a user (e.g., `testuser`, `test@example.com`, `password`).
- You should be redirected to Login.
- Log in with the new credentials.

### 2. Dashboard
- Upon login, you see the Dashboard.
- Initial Values: "Total Emissions" should be **0.00**, "Activities Logged" **0**.

### 3. Log Activity
- Click "Log Activity" in the navbar.
- **Test Case 1 (Transport)**:
    - Date: Today
    - Type: `Transport - Car`
    - Value: `100` (km)
    - Click "Log Activity".
- **Test Case 2 (Food)**:
    - Date: Today
    - Type: `Food - Meat Meal`
    - Value: `1` (kg)
    - Click "Log Activity".

### 4. Verify Calculations
- **Dashboard**:
    - Car (100km * 0.19) = 19.00 kg
    - Meat (1kg * 27.0) = 27.00 kg
    - **Total Emissions** should be **46.00 kg**.
    - **Activities Logged** should be **2**.
- **Recent Activities** table on Dashboard should show both entries.

### 5. History & Deletion
- Go to "History".
- You should see the table of activities.
- Click "Delete" on the Meat Meal entry.
- Confirm the dialog.
- The entry should disappear.
- Go back to Dashboard. Total should now be **19.00 kg**.

### 6. Analytics
- Go to "Analytics".
- **Emissions Over Time**: You should see a data point for "Today".
- **Emissions by Category**: You should see a pie chart segment for "Transport" (and "Food" if not deleted).
