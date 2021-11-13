<?php

namespace App\Console\Commands\Bookshelves;

use App\Services\ParserEngine\ParserList;
use Illuminate\Console\Command;

class ScanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scan
                            {--l|limit= : limit epub files to generate, useful for debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan directory public/storage/data/books to get all EPUB files.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): false|array
    {
        $limit = $this->option('limit');
        $limit = str_replace('=', '', $limit);
        $limit = intval($limit);

        $verbose = $this->option('verbose');

        $app = config('app.name');
        $this->alert("{$app}: scan all EPUB files");
        $this->warn('Scan public/storage/data/books directory');

        $epubFiles = ParserList::getEbooks(limit: $limit);

        if ($verbose) {
            foreach ($epubFiles as $key => $file) {
                echo $key.' '.pathinfo($file)['filename']."\n";
            }
        }

        if ($limit) {
            return array_slice($epubFiles, 0, $limit);
        }

        $this->warn(sizeof(($epubFiles)).' EPUB files found');
        $this->newLine();

        return $epubFiles;
    }
}
