<?php

spl_autoload_extensions(".php");
spl_autoload_register(function($class) {
    $file = __DIR__ . '/'  . str_replace('\\', '/', $class). '.php';
    if (file_exists(stream_resolve_include_path($file))) include($file);
});

use Database\MySQLWrapper;

// --migrate オプションが指定されたときだけ setup.php を実行
$opts = getopt('', ['migrate', 'migrate-v2']);
if (isset($opts['migrate'])) {
    echo "Database migration enabled." . PHP_EOL;
    include('Database/setup.php');
    echo "Database migration ended." . PHP_EOL;
}
if (isset($opts['migrate-v2'])) {
    echo "Database migration enabled." . PHP_EOL;
    include('Database/setup_v2.php');
    echo "Database migration ended." . PHP_EOL;
}

// 通常の接続確認処理
$mysqli = new MySQLWrapper();
$charset = $mysqli->get_charset();
if ($charset === null) throw new Exception('Charset could be read');

printf(
    "%s's charset: %s.%s",
    $mysqli->getDatabaseName(),
    $charset->charset,
    PHP_EOL
);
printf(
    "collation: %s.%s",
    $charset->collation,
    PHP_EOL
);

$mysqli->close();
