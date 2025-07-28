<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Exception;

class CodeGeneration extends AbstractCommand
{
    // コマンド名
    protected static ?string $alias = 'code-gen';
    // メインの値（migration や command）を必須にする
    protected static bool $requiredCommandValue = true;

    // このコマンドが受け付ける引数を定義
    public static function getArguments(): array
    {
        return [
            // 生成するファイル名を受け取るための 'name' オプションを追加
            (new Argument('name'))
                ->description('The name of the file to be generated.')
                ->required(false) // タイプによっては不要なため必須ではない
                ->allowAsShort(true), // -n でも可
        ];
    }

    // メインの処理
    public function execute(): int
    {
        // 'migration' や 'command' などの生成タイプを取得
        $generationType = $this->getCommandValue();

        switch ($generationType) {
            case 'command':
                // 新しいコマンドを生成する
                $commandName = $this->getArgumentValue('name');
                if (!$commandName || !is_string($commandName)) {
                    $this->log("Error: Please provide a name for the new command using --name=YourCommandName or -n YourCommandName");
                    return 1;
                }
                $this->generateCommandFile($commandName);
                $this->updateRegistry($commandName);
                break;

            case 'migration':
                // （将来的に）マイグレーションファイルを生成する処理
                $this->log('Simulating generation of migration file...');
                break;

            default:
                $this->log("Unknown generation type: " . $generationType);
                return 1;
        }

        return 0;
    }

    /**
     * 新しいコマンドの雛形ファイルを生成する
     * @param string $commandName 生成するコマンドのクラス名
     */
    private function generateCommandFile(string $commandName): void
    {
        $template = <<<'EOT'
<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class {COMMAND_NAME} extends AbstractCommand
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
        $this->log("Executing {COMMAND_NAME}...");
        return 0;
    }
}

EOT;
        // テンプレート内のプレースホルダーをクラス名に置換
        $fileContent = str_replace('{COMMAND_NAME}', $commandName, $template);
        $filePath = __DIR__ . '/' . $commandName . '.php';

        if (file_exists($filePath)) {
            $this->log("Error: Command file '{$commandName}.php' already exists.");
            return;
        }

        // ファイルを書き出す
        file_put_contents($filePath, $fileContent);
        $this->log("Successfully created command file: {$filePath}");
    }

    /**
     * registry.php に新しいコマンドを自動登録する
     * @param string $commandName 登録するコマンドのクラス名
     */
    private function updateRegistry(string $commandName): void
    {
        $registryPath = __DIR__ . '/../registry.php';
        
        // registry.php を読み込む
        $registryContent = file_get_contents($registryPath);
        
        // 新しいコマンドの完全なクラス名
        $newCommandEntry = "    Commands\\Programs\\{$commandName}::class,";

        // すでに登録されていないかチェック
        if (str_contains($registryContent, $newCommandEntry)) {
            $this->log("Command '{$commandName}' is already registered.");
            return;
        }

        // 配列の閉じ括弧 `];` の前に新しいエントリを挿入
        $newContent = preg_replace('/(];)/', $newCommandEntry . PHP_EOL . '$1', $registryContent, 1);
        
        // ファイルを上書き保存
        file_put_contents($registryPath, $newContent);
        $this->log("Successfully updated registry with: {$commandName}");
    }
}