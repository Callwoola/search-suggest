<?php

namespace Callwoola\Search\lib\Indexdata;



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
    const ERROR_INVALID_PARAM     = 20002; // 不合法参数
    const ERROR_INVALID_CAPTCHA   = 20003; // 验证码错误
    const ERROR_OBJECT_EXIST      = 20004; // 对象已存在
    const ERROR_AUTH_FAILED       = 40001; // 未登录操作
    const ERROR_PERMISSION_DENIED = 40003; // 权限错误


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