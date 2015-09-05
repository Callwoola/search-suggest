<?php


class Score implements ScoreInterface{

    public function getScore(\Callwoola\SearchSuggest\repository\Coin $coin)
    {
        return 0.0;
    }
}