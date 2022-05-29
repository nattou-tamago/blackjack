<?php

namespace Blackjack;


class Evaluator
{
    public function getWinner(array $results): void
    {
        if (count($results) === 1) {
            echo $results[0]['name'] . 'の得点が21を超えました。' . PHP_EOL;
            echo $results[0]['name'] . 'の負けです。。。' . PHP_EOL;
            return;
        }

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
    }
}
