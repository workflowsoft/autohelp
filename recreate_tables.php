<?php

echo 'Recreation began' . PHP_EOL;
exec('mysql -u root -pmysql12345 < tables.sql');
echo 'Tables created, inserting data' . PHP_EOL;
exec('mysql -u root -pmysql12345 < data.sql');
echo 'Finished' . PHP_EOL;
