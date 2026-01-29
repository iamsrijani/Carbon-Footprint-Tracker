# Implementation Plan - Personal Carbon Footprint Tracker

Build a full-stack web application to track personal carbon footprints using PHP, MySQL, and Bootstrap.

## User Review Required
> [!IMPORTANT]
> This application requires a MySQL database. Please ensure MySQL is installed and running, and update `config/db.php` with your database credentials.

## Proposed Changes

### Database Layer
#### [NEW] [schema.sql](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/database/schema.sql)
- Defines `USERS` and `CARBON_ACTIVITIES` tables.

### Application Logic (Backend)
#### [NEW] [db.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/config/db.php)
- Database connection using PDO.
#### [NEW] [Auth.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/src/Auth.php)
- Handles user registration, login, and session management.
#### [NEW] [CarbonCalculator.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/src/CarbonCalculator.php)
- Logic for calculating emissions based on activity type.
#### [NEW] [ActivityManager.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/src/ActivityManager.php)
- CRUD operations for activity logs.

### Presentation Layer (Frontend)
#### [NEW] [index.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/index.php)
- Landing page with Login form.
#### [NEW] [register.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/register.php)
- User registration page.
#### [NEW] [dashboard.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/dashboard.php)
- Main user hub showing summary stats.
#### [NEW] [add_activity.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/add_activity.php)
- Form to log new activities.
#### [NEW] [history.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/history.php)
- Tabular view of past activities.
#### [NEW] [analytics.php](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/analytics.php)
- Visualizations using Chart.js.
#### [NEW] [styles.css](file:///Users/srijanimitra/.gemini/antigravity/scratch/carbon_footprint_tracker/public/css/styles.css)
- Custom styles overriding/extending Bootstrap.

## Verification Plan
### Automated Tests
- Since this is a simple PHP app, we will focus on manual verification.
### Manual Verification
1. **Setup**: Run `schema.sql` in MySQL.
2. **Auth**: Register a new user, log out, and log back in.
3. **Core Flow**:
   - Add a "Transport" activity (e.g., 10km car ride).
   - Verify calculation logic (should appear in DB with correct emission).
   - Check Dashboard for updated total.
   - View History to see the record.
   - Check Analytics for the chart update.
