<?php

namespace Blackjack;


class Evaluator
{
    private array $judgmentResult = [
        'win' => false,
        'lose' => false,
        'push' => false,
        'surrender' => false,
    ];

    public function judge(array $results): array
    {
        if ($results[0]['surrender']) {
            echo $results[0]['name'] . 'の負けです。。。' . '賭け金を半分支払います。' . PHP_EOL;
            $this->judgmentResult['surrender'] = true;
            return $this->judgmentResult;
        }

        if (count($results) === 1) {
            echo $results[0]['name'] . 'の得点が21を超えました。' . PHP_EOL;
            echo $results[0]['name'] . 'の負けです。。。' . PHP_EOL;
            $this->judgmentResult['lose'] = true;
            return $this->judgmentResult;
        }

        foreach ($results as $result) {
            echo $result['name'] . 'の得点は' . $result['point'] . 'です。' . PHP_EOL;
        }

        if ($results[1]['bust'] || $results[0]['point'] > $results[1]['point']) {
            echo 'あなたの勝ちです！' . PHP_EOL;
            $this->judgmentResult['win'] = true;
        } elseif ($results[0]['point'] < $results[1]['point']) {
            echo 'あなたの負けです。。。' . PHP_EOL;
            $this->judgmentResult['lose'] = true;
        } else {
            echo '引き分けです。' . PHP_EOL;
            $this->judgmentResult['push'] = true;
        }

        return $this->judgmentResult;
    }
}
