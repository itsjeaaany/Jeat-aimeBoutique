@echo off
setlocal enabledelayedexpansion
cd /d "c:\Users\itsjeaaany\Desktop\laravel\AnneProject"

echo Fixing duplicate order items...
echo.

REM Create SQL file
(
  echo DELETE FROM order_items WHERE order_id = 14 AND id NOT IN ^(SELECT MAX^(id^) FROM order_items WHERE order_id = 14^);
  echo DELETE FROM order_items WHERE order_id = 15 AND id NOT IN ^(SELECT MAX^(id^) FROM order_items WHERE order_id = 15^);
  echo DELETE FROM order_items WHERE order_id = 17 AND id NOT IN ^(SELECT MAX^(id^) FROM order_items WHERE order_id = 17^);
  echo UPDATE orders SET total = 4000.00 WHERE id IN ^(14, 15, 17^);
) > fix_orders.sql

sqlite3 database.sqlite < fix_orders.sql

echo.
echo Verification - Remaining items in orders 14, 15, 17:
sqlite3 database.sqlite "SELECT order_id, COUNT(*) as item_count FROM order_items WHERE order_id IN (14, 15, 17) GROUP BY order_id;"

echo.
echo Order totals:
sqlite3 database.sqlite "SELECT id, total FROM orders WHERE id IN (14, 15, 17);"

echo.
echo Complete!
pause
