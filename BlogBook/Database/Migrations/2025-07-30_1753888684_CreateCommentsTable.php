<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCommentsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください コメントテーブルを作る
        return ["CREATE TABLE comments (
                commentId BIGINT PRIMARY KEY AUTO_INCREMENT,
                commentText VARCHAR(255) NOT NULL,
                userId BIGINT NOT NULL,
                postId INT NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE
            )"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください コメントテーブルを消す
        return [
            "DROP TABLE comments"
        ];
    }
}