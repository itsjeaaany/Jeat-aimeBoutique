@echo off
setlocal
cd /d "c:\Users\itsjeaaany\Desktop\laravel\AnneProject"

REM Use SQLite to update orders - orders #14, #15, #17 should be 4000 instead of 8000
sqlite3 database.sqlite "UPDATE orders SET total = 4000.00 WHERE id IN (14, 15, 17);"

echo Done! Orders #14, #15, #17 have been updated to 4000.00

sqlite3 database.sqlite "SELECT id, total FROM orders WHERE id IN (14, 15, 17);"

pause
