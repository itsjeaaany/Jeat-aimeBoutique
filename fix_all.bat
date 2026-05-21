@echo off
cd /d "c:\Users\itsjeaaany\Desktop\laravel\AnneProject"

REM Create a temporary SQL script
(
  echo -- Check current order items
  echo SELECT 'Order ' ^| ^| order_id ^| ^| ' has ' ^| ^| COUNT(*) ^| ^| ' items' FROM order_items WHERE order_id IN (14, 15, 17) GROUP BY order_id;
  echo.
  echo -- Delete duplicate items - keep only the last one added for each order
  echo DELETE FROM order_items WHERE order_id IN (14, 15, 17) AND id NOT IN (
  echo   SELECT MAX(id) FROM order_items WHERE order_id IN (14, 15, 17) GROUP BY order_id
  echo ^);
  echo.
  echo -- Update totals to 4000
  echo UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17^);
  echo.
  echo -- Verify results
  echo SELECT id, total FROM orders WHERE id IN (14, 15, 17^);
) > fix_orders.sql

echo Running SQLite commands...
sqlite3 database.sqlite < fix_orders.sql

echo.
echo Done! Verifying final order items...
sqlite3 database.sqlite "SELECT oi.id, oi.order_id, oi.product_id, oi.quantity, oi.size FROM order_items oi WHERE oi.order_id IN (14, 15, 17) ORDER BY oi.order_id;"

pause
