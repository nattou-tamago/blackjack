<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');

class User extends PlayerBase
{
    const HIT = 'Hit';
    const STAND = 'Stand';
    const DOUBLE_DOWN = 'DoubleDown';
    const SURRENDER = 'Surrender';

    private bool $isDoubleDown = false;
    private bool $isSurrender = false;

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
            }
        }

        return [
            'name' => $this->name,
            'bust' => $this->bust,
            'point' => $this->getPlayerPoint(),
            'doubleDown' => $this->isDoubleDown,
            'surrender' => $this->isSurrender,
        ];
    }


    private function getUserInput(int $counter, float $fund, float $latch): string
    {
        echo 'アクションを選択してください。' . PHP_EOL;

        // if ($counter === 0 && $fund >= $latch && $this->checkPair($this->hands[0], $this->hands[1])) {
        //     echo 'スプリット!!!!!!!' . PHP_EOL;
        // }

        if ($counter === 0 && $fund >= $latch) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：ダブルダウン（賭け金を2倍にして1枚だけカードを引く） 4：サレンダー（賭け金を半分支払い、勝負を降りる）' . PHP_EOL;
            echo '1～4の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = (int) trim(fgets(STDIN));
                if ($input === 1) {
                    return self::HIT;
                } elseif ($input === 2) {
                    return self::STAND;
                } elseif ($input === 3) {
                    return self::DOUBLE_DOWN;
                } elseif ($input === 4) {
                    return self::SURRENDER;
                } else {
                    echo '1～4の数字を入力してください。' . PHP_EOL;
                }
            }
        } elseif ($counter === 0) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：サレンダー（賭け金を半分支払い、勝負を降りる）' . PHP_EOL;
            echo '1～3の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = (int) trim(fgets(STDIN));
                if ($input === 1) {
                    return self::HIT;
                } elseif ($input === 2) {
                    return self::STAND;
                } elseif ($input === 3) {
                    return self::SURRENDER;
                } else {
                    echo '1～3の数字を入力してください。' . PHP_EOL;
                }
            }
        } else {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない）' . PHP_EOL;
            echo '1か2を入力してください。' . PHP_EOL;
            while (true) {
                $input = (int) trim(fgets(STDIN));
                if ($input === 1) {
                    return self::HIT;
                } elseif ($input === 2) {
                    return self::STAND;
                } else {
                    echo 'YまたはNを入力してください。' . PHP_EOL;
                }
            }
        }
    }

    // private function checkPair(Card $card1, Card $card2): bool
    // {
    //     if (self::CARD_POINT[$card1->getNumber()] === self::CARD_POINT[$card2->getNumber()]) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}
