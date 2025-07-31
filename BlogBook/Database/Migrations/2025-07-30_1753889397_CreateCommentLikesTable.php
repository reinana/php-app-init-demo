<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCommentLikesTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE commentlikes (
                userId BIGINT NOT NULL,
                commentId BIGINT NOT NULL,
                FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE,
                FOREIGN KEY (commentId) REFERENCES comments(commentId) ON DELETE CASCADE,
                PRIMARY KEY (userId, commentId)
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE commentlikes"
        ];
    }
}