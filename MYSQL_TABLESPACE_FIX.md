# MySQL Tablespace Fix Script

## Issue
MySQL has orphaned tablespace files preventing fresh migrations.

## Solution - Choose One Method:

### METHOD 1: Quick Fix (Most Reliable)
Open PowerShell and run:

```powershell
# Connect to MySQL and drop/recreate database
mysql -u root -e "DROP DATABASE IF EXISTS quiz1_pbp;"
mysql -u root -e "CREATE DATABASE quiz1_pbp;"

# Back to Laravel - run migrations
cd d:\quiz1_pbp
php artisan migrate:fresh --seed
```

### METHOD 2: Discard Tablespace (if you have data you want to preserve)
Open PowerShell as Administrator:

```powershell
# Connect to MySQL command line
mysql -u root

# Then run these SQL commands one by one:
```

```sql
-- In MySQL prompt:
USE quiz1_pbp;

-- List tables (should be empty or only have core tables)
SHOW TABLES;

-- Try to drop the migrations table if it exists
DROP TABLE IF EXISTS migrations;

-- Discard the tablespace if it exists
ALTER TABLE IF EXISTS migrations DISCARD TABLESPACE;

-- Exit MySQL
EXIT;
```

Then back in PowerShell:
```powershell
php artisan migrate:fresh --seed
```

### METHOD 3: Complete Fresh Start (Safest for development)
```powershell
# Stop Laravel server if running
# Clear cache and compiled files
cd d:\quiz1_pbp
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Delete vendor and reinstall dependencies
Remove-Item .\vendor -Recurse -Force
composer install

# Delete database and recreate
mysql -u root -e "DROP DATABASE IF EXISTS quiz1_pbp;"
mysql -u root -e "CREATE DATABASE quiz1_pbp;"

# Run migrations with seeding
php artisan migrate:fresh --seed
```

---

## Verify Success

After running one of the above methods, verify with:

```powershell
# Check migrations ran
php artisan migrate:status

# Check database has data
php artisan tinker

# In tinker prompt, run:
>>> \DB::table('users')->count()    # Should return 5
>>> \DB::table('simpanan')->count()
>>> \DB::table('tabungan')->count()
>>> \DB::table('pinjaman')->count()
>>> \DB::table('bayar_pinjaman')->count()
>>> exit
```

Expected results:
- users: 5
- simpanan: 10-20
- tabungan: 5
- pinjaman: 5-15
- bayar_pinjaman: 10-30

---

## If Still Having Issues

Check your `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quiz1_pbp
DB_USERNAME=root
DB_PASSWORD=(your mysql password)
```

Make sure values are correct, then try METHOD 3 again.

---

## Manual MySQL Check

Connect directly to MySQL to see the problematic database:

```powershell
mysql -u root
```

Then in MySQL:
```sql
-- Check if database exists
SHOW DATABASES;

-- Check tables in database
USE quiz1_pbp;
SHOW TABLES;

-- Check table status
SHOW TABLE STATUS;

-- Look for any tables with "InnoDB" in engine
```

If tables exist but are broken, drop them:
```sql
DROP DATABASE quiz1_pbp;
EXIT;
```

Then run Laravel migration:
```powershell
php artisan migrate:fresh --seed
```
