<?php
spl_autoload_extensions(".php");
spl_autoload_register(function($class) {
    $file = __DIR__ . '/'  . str_replace('\\', '/', $class). '.php';
    if (file_exists(stream_resolve_include_path($file))) {
        include($file);
    }
});


use Database\MySQLWrapper;
require_once __DIR__ . '/MySQLWrapper.php'; // ← 必要な場合は読み込み
require_once __DIR__ . '/../Helpers/Settings.php';
$mysqli = new MySQLWrapper();

$queries = [

    // makes テーブル
    "CREATE TABLE IF NOT EXISTS makes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL
    );",

    // models テーブル
    "CREATE TABLE IF NOT EXISTS models (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        make_id INT NOT NULL,
        FOREIGN KEY (make_id) REFERENCES makes(id)
    );",

    // cars テーブル（外部キー参照に）
    "CREATE TABLE IF NOT EXISTS cars (
        id INT PRIMARY KEY AUTO_INCREMENT,
        model_id INT NOT NULL,
        year INT,
        color VARCHAR(20),
        price FLOAT,
        mileage FLOAT,
        transmission VARCHAR(20),
        engine VARCHAR(20),
        status VARCHAR(10),
        FOREIGN KEY (model_id) REFERENCES models(id)
    );"
];

foreach ($queries as $query) {
    $result = $mysqli->query($query);
    if (!$result) {
        throw new \Exception("Failed to execute query: $query");
    }
}

echo "✅ setup_v2.php completed successfully.\n";
