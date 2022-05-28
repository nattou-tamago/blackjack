<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');

class User extends PlayerBase
{
    public function __construct(Deck $deck)
    {
        $this->name = 'あなた';

        for ($i = 0; $i < 2; $i++) {
            $card = $this->drawCard($deck);
            // echo $this->name . 'の引いたカードは' . $this->hands[$i]->getSuit() . 'の' . $this->hands[$i]->getNumber() . 'です。' . PHP_EOL;
            $this->displayCard($card);
        }
    }


    public function play(Deck $deck): array
    {
        while (true) {
            $this->displayPoint();

            if ($this->getPlayerPoint() > 21) {
                echo $this->name . 'の得点が21を超えました。' . PHP_EOL;
                echo $this->name . 'の負けです。。。' . PHP_EOL;
                echo 'ブラックジャックを終了します。' . PHP_EOL;
                exit();
            }

            $input = $this->getUserInput();

            if ($input) {
                $card = $this->drawCard($deck);
                $this->displayCard($card);
            } else {
                return [
                    'name' => $this->name,
                    'bust' => $this->bust,
                    'point' => $this->getPlayerPoint()
                ];
            }
        }
    }







    private function getUserInput(): bool
    {
        echo 'カードを引きますか？（Y/N）' . PHP_EOL;
        while (true) {
            $input = trim(fgets(STDIN));
            if ($input === 'Y') {
                return true;
            } elseif ($input === 'N') {
                return false;
            } else {
                echo 'YまたはNを入力してください。' . PHP_EOL;
            }
        }
    }
}
