@echo off
setlocal
cd /d "C:\Users\itsjeaaany\Desktop\laravel\AnneProject"

echo.
echo ====================================
echo  FIXING ORDER TOTALS IN DATABASE
echo ====================================
echo.

echo Current order_items (showing what you actually ordered):
sqlite3 database.sqlite ".mode column" "SELECT oi.id, oi.order_id, oi.product_id, oi.price, oi.quantity, (oi.price * oi.quantity) as actual_total, oi.size FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id;"

echo.
echo Current order totals (WRONG - showing 8000):
sqlite3 database.sqlite ".mode column" "SELECT id, total FROM orders WHERE id IN (14, 15, 17);"

echo.
echo Fixing... Setting order totals to match actual order items...
echo.

REM Update each order total by calculating from order_items
sqlite3 database.sqlite "UPDATE orders SET total = (SELECT SUM(price * quantity) FROM order_items WHERE order_id = 14) WHERE id = 14;"
sqlite3 database.sqlite "UPDATE orders SET total = (SELECT SUM(price * quantity) FROM order_items WHERE order_id = 15) WHERE id = 15;"
sqlite3 database.sqlite "UPDATE orders SET total = (SELECT SUM(price * quantity) FROM order_items WHERE order_id = 17) WHERE id = 17;"

echo.
echo FIXED! New order totals (should be 4000 each):
sqlite3 database.sqlite ".mode column" "SELECT id, total FROM orders WHERE id IN (14, 15, 17);"

echo.
echo ====================================
echo  COMPLETED!
echo ====================================
echo.
pause
