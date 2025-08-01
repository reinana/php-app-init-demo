<?php 

namespace Commands\Programs;
use Commands\AbstractCommand;
use Commands\Argument;
use Database\MySQLWrapper;

class StateMigrate extends AbstractCommand
{
    protected static ?string $alias = 'state-migrate';

    public static function getArguments(): array
    {
        return [
            (new Argument('init'))
                ->description('Initialize the state migration process')
                ->required(true),
        ];
    }


    // これが司令塔です。--initオプションがあることを確認した後、cleanDatabase()を呼び出してデータベースを空にし、
    // 次にstate.phpを読み込んで、テーブルごとにstateToSchema()を呼び出します。
    public function execute(): int
    {
        $this->log("Starting state migration...");
        // データベース全体をｸﾘｰﾝｱｯﾌﾟします。
        $this->cleanDatabase();

        $desiredSchema = include('./Dtabase/state.php');

        foreach ($desiredSchema as $table => $colums) {
            $this->StateToSchema($table, $colums);
        }

        $this->log("State migration completed successfully.");
        return 0;
    }

    public function cleanDatabase(): void
    {
        $mysqli = new MySQLWrapper();
        
        $mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
        $result = $mysqli->query("SHOW TABLES");
        while ($row = $result->fetch_row()) {
            $table = $row[0];
            $this->log("Dropping table: $table");
            $mysqli->query("DROP TABLE IF EXISTS `$table`");
        }

        $mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function stateToSchema(string $table, array $columns): void
    {
        $mysqli = new MySQLWrapper();
        $columnDefinitions = [];
        $keys = [];

        foreach ($columns as $columnName => $columnProps) {
            $definition = "`$columnName` " . $columnProps['type'];

            if (isset($columnProps['con']))
        }


    }


}





?>