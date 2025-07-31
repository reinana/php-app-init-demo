<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSubscriptionsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE subscriptions (
                subscriptionId INT PRIMARY KEY AUTO_INCREMENT,
                subscription VARCHAR(255),
                subscription_status VARCHAR(255),
                subscriptionCreatedAt DATETIME,
                subscriptionEndsAt DATETIME,
                userId BIGINT NOT NULL,
                CONSTRAINT fk_subscriptions_users
                    FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE subscriptions"
        ];
    }
}
