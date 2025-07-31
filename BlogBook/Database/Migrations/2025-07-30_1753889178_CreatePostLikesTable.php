<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostLikesTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE postlikes (
                userId BIGINT NOT NULL,
                postId INT NOT NULL,
                CONSTRAINT fk_postlikes_users
                    FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE,
                CONSTRAINT fk_postlikes_posts
                    FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
                PRIMARY KEY (userId, postId)
            )"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE postlikes"
        ];
    }
}