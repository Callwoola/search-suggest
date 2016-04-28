<?php
namespace SuggestTest\Support;

use Predis;
use SuggestTest\Data\TestData;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class baseTestCommand extends Command
{
    protected $name = "suggest test";
    protected $description = "suggest console";

    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }
}

class BaseTest extends \PHPUnit_Framework_TestCase
{
    use TestData;

    private $command;

    protected $connect;

    public function __construct()
    {
        parent::__construct();

        $this->command = new baseTestCommand();

        $file = realpath(dirname(__FILE__)) . '/../Data/data.json';
        $this->data = json_decode(file_get_contents($file), true);

        // 默认媒介redis
        $this->connect = new Predis\Client([
            'scheme'    => 'tcp',
            'host'      => '127.0.0.1',
            'port'      => 6379,
        ]);
    }


    public function __call($method, $args)
    {
        $this->command->$method($args[0]);
    }

    public function testStart()
    {
        $this->assertTrue(true);
    }
}

