<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateUserSettingsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE usersettings (
                entityId BIGINT PRIMARY KEY AUTO_INCREMENT,
                userId BIGINT NOT NULL,
                metakey VARCHAR(255) NOT NULL,
                metaValue TEXT NOT NULL,
                FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE

            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE usersettings"
        ];
    }
}