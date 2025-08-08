<?php 
namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class BookSearch extends AbstractCommand
{
    // 使用するコマンド名を指定
    protected static ?string $alias = 'book-search';

        // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('title'))
                ->description('Search for books by title')
                ->required(false)
                ->allowAsShort(true),
            (new Argument('isbn'))
                ->description('Search for books by ISBN')
                ->required(false)
                ->allowAsShort(true),
        ];
    }
    public function execute(): int
    {
        $title = $this->getArgumentValue('title');
        $isbn = $this->getArgumentValue('isbn');
        if (!$title && !$isbn) {
            $this->log('Please provide a title or ISBN to search for books.');
            $this->log(static::getHelp());
            return 1; // エラーコードを返す
        }
        if ($title) {
            $this->log('Searching for books with title: ' . $title);
            // ここでタイトルに基づく検索ロジックを実装
        }
        if ($isbn) {
            $this->log('Searching for books with ISBN: ' . $isbn);
            // ここでISBNに基づく検索ロジックを実装
        }
        $this->log('Search completed.');

        return 0; // 成功コードを返す
    }

}
?>