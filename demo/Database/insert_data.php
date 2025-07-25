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

function insertCarQuery(
    string $make,
    string $model,
    int $year,
    string $color,
    float $price,
    float $mileage,
    string $transmission,
    string $engine,
    string $status
): string {
    return sprintf(
        "INSERT INTO cars (make, model, year, color, price, mileage, transmission, engine, status)
        VALUES ('%s', '%s', %d, '%s', %f, %f, '%s', '%s', '%s');",
        $make, $model, $year, $color, $price, $mileage, $transmission, $engine, $status
    );
}

function insertPartQuery(
    string $name,
    string $description,
    float $price,
    int $quantityInStock
): string {
    return sprintf(
        "INSERT INTO Part (name, description, price, quantityInStock)
        VALUES ('%s', '%s', %f, %d);",
        $name, $description, $price, $quantityInStock
    );
}

function runQuery(mysqli $mysqli, string $query): void {
    $result = $mysqli->query($query);
    if ($result === false) {
        throw new Exception('Could not execute query.');
    } else {
        echo "Query executed successfully.\n";
    }
}

// 実際のデータ挿入
runQuery($mysqli, insertCarQuery(
    make: 'Toyota',
    model: 'Corolla',
    year: 2020,
    color: 'Blue',
    price: 20000,
    mileage: 1500,
    transmission: 'Automatic',
    engine: 'Gasoline',
    status: 'Available'
));

runQuery($mysqli, insertPartQuery(
    name: 'Brake Pad',
    description: 'High Quality Brake Pad',
    price: 45.99,
    quantityInStock: 100
));

$mysqli->close();
