<?php 
namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class DbWipe extends AbstractCommand
{
    // 使用するコマンド名を設定
    protected static ?string $alias = 'db-wipe';


    // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('backup'))
                ->description('create a backup before wiping the database')
                ->allowAsShort(true)
                ->required(false),
        ];
    }

    public function execute(): int
    {
        if ($this->getArgumentValue('backup') ) {
            $this->log('Creating a backup before wiping the database...');
        } 

        $this->log('Wiping the database...');
        // ここでデータベースを消去するロジックを実装
        $this->log('Database wiped successfully.');
        return 0;
    }
}
?>