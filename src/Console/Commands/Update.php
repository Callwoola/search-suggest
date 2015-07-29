<?php
namespace Callwoola\Searchsuggest\Console\Commands;

use Callwoola\Searchsuggest\lib\Indexdata\AnalyzeManage;
use Callwoola\Searchsuggest\lib\Indexdata\IndexManage;
use Callwoola\Searchsuggest\lib\SearchCache;
use Callwoola\Searchsuggest\lib\ElasticsearchSearch;
use Callwoola\Searchsuggest\lib\Indexdata\DataManage;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Update extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'suggest:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Callwoola search update!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Update Callwoola-search Cache...');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }

}
