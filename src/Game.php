<?php

namespace Blackjack;

require_once('Deck.php');
require_once('User.php');
require_once('Dealer.php');
require_once('Evaluator.php');

class Game
{
    public function start(): void
    {
        echo 'ブラックジャックを開始します。' . PHP_EOL;

        $continue = true;

        while ($continue) {
            $deck = new Deck();
            $user = new User($deck);
            $dealer = new Dealer($deck);
            $evaluator = new Evaluator();

            $userResult = $user->play($deck);

            if ($userResult['bust']) {
                $evaluator->getWinner([$userResult]);
            } else {
                $dealerResult = $dealer->play($deck);
                $evaluator->getWinner([$userResult, $dealerResult]);
            }

            $continue = $this->getUserContinueOrStop($continue);
        }


        echo 'ブラックジャックを終了します。' . PHP_EOL;
    }


    private function getUserContinueOrStop(bool $continue): bool
    {
        echo 'ゲームを続けますか？（Y/N）' . PHP_EOL;
        while (true) {
            $input = trim(fgets(STDIN));
            if ($input === 'Y') {
                echo '------------------------------------' . PHP_EOL;
                echo '次のゲームを開始します。' . PHP_EOL;
                return $continue;
            } elseif ($input === 'N') {
                $continue = false;
                return $continue;
            } else {
                echo 'YまたはNを入力してください。' . PHP_EOL;
            }
        }
    }
}
