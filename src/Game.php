<?php

namespace Blackjack;

require_once('Deck.php');
require_once('User.php');
require_once('Dealer.php');
require_once('Evaluator.php');
require_once('Calculator.php');

class Game
{
    const STAKE = 1000;
    const MIN_LATCH = 100;

    public function start(): void
    {
        echo 'ブラックジャックを開始します。' . PHP_EOL;

        $fund = self::STAKE;
        $latch = 0;

        $continue = true;

        while ($continue) {
            echo 'あなたの資金は' . $fund . 'ドルです。' . PHP_EOL;

            $latch = $this->getUserBet($fund);

            echo $latch . 'ドルベットします。' . PHP_EOL;
            $fund -= $latch;

            $deck = new Deck();
            $user = new User($deck);
            $dealer = new Dealer($deck);
            $evaluator = new Evaluator();

            $userResult = $user->play($deck);

            if ($userResult['bust']) {
                $judgmentResult = $evaluator->judge([$userResult]);
            } else {
                $dealerResult = $dealer->play($deck);
                $judgmentResult = $evaluator->judge([$userResult, $dealerResult]);
            }

            $calculator = new Calculator();
            $fund = $calculator->calculateMoney($fund, $latch, $judgmentResult);

            echo 'あなたの資金は' . $fund . 'ドルです。' . PHP_EOL;

            $continue = $this->getUserContinueOrStop($continue, $fund);
        }


        echo 'ブラックジャックを終了します。' . PHP_EOL;
    }


    private function getUserContinueOrStop(bool $continue, float $fund): bool
    {
        if ($fund < self::MIN_LATCH) {
            echo '資金が足りません。' . PHP_EOL;
            $continue = false;
            return $continue;
        }

        echo 'ゲームを続けますか？（Y/N）' . PHP_EOL;
        while (true) {
            $input = trim(fgets(STDIN));
            if ($input === 'Y') {
                echo '------------------------------------' . PHP_EOL;
                echo '次のゲームを開始します。' . PHP_EOL;
                break;
            } elseif ($input === 'N') {
                $continue = false;
                break;
            } else {
                echo 'YまたはNを入力してください。' . PHP_EOL;
            }
        }

        return $continue;
    }

    private function getUserBet(float $fund): float
    {
        echo '何ドルベットしますか。' . PHP_EOL;
        echo 'ミニマムベット（最低賭け金）は' . self::MIN_LATCH . 'ドルです。数字を入力してください。' . PHP_EOL;

        while (true) {
            $input = trim(fgets(STDIN));
            if (!is_numeric($input)) {
                echo '数字を入力してください。' . PHP_EOL;
            } elseif ($input > $fund) {
                echo '賭け金が資金を超えています。賭け金を減らしてください。' . PHP_EOL;
            } elseif ($input < self::MIN_LATCH) {
                echo 'ミニマムベット以上を入力ください。' . PHP_EOL;
            } else {
                break;
            }
        }

        return $input;
    }
}
