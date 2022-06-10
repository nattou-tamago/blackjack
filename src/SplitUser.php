<?php

namespace Blackjack;

require_once('User.php');


class SplitUser extends PlayerBase
{
    public function __construct(Deck $deck, Card $card, string $handName)
    {
        $this->hands[] = $card;
        $this->name = $handName;

        echo '*****************************************' . PHP_EOL;
        echo '-- ' . $this->name . ' --' . PHP_EOL;
        echo '手持ちのカードは' . $this->hands[0]->getSuit() . 'の' . $this->hands[0]->getNumber() . 'です。' . PHP_EOL;

        $card = $this->drawCard($deck);
        $this->displayCard($card);
    }


    public function play(Deck $deck): array
    {
        echo '*****************************************' . PHP_EOL;
        echo '-- ' . $this->name . ' --' . PHP_EOL;

        while (true) {
            $this->displayPoint();

            if ($this->getPlayerPoint() > 21) {
                $this->bust = true;
                echo $this->name . 'の得点が21を超えました。' . PHP_EOL;
                break;
            }

            $input = $this->getSplitUserInput();

            if ($input === self::HIT) {
                echo 'ヒット。' . PHP_EOL;

                $card = $this->drawCard($deck);
                $this->displayCard($card);

            } elseif ($input === self::STAND) {
                echo 'スタンド。' . PHP_EOL;
                break;

            }
        }

        return [
            'name' => $this->name,
            'bust' => $this->bust,
            'point' => $this->getPlayerPoint(),
        ];
    }


    private function getSplitUserInput(): string
    {
            echo 'アクションを選択してください。' . PHP_EOL;

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
