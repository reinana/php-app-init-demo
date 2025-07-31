<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateTaxonomySystemTables implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE taxonomy (
                taxonomyId BIGINT PRIMARY KEY AUTO_INCREMENT,
                taxonomyName VARCHAR(255) NOT NULL
            )",
            "CREATE TABLE taxonomy_terms (
                taxonomyTermId BIGINT PRIMARY KEY AUTO_INCREMENT,
                taxonomyTermName VARCHAR(255) NOT NULL,
                taxonomyId BIGINT NOT NULL,
                CONSTRAINT fk_taxonomy_terms_taxonomy
                    FOREIGN KEY (taxonomyId) REFERENCES taxonomy(taxonomyId) ON DELETE CASCADE
            )",
            "CREATE TABLE post_taxonomy (
                postTaxonomyId BIGINT PRIMARY KEY AUTO_INCREMENT,
                postId INT NOT NULL,
                taxonomyTermId BIGINT NOT NULL,
                CONSTRAINT fk_post_taxonomy_posts
                    FOREIGN KEY (postId) REFERENCES posts(postId) ON DELETE CASCADE,
                CONSTRAINT fk_post_taxonomy_taxonomy_terms
                    FOREIGN KEY (taxonomyTermId) REFERENCES taxonomy_terms(taxonomyTermId) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE post_taxonomy",
            "DROP TABLE taxonomy_terms",
            "DROP TABLE taxonomy"
        ];
    }
}