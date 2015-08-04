<?php

use Callwoola\SearchSuggest\lib\AnalyzeManage;
use Callwoola\SearchSuggest\analysis\ChineseAnalysis;

class AnalysisTest extends PHPUnit_Framework_TestCase
{


    /**
     * @covers ChineseAnalysis::GetFinallyIndex
     */
    public function testAnalysis()
    {
        $str='lasticSearch(简称ES)由java语言实现,运行环境依赖java。ES 1.
            0/,查看页面信息,是否正常启动.status=200表示正常启动了，还有一些es的版本信息,name为配';
        ChineseAnalysis::$loadInit = false;
        $pa = new ChineseAnalysis('utf-8', 'utf-8', false);
        $pa->LoadDict();
        $pa->SetSource($str);
        $pa->differMax = false;
        $pa->unitWord = false;
        $pa->StartAnalysis(true);
        $this->assertTrue(is_array($pa->GetFinallyIndex()));
//        $resultArray=$pa->GetFinallyIndex();
        $getInfo=true;
        $sign='-';
        $result=$pa->GetFinallyResult($sign,$getInfo);
        $result=explode($sign,$result);
        $filterResult=[];
        foreach($result as $k=>$value){
            if (preg_match('/\/n/i', $value) === 1) {
                $filterResult[]=$value;
            }
        }
        $this->assertTrue(count($filterResult)>0);
    }


}


