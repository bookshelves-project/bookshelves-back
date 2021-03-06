<?php

namespace App\Console\Commands\Bookshelves;

use App\Console\CommandProd;
use App\Engines\ConverterEngine;
use App\Engines\ParserEngine;
use App\Engines\ParserEngine\Parsers\FilesTypeParser;
use App\Models\Book;
use Illuminate\Console\Command;

class ScanCommand extends CommandProd
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookshelves:scan';

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
        $this->intro('Scan storage data books directory');

        $verbose = $this->option('verbose');

        $files = FilesTypeParser::parseDataFiles();

        $new_files = [];
        if (! $verbose) {
            $bar = $this->output->createProgressBar(sizeof($files));
            $bar->start();
        }
        foreach ($files as $key => $file) {
            $parser = ParserEngine::create($file);
            $converter = new ConverterEngine($parser);
            $is_exist = $converter->bookIfExist();
            if (! $is_exist) {
                array_push($new_files, $parser);
            }
            if (! $verbose) {
                $bar->advance();
            } else {
                $this->info($key.' '.pathinfo($file->path, PATHINFO_FILENAME));
            }
        }
        if (! $verbose) {
            $bar->finish();
            $this->newLine();
        }

        if (sizeof($new_files) > 0) {
            $this->newLine();
            $this->info('New files detected');
            $this->newLine();
            foreach ($new_files as $parser) {
                if ($parser instanceof ParserEngine) {
                    $this->info("- {$parser->title} from {$parser->file_name}");
                }
            }
        }

        $this->newLine();
        $this->warn(sizeof(($files)).' files found');
        if (sizeof($new_files) > 0) {
            $this->warn(sizeof(($new_files)).' new files found, to add it to collection, you can use `bookshelves:generate`');
        }
        if (0 === sizeof(($new_files)) && sizeof(($files)) !== Book::count()) {
            $this->warn('Some duplicates detected!');
        }
        $this->newLine();

        $this->table(
            ['New books', 'Books'],
            [[sizeof($new_files), Book::count()]]
        );

        return $files;
    }
}
