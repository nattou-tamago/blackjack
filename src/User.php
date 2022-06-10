<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');
require_once('SplitUser.php');

class User extends PlayerBase
{
    const DOUBLE_DOWN = 'DoubleDown';
    const SURRENDER = 'Surrender';
    const SPLIT = 'Split';

    private bool $isDoubleDown = false;
    private bool $isSurrender = false;
    private bool $isSplit = false;
    private array $splitOutcome = [];

    public function __construct(Deck $deck, float $fund, float $latch)
    {
        $this->name = 'あなた';

        $this->fund = $fund;
        $this->latch = $latch;

        for ($i = 0; $i < 2; $i++) {
            $card = $this->drawCard($deck);
            $this->displayCard($card);
        }
    }


    public function play(Deck $deck): array
    {
        $counter = 0;

        while (true) {
            $this->displayPoint();

            if ($this->getPlayerPoint() > 21) {
                $this->bust = true;
                break;
            }

            $input = $this->getUserInput($counter, $this->fund, $this->latch);

            if ($input === self::HIT) {
                echo 'ヒット。' . PHP_EOL;

                $card = $this->drawCard($deck);
                $this->displayCard($card);
                $counter++;

            } elseif ($input === self::STAND) {
                echo 'スタンド。' . PHP_EOL;
                break;

            } elseif ($input === self::DOUBLE_DOWN) {
                echo 'ダブルダウン。' . PHP_EOL;
                echo '賭け金を' . $this->latch . 'ドル追加します。' . PHP_EOL;

                $this->isDoubleDown = true;
                $card = $this->drawCard($deck);
                $this->displayCard($card);
                if ($this->getPlayerPoint() > 21) {
                    $this->bust = true;
                    break;
                }
                break;
            } elseif ($input === self::SURRENDER) {
                echo 'サレンダー。' . PHP_EOL;

                $this->isSurrender = true;
                break;
            } elseif ($input === self::SPLIT) {
                echo 'スプリット。' . PHP_EOL;
                echo 'スプリットしたハンドをそれぞれハンド(X)、ハンド(Y)とします。' . PHP_EOL;
                echo '賭け金を' . $this->latch . 'ドル追加し、ハンド(X)とハンド(Y)に対してそれぞれ' . $this->latch . 'ドルずつのベットとします。' . PHP_EOL;

                $this->isSplit = true;
                $this->splitOutcome = $this->handleSplit($deck, $this->hands[0], $this->hands[1]);
                break;
            }
        }

        return [
            'name' => $this->name,
            'bust' => $this->bust,
            'point' => $this->getPlayerPoint(),
            'doubleDown' => $this->isDoubleDown,
            'surrender' => $this->isSurrender,
            'split' => $this->isSplit,
            'splitOutcome' => $this->splitOutcome,
        ];
    }


    private function getUserInput(int $counter, float $fund, float $latch): string
    {
        echo 'アクションを選択してください。' . PHP_EOL;

        if ($counter === 0 && $fund >= $latch && $this->checkPair($this->hands[0], $this->hands[1])) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：スプリット（賭け金を同額ベットし、カードを2手に分ける） 4：ダブルダウン（賭け金を2倍にして1枚だけカードを引く） 5：サレンダー（賭け金を半分支払い、勝負を降りる）' . PHP_EOL;
            echo '1～5の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = trim(fgets(STDIN));
                if ($input === '1') {
                    return self::HIT;
                } elseif ($input === '2') {
                    return self::STAND;
                } elseif ($input === '3') {
                    return self::SPLIT;
                } elseif ($input === '4') {
                    return self::DOUBLE_DOWN;
                } elseif ($input === '5') {
                    return self::SURRENDER;
                } else {
                    echo '1～5の数字を入力してください。' . PHP_EOL;
                }
            }
        } elseif ($counter === 0 && $fund >= $latch) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：ダブルダウン（賭け金を2倍にして1枚だけカードを引く） 4：サレンダー（賭け金を半分支払い、勝負を降りる）' . PHP_EOL;
            echo '1～4の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = trim(fgets(STDIN));
                if ($input === '1') {
                    return self::HIT;
                } elseif ($input === '2') {
                    return self::STAND;
                } elseif ($input === '3') {
                    return self::DOUBLE_DOWN;
                } elseif ($input === '4') {
                    return self::SURRENDER;
                } else {
                    echo '1～4の数字を入力してください。' . PHP_EOL;
                }
            }
        } elseif ($counter === 0) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：サレンダー（賭け金を半分支払い、勝負を降りる）' . PHP_EOL;
            echo '1～3の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = trim(fgets(STDIN));
                if ($input === '1') {
                    return self::HIT;
                } elseif ($input === '2') {
                    return self::STAND;
                } elseif ($input === '3') {
                    return self::SURRENDER;
                } else {
                    echo '1～3の数字を入力してください。' . PHP_EOL;
                }
            }
        } else {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない）' . PHP_EOL;
            echo '1か2を入力してください。' . PHP_EOL;
            while (true) {
                $input = trim(fgets(STDIN));
                if ($input === '1') {
                    return self::HIT;
                } elseif ($input === '2') {
                    return self::STAND;
                } else {
                    echo '1か2を入力してください。' . PHP_EOL;
                }
            }
        }
    }

    private function checkPair(Card $card1, Card $card2): bool
    {
        if (self::CARD_POINT[$card1->getNumber()] === self::CARD_POINT[$card2->getNumber()]) {
            return true;
        } else {
            return false;
        }
    }

    private function handleSplit(Deck $deck, Card $card1, Card $card2): array
    {

        $splitUser1 = new SplitUser($deck, $card1, 'ハンド(X)');
        $splitUser2 = new SplitUser($deck, $card2, 'ハンド(Y)');
        $splitUser1Result = $splitUser1->play($deck);
        $splitUser2Result = $splitUser2->play($deck);
        echo '*****************************************' . PHP_EOL;
        return [$splitUser1Result, $splitUser2Result];
    }
}
