<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostTagsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE posttags (
                postId INT NOT NULL,
                tagId BIGINT NOT NULL,
                FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
                FOREIGN KEY (tagId) REFERENCES tags(tagId) ON DELETE CASCADE,
                PRIMARY KEY (postId, tagId)
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE posttags"
        ];
    }
}