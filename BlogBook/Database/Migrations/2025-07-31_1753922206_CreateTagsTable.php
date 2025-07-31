<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateTagsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE tags (
                tagId BIGINT PRIMARY KEY AUTO_INCREMENT,
                tag_name VARCHAR(255) NOT NULL UNIQUE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE tags"
        ];
    }
}