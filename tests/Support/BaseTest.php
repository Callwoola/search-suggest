<?php
namespace SuggestTest\Support;

use Predis;
use SuggestTest\Data\TestData;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * output base class
 *
 * Class baseTestCommand
 * @package SuggestTest\Support
 */
class baseTestCommand extends Command
{
    /**
     * @var string
     */
    protected $name        = "suggest test";
    /**
     * @var string
     */
    protected $description = "suggest console";

    /**
     * baseTestCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }
}

/**
 * Class BaseTest
 * @package SuggestTest\Support
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{
    const TYPE_ONE   = 'one';
    const TYPE_TWO   = 'two';
    const TYPE_THREE = 'three';

    use TestData;

    /**
     * @var baseTestCommand
     */
    private $command;

    /**
     * @var Predis\Client
     */
    protected $connect;


    /**
     * @return array
     */
    public function getType()
    {
        return [
            self::TYPE_ONE,
            self::TYPE_TWO,
            self::TYPE_THREE,
        ];
    }


    /**
     * BaseTest constructor.
     */
    public function __construct()
    {
        $this->baseStartTime = microtime();
        parent::__construct();

        $this->command = new baseTestCommand();

        $file = realpath(dirname(__FILE__)) . '/../Data/data.json';
        $this->data = json_decode(file_get_contents($file), true);

        $start = microtime();
        // 默认媒介redis
        $this->connect = new Predis\Client([
            'scheme'     => 'tcp',
            'host'       => '127.0.0.1',
            'port'       => 6379,
            'persistent' => true,
        ]);
        $this->error('redis:');
        $this->error(microtime() - $start);
    }


    /**
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        $this->command->$method($args[0]);
    }


    public function testStart()
    {
        $this->assertTrue(true);
    }
}

