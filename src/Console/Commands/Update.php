<?php
namespace Callwoola\Search\Console\Commands;

use Callwoola\Search\lib\Indexdata\AnalyzeManage;
use Callwoola\Search\lib\Indexdata\IndexManage;
use Callwoola\Search\lib\SearchCache;
use Callwoola\Search\lib\ElasticsearchSearch;
use Callwoola\Search\lib\Indexdata\DataManage;
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
    protected $name = 'search:update';

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
        // TODO optimize code

        $start = microtime(true);
        $this->info('Update Callwoola-search Cache...');
        $indexManage = new IndexManage();
        $indexManage->byElasticsearch();
        $this->info("Create Elasticsearch Index successful!");
        $AnalyzeManage = new AnalyzeManage();
        $cacheInitials = $AnalyzeManage->getCacheInitials();
        $cachePinyin = $AnalyzeManage->getCachePinyin(1);
        $cacheFuzzySoundPinyin = $AnalyzeManage->getCacheFuzzySoundPinyin(1);
        $testdata = $AnalyzeManage->mergeData($cacheInitials, $cachePinyin, $cacheFuzzySoundPinyin);
        SearchCache::init()->setPinyinIndex($testdata);
        $this->info("Create Pinyin Cache Index successful!");
        $chineseList = $AnalyzeManage->getCacheChinese();
        SearchCache::init()->setChineseIndex($chineseList);
        $timeElapsed = microtime(true) - $start;
        $this->info("Create Chinese Cache Index successful!");
        $this->info(" Total time: $timeElapsed second");
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
