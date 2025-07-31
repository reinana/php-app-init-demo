<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCategoriesTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE categories (
                categoryId BIGINT PRIMARY KEY AUTO_INCREMENT,
                category_name VARCHAR(255) NOT NULL UNIQUE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE categories"
        ];
    }
}