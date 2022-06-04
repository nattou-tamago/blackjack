<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');

class User extends PlayerBase
{
    const HIT = 'Hit';
    const STAND = 'Stand';
    const DOUBLE_DOWN = 'DoubleDown';

    private bool $isDoubleDown = false;

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
            }
        }

        return [
            'name' => $this->name,
            'bust' => $this->bust,
            'point' => $this->getPlayerPoint(),
            'doubleDown' => $this->isDoubleDown,
        ];
    }


    private function getUserInput(int $counter, float $fund, float $latch): string
    {
        echo 'アクションを選択してください。' . PHP_EOL;

        if ($counter === 0 && $fund >= $latch) {
            echo '1：ヒット（カードを引く） 2：スタンド（カードを引かない） 3：ダブルダウン（賭け金を2倍にして1枚だけカードを引く）' . PHP_EOL;
            echo '1～3の数字を入力してください。' . PHP_EOL;
            while (true) {
                $input = (int) trim(fgets(STDIN));
                if ($input === 1) {
                    return self::HIT;
                } elseif ($input === 2) {
                    return self::STAND;
                } elseif ($input === 3) {
                    return self::DOUBLE_DOWN;
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
}
