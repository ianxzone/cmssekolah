<?php
require __DIR__ . "/vendor/autoload.php";
$app = require_once __DIR__ . "/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $f = new \App\Models\Facility(["title"=>"A","image"=>null, "desc"=>null, "icon"=>"check", "category"=>"class"]);
    $settings = [];
    $dbFacilities = collect([$f]);
    $html = view("frontend.fasilitas", compact("settings", "dbFacilities"))->render();
    echo "RENDER_SUCCESS";
} catch (\Throwable $e) {
    echo "ERROR_CAUGHT: " . $e->getMessage() . "\n" . $e->getFile() . ":" . $e->getLine();
}
