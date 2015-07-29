<?php
namespace Callwoola\Searchsuggest\lib;
interface SearchInterface
{

    /**
     * 搜索建议
     * @param string $keyword
     * @return array
     */
    public function searchSuggestion($keyword);

    /**
     * 产品搜索
     * @param string $keyword
     * @return array
     */
    public function search($keyword);

    /**
     * 添加排序条件
     * @param string $field
     * @param string $sortChar
     */
    public function addSorts($field, $sortChar);

    /**
     * set page size
     * @param int $Size
     */
    public function setPageSize($Size);

    /**
     * set Current Page
     * @param int $page
     */
    public function setCurrentPage($page);

    /**
     * 添加过滤条件
     * @param string $field
     * @param string $condition
     * @param int $Parameters
     */
    public function addCondition($field, $condition, $Parameters);

    /**
     * 更新 aliyun 或者 elastsearch index
     */
    public function updateIndex();

    /**
     * single doc up
     * @return bool
     */
    public function upOne();


}
