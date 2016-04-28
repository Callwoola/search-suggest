<?php
namespace SuggestTest\Data;

trait TestData
{

    protected $data;

    public function getJson()
    {
        return $this->data['source'];
    }

    public function getData()
    {
        return $this->data['sentence'];
    }
}