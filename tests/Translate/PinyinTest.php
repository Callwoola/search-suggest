<?php

use Callwoola\Search\lib\Translate\Pinyin;

class PinyinTest extends PHPUnit_Framework_TestCase
{


    /**
     * 词语装换 拼音
     */
    public function testPinyin()
    {
        $dict = ['沙' => 'sha', '床' => 'chuang', '茶' => 'cha'];
        $pinyin = Pinyin::init();
        foreach ($dict as $k => $v) {
            $this->assertEquals($dict[$k], $pinyin->getPinyin($k));
        }
    }

    /**
     * 词语装换 拼音 句子
     */
    public function testPinyinWords()
    {
        $dict = ['沙发' => 'shafa', '红色沙发' => 'hongseshafa', '茶几' => 'chaji'];
        $pinyin = Pinyin::init();
        foreach ($dict as $k => $v) {
            $this->assertEquals($dict[$k], $pinyin->getPinyin($k));
        }
    }
}