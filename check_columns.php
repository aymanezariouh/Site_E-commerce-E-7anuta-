<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Database: " . DB::connection()->getDatabaseName() . "\n\n";
echo "Columns in products table:\n";
echo "----------------------------\n";

$columns = DB::select('DESCRIBE products');
foreach($columns as $col) {
    echo $col->Field . " - " . $col->Type . "\n";
}
