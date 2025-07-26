# PHPから手動でスキーマを作成する手順まとめ

1. .envファイルにMySQL接続情報を保存
2. Helpers/Settings.phpに接続情報を読み込む処理を記述
3. Database/MySQLWrapper.phpで接続をラップする
4. エラーハンドリングをException
5. Database/setup.phpにスキーマ定義クエリを記述
6. init-app.phpをエントリーポイントにしてsetup.phpを呼び出す --migrateオプション