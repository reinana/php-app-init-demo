<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class AddSubscriptionFieldsToUsersTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE users
                ADD COLUMN subscription VARCHAR(255) NULL, 
                ADD COLUMN subscriptionStatus VARCHAR(50) NOT NULL DEFAULT 'inactive',
                ADD COLUMN subscriptionCreateAt DATETIME NULL,
                ADD COLUMN subscriptionEndsAt DATETIME NULL"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE users
                DROP COLUMN subscription,
                DROP COLUMN subscriptionStatus,
                DROP COLUMN subscriptionCreateAt,
                DROP COLUMN subscriptionEndsAt"
        ];
    }
}