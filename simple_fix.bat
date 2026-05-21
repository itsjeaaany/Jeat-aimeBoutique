@echo off
cd /d "c:\Users\itsjeaaany\Desktop\laravel\AnneProject"

echo Fixing orders...

REM Execute SQLite commands
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 14 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 14);"
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 15 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 15);"
sqlite3 database.sqlite "DELETE FROM order_items WHERE order_id = 17 AND id NOT IN (SELECT MAX(id) FROM order_items WHERE order_id = 17);"
sqlite3 database.sqlite "UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17);"

echo Done!
pause
