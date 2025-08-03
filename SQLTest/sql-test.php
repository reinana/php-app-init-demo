<?php

// オートローダーを設定
spl_autoload_register(function($class) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        include $file;
    }
});

// --- ここからが課題の内容です ---

echo "Connecting to database...\n";
$mysqli = new \Database\MySQLWrapper();
echo "Connection successful.\n\n";

$mysqli->query("DROP TABLE IF EXISTS students");

// 1. studentsテーブルを作成する
echo "Creating 'students' table...\n";
$createTableQuery = "
    CREATE TABLE IF NOT EXISTS students (
      id INT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(100),
      age INT,
      major VARCHAR(50)
    )
";
$mysqli->query($createTableQuery);
echo "'students' table created successfully.\n\n";

// 2. 挿入する学生データの準備
$studentsData = [
    ['Alice', 20, 'Computer Science'],
    ['Bob', 22, 'Mathematics'],
    ['Charlie', 21, 'Physics'],
    ['David', 23, 'Chemistry'],
    ['Eve', 20, 'Biology'],
    ['Frank', 22, 'History'],
    ['Grace', 21, 'English Literature'],
    ['Hannah', 23, 'Art History'],
    ['Isaac', 20, 'Economics'],
    ['Jack', 24, 'Philosophy']
];

// 3. ループ処理でデータを一件ずつ挿入する
echo "Inserting student data...\n";
foreach ($studentsData as $student) {
    // INSERT文を組み立てる
    $insertQuery = "INSERT INTO students (name, age, major) VALUES ('{$student[0]}', {$student[1]}, '{$student[2]}')";
    
    // SQLを実行する
    $mysqli->query($insertQuery);
    echo "Inserted: {$student[0]}\n";
}
echo "\nAll data inserted successfully!\n";

$selectQuery = "SELECT * FROM students";
$result = $mysqli->query($selectQuery);

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Age: " . $row['age'] . ", Major: " . $row['major'] . "\n";
}
// ↓ この1行を追加して、結果を最初から読み直せるようにする
$result->data_seek(0); 

$allRows = $result->fetch_all(MYSQLI_BOTH);
foreach ($allRows as $row) {
    echo $row['name'] . ' is studying ' . $row['major'] . "\n";
}


$updates = [
    ['Alice', 'Physics'],
    ['Bob', 'Art History'],
    ['Charlie', 'Philosophy'],
    ['David', 'Economics']
];

foreach ($updates as $update) {
    $updateQuery = "UPDATE students SET major='$update[1]' WHERE name='$update[0]'";
    $mysqli->query($updateQuery);
}

// 更新されたレコードを表示します
$selectQuery = "SELECT * FROM students";
$result = $mysqli->query($selectQuery);
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Age: " . $row['age'] . ", Major: " . $row['major'] . "\n";
}



$studentsToDelete = ['Alice', 'Bob', 'Charlie'];

foreach ($studentsToDelete as $studentName) {
    $deleteQuery = "DELETE FROM students WHERE name='$studentName'";
    $mysqli->query($deleteQuery);
}

// 残りのレコードを表示します
$selectQuery = "SELECT * FROM students";
$result = $mysqli->query($selectQuery);
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Age: " . $row['age'] . ", Major: " . $row['major'] . "\n";
}