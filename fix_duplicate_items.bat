@echo off
setlocal
cd /d "c:\Users\itsjeaaany\Desktop\laravel\AnneProject"

REM First, let's see what items are in orders 14, 15, 17
echo Checking current order items...
sqlite3 database.sqlite "SELECT oi.id, oi.order_id, oi.product_id, oi.quantity, oi.size, (oi.price * oi.quantity) as item_total FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id, oi.size;"

echo.
echo Deleting Size S and S items (keeping only L and M)...

REM For orders with multiple jacket sizes, keep only the latest size (the one that was placed for order)
REM Order 14 - Size M jacket, so delete Size S
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 14 AND size = 'S';"

REM Order 15 - Size L jacket, so delete other sizes if exist
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 15 AND size != 'L';"

REM Order 17 - Size L jacket
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 17 AND size != 'L';"

echo.
echo Verifying items after deletion...
sqlite3 database.sqlite "SELECT oi.id, oi.order_id, oi.product_id, oi.quantity, oi.size, (oi.price * oi.quantity) as item_total FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id;"

echo.
echo Updating order totals to 4000...
sqlite3 database.sqlite "UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17);"

echo.
echo Final order totals...
sqlite3 database.sqlite "SELECT id, total FROM orders WHERE id IN (14, 15, 17);"

echo.
echo Done! All duplicate items removed and totals fixed.
pause
