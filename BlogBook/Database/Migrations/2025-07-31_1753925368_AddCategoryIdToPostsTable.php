<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class AddCategoryIdToPostsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE posts 
                ADD COLUMN categoryId BIGINT NOT NULL,
                ADD CONSTRAINT fk_posts_categories
                    FOREIGN KEY (categoryId) REFERENCES categories(categoryId) ON DELETE CASCADE"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE posts 
                DROP FOREIGN KEY fk_posts_categories,
                DROP COLUMN categoryId"
        ];
    }
}