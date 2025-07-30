# PHPから手動でスキーマを作成する手順まとめ

1. .envファイルにMySQL接続情報を保存
2. Helpers/Settings.phpに接続情報を読み込む処理を記述
3. Database/MySQLWrapper.phpで接続をラップする
4. エラーハンドリングをException
5. Database/setup.phpにスキーマ定義クエリを記述
6. init-app.phpをエントリーポイントにしてsetup.phpを呼び出す --migrateオプション


## code-gen：雛形ファイルを自動生成する
code-genは、新しい「コマンド」や「マイグレーション」の雛形ファイルを自動で作るためのコマンドです。

新しいマイグレーションファイルを作る

Bash

php console code-gen migration --name=ファイル名
例: php console code-gen migration --name=CreateUsersTable

新しいコマンドを作る

Bash

php console code-gen command --name=コマンド名
例: php console code-gen command --name=SendEmails

## migrate：データベースのバージョンを管理する
migrateは、データベースの構造を変更（進めたり、戻したり）するためのコマンドです。

マイグレーションシステムを初期化する（最初に1回だけ）

Bash

php console migrate --init
migrationsテーブルを作成します。

データベースを最新の状態に進める

Bash

php console migrate
まだ実行されていないマイグレーションを全て実行します。

直前の変更を元に戻す

Bash

php console migrate --rollback
最後に実行したマイグレーションを1つだけ取り消します。

指定した数だけ変更を元に戻す

Bash

php console migrate --rollback [回数]
例: php console migrate --rollback 3 （3つ前まで戻す）

## db-wipe：データベースを初期化する
db-wipeは、データベース内のテーブルを全て削除して空っぽにするコマンドです。

データベースを空にする

Bash

php console db-wipe
バックアップを取ってから空にする

Bash

php console db-wipe --backup
## book-search：本を検索する
book-searchは、本の情報を検索するためのコマンドです。

タイトルで検索する

Bash

php console book-search --title="本のタイトル"
ISBNで検索する

Bash

php console book-search --isbn="ISBN番号"
## 共通オプション
ヘルプを表示する

Bash

php console [コマンド名] --help
各コマンドの使い方や、利用できるオプションの一覧を確認できます。
例: php console migrate --help