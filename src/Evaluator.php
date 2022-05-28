<?php

namespace Blackjack;


class Evaluator
{
    public function getWinner(array $results):void
    {
        foreach ($results as $result) {
            echo $result['name'] . 'の得点は' . $result['point'] . 'です。' . PHP_EOL;
        }

        if ($results[1]['bust'] || $results[0]['point'] > $results[1]['point']) {
            echo 'あなたの勝ちです！' . PHP_EOL;
        } elseif ($results[0]['point'] < $results[1]['point']) {
            echo 'あなたの負けです。。。' . PHP_EOL;
        } else {
            echo '引き分けです。' . PHP_EOL;
        }

        echo 'ブラックジャックを終了します。' . PHP_EOL;
    }
}
