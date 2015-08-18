<?php

namespace Callwoola\SearchSuggest\lib;



class OrderManage extends DataManage
{

    /**
     *  排序基本规则
     *  手动加分 > 分类名称 > 所属数量 > 属性 > 品牌
     *
    */

    /**
     * 错误代码
     * [*]必须添加注释
     */
    const SUCCESS                 = 0; // 成功
    const FAIL                    = 1; // 失败
    const ERROR_OPERATION_FAILED  = 10001; // 操作失败
    const ERROR_FREQUENCY_LIMITED = 20001; // 操作频率超限


    public function sortList(array $list){

        return $list;
    }

    /**
     * 给予每个词语的评分
    */
    public function scoreList(array $list){
        return $list;
    }

}