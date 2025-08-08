<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class HelloWorld extends AbstractCommand
{
    // TODO: エイリアスを設定してください。
    protected static ?string $alias = '{INSERT COMMAND HERE}';

    // TODO: 引数を設定してください。
    public static function getArguments(): array
    {
        return [];
    }

    // TODO: 実行コードを記述してください。
    public function execute(): int
    {
        $this->log("Executing HelloWorld...");
        return 0;
    }
}
