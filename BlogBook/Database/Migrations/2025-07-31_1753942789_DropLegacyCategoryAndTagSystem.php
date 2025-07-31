<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class DropLegacyCategoryAndTagSystem implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
        "ALTER TABLE posts DROP FOREIGN KEY fk_posts_categories",
        "ALTER TABLE posts DROP COLUMN categoryId",
        "DROP TABLE IF EXISTS posttags",
        "DROP TABLE IF EXISTS tags",
        "DROP TABLE IF EXISTS categories"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "CREATE TABLE categories (
                categoryId BIGINT PRIMARY KEY AUTO_INCREMENT,
                categoryName VARCHAR(255) NOT NULL
            )",
            "CREATE TABLE tags (
                tagId BIGINT PRIMARY KEY AUTO_INCREMENT,
                tagName VARCHAR(255) NOT NULL
            )",
            "CREATE TABLE post_tags (
                postId INT NOT NULL,
                tagId BIGINT NOT NULL,
                FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
                FOREIGN KEY (tagId) REFERENCES tags(tagId) ON DELETE CASCADE,
                PRIMARY KEY (postId, tagId)
            )",
            "ALTER TABLE posts 
                ADD COLUMN categoryId BIGINT NOT NULL,
                ADD FOREIGN KEY (categoryId) REFERENCES categories(categoryId) ON DELETE CASCADE"
        ];
    }
}