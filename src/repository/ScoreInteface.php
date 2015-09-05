<?php

use Callwoola\SearchSuggest\repository\Coin;

interface ScoreInterface{

    public function getScore(Coin $coin);
}