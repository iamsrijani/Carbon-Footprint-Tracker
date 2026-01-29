#!/bin/bash
echo "Starting MySQL..."
brew services start mysql
echo "Waiting for MySQL to initialize..."
sleep 5
echo "Importing Database Schema..."
mysql -u root < database/schema.sql
echo "Starting Carbon Tracker at http://localhost:8080..."
php -S localhost:8080 -t public
