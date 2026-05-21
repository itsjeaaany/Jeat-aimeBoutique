@echo off
setlocal
cd /d "C:\Users\itsjeaaany\Desktop\laravel\AnneProject"

REM Save this as run_fix.bat and double-click it to run

echo.
echo ====================================
echo  ORDER DUPLICATE FIX SCRIPT
echo ====================================
echo.

REM Check if database file exists
if not exist database.sqlite (
    echo ERROR: database.sqlite not found!
    pause
    exit /b 1
)

echo Step 1: Checking current order items...
echo.
sqlite3 database.sqlite ".mode column" "SELECT oi.id as ItemID, oi.order_id as OrderID, oi.size as Size, oi.quantity as Qty, oi.price as Price FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id, oi.id;"

echo.
echo Step 2: Removing duplicate items (keeping only the last one)...
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 14 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 14);"
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 15 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 15);"
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 17 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 17);"

echo.
echo Step 3: Updating order totals to 4000.00...
sqlite3 database.sqlite "UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17);"

echo.
echo Step 4: Verifying the fix...
echo.
echo Remaining items:
sqlite3 database.sqlite ".mode column" "SELECT oi.id as ItemID, oi.order_id as OrderID, oi.size as Size, oi.quantity as Qty FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id;"

echo.
echo Order totals:
sqlite3 database.sqlite ".mode column" "SELECT id as OrderID, total as Total FROM orders WHERE id IN (14, 15, 17);"

echo.
echo ====================================
echo  COMPLETED!
echo ====================================
echo.
pause
