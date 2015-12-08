<?php
namespace SuggestTest\Data;

trait TestData{

    static $sentences = [
        '门框、窗框饰线',
        '地毯砖洛维娜 ',
        '地毯砖芬迪尔',
        '中式吊灯中式全铜云石吊灯',
        '进口PVC革现货荔枝纹软包沙发',
        '设计师的公司',
        '三星（SAMSUNG）850 EVO系列 120G 2.5英寸 SATA-3固态硬盘',
        '小米 红米2A 增强版 白色 移动4G手机 双卡双待 四核移动4G双卡双待手机，增强',
    ];

    public static function getData(){
        return self::$sentences;
    }
}