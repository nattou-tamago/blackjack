<?php

namespace Blackjack;


class Evaluator
{
    public function judge(array $results): array
    {
        $judgmentResult = [
            'win' => false,
            'lose' => false,
            'push' => false,
            'surrender' => false,
        ];

        if ($results[0]['surrender']) {
            echo $results[0]['name'] . 'の負けです。。。' . '賭け金を半分支払います。' . PHP_EOL;
            $judgmentResult['surrender'] = true;
            return $judgmentResult;
        }

        if (count($results) === 1) {
            echo $results[0]['name'] . 'の得点が21を超えました。' . PHP_EOL;
            echo $results[0]['name'] . 'の負けです。。。' . PHP_EOL;
            $judgmentResult['lose'] = true;
            return $judgmentResult;
        }

        foreach ($results as $result) {
            echo $result['name'] . 'の得点は' . $result['point'] . 'です。' . PHP_EOL;
        }

        if ($results[1]['bust'] || $results[0]['point'] > $results[1]['point']) {
            echo 'あなたの勝ちです！' . PHP_EOL;
            $judgmentResult['win'] = true;
        } elseif ($results[0]['point'] < $results[1]['point']) {
            echo 'あなたの負けです。。。' . PHP_EOL;
            $judgmentResult['lose'] = true;
        } else {
            echo '引き分けです。' . PHP_EOL;
            $judgmentResult['push'] = true;
        }

        return $judgmentResult;
    }

    public function judgeSplit(array $results): array
    {
        $judgmentResultForSplit = [
            'win' => 0,
            'lose' => 0,
            'push' => 0,
        ];

        foreach ($results as $result) {
            echo $result['name'] . 'の得点は' . $result['point'] . 'です。' . PHP_EOL;
        }

        if (count($results) === 2) {
            if ($results[1]['bust'] || $results[0]['point'] > $results[1]['point']) {
                echo $results[0]['name'] . 'は勝ちです！' . PHP_EOL;
                $judgmentResultForSplit['win']++;

            } elseif ($results[0]['point'] < $results[1]['point']) {
                echo $results[0]['name'] . 'も負けです。。。' . PHP_EOL;
                $judgmentResultForSplit['lose']++;

            } else {
                echo $results[0]['name'] . 'は引き分けです。' . PHP_EOL;
                $judgmentResultForSplit['push']++;

            }

        } elseif (count($results) === 3) {
            if ($results[2]['bust'] || ($results[0]['point'] > $results[2]['point']) && ($results[1]['point'] > $results[2]['point'])) {
                echo $results[0]['name'] . 'も' . $results[1]['name'] . 'も勝ちです！' . PHP_EOL;
                $judgmentResultForSplit['win'] += 2;

            } elseif (($results[0]['point'] < $results[2]['point']) && ($results[1]['point'] < $results[2]['point'])) {
                echo $results[0]['name'] . 'も' . $results[1]['name'] . 'も負けです。。。' . PHP_EOL;
                $judgmentResultForSplit['lose'] += 2;

            } elseif (($results[0]['point'] === $results[2]['point']) && ($results[1]['point'] === $results[2]['point'])) {
                echo $results[0]['name'] . 'も' . $results[1]['name'] . 'も引き分けです。' . PHP_EOL;
                $judgmentResultForSplit['push'] += 2;

            } elseif (($results[0]['point'] > $results[2]['point']) && ($results[1]['point'] < $results[2]['point'])) {
                echo $results[0]['name'] . 'は勝ちです！' . PHP_EOL;
                echo $results[1]['name'] . 'は負けです。。。' . PHP_EOL;
                $judgmentResultForSplit['win']++;
                $judgmentResultForSplit['lose']++;

            } elseif (($results[0]['point'] > $results[2]['point']) && ($results[1]['point'] === $results[2]['point'])) {
                echo $results[0]['name'] . 'は勝ちです！' . PHP_EOL;
                echo $results[1]['name'] . 'は引き分けです。' . PHP_EOL;
                $judgmentResultForSplit['win']++;
                $judgmentResultForSplit['push']++;

            } elseif (($results[0]['point'] < $results[2]['point']) && ($results[1]['point'] > $results[2]['point'])) {
                echo $results[0]['name'] . 'は負けです。。。' . PHP_EOL;
                echo $results[1]['name'] . 'は勝ちです！' . PHP_EOL;
                $judgmentResultForSplit['lose']++;
                $judgmentResultForSplit['win']++;

            } elseif (($results[0]['point'] < $results[2]['point']) && ($results[1]['point'] === $results[2]['point'])) {
                echo $results[0]['name'] . 'は負けです。。。' . PHP_EOL;
                echo $results[1]['name'] . 'は引き分けです。' . PHP_EOL;
                $judgmentResultForSplit['lose']++;
                $judgmentResultForSplit['push']++;

            } elseif (($results[0]['point'] === $results[2]['point']) && ($results[1]['point'] > $results[2]['point'])) {
                echo $results[0]['name'] . 'は引き分けです。' . PHP_EOL;
                echo $results[1]['name'] . 'は勝ちです！' . PHP_EOL;
                $judgmentResultForSplit['push']++;
                $judgmentResultForSplit['win']++;

            } elseif (($results[0]['point'] === $results[2]['point']) && ($results[1]['point'] < $results[2]['point'])) {
                echo $results[0]['name'] . 'は引き分けです。' . PHP_EOL;
                echo $results[1]['name'] . 'は負けです。。。' . PHP_EOL;
                $judgmentResultForSplit['push']++;
                $judgmentResultForSplit['lose']++;

            }
        }

        return $judgmentResultForSplit;
    }
}
