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
                CONSTRAINT fk_posttags_posts
                    FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
                CONSTRAINT fk_posttags_tags
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