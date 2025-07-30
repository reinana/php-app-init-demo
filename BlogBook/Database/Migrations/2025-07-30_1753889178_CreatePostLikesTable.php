<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostLikeTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE postlike (
                userId BIGINT NOT NULL,
                postId INT NOT NULL,
                FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE,
                PRIMARY KEY (userId, postId),
            )"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE postlike"
        ];
    }
}