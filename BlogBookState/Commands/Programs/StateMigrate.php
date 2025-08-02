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

        $desiredSchema = include('./Database/state.php');

        foreach ($desiredSchema as $table => $columns) {
            $this->StateToSchema($table, $columns);
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
            $definition = "`$columnName` " . $columnProps['dataType'];

            if (isset($columnProps['constrains'])) {
                $definition .= " {$columnProps['constraints']}";
            }

            if(isset($columnProps['nullable']) && $columnProps['nullable'] === false) {
                $definition .= " NOT NULL";
            } 

            if(isset($columnProps['primaryKey']) && $columnProps['primaryKey'] === true) {
                $primaryKeysColumns[] = $columnName;
            }

            if(isset($columnProps['foreignKey'])) {
                $fk = $columnProps['foreignKey'];
                $onDelete = isset($fk['onDelete']) ? " ON DELETE {$fk['onDelete']}" : '';
                $keys[] = "FOREIGN KEY (`$columnName`) REFERENCES `{$fk['referenceTable']}`(`{$fk['referenceColumn']}`)$onDelete";
            }
            $columnDefinitions[] = $definition;
        }

        if (count($primaryKeysColumns) > 0) {
            $keys[] = "PRIMARY KEY (`" . implode('`, `', $primaryKeysColumns) . "`)";
        }

        $columnSQL = implode(", ", $columnDefinitions);
        $keysSQL = implode(", ", $keys);

        $createTableSQL = "CREATE TABLE IF NOT EXISTS `$table` ($columnSQL, $keysSQL)";

        $result = $mysqli->query($createTableSQL);
        if (!$result) {
            throw new \Exception("Failed to create table `$table`: " . $mysqli->error);
        }
        else {
            $this->log("Ensured table $table matches desired state.");
        }

    }


}





?>