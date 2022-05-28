<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');

class Dealer extends PlayerBase
{
    public function __construct(Deck $deck)
    {
        $this->name = 'ディーラー';

        $card = $this->drawCard($deck);
        $this->displayCard($card);

        $this->drawCard($deck);
        echo $this->name . 'の引いた2枚目のカードはわかりません。' . PHP_EOL;
    }


    public function play(Deck $deck): array
    {
        echo $this->name . 'の引いた2枚目のカードは' . $this->hands[1]->getSuit() . 'の' . $this->hands[1]->getNumber() . 'でした。' . PHP_EOL;

        while (true) {
            if ($this->getPlayerPoint() < 17) {
                $this->displayPoint();
                echo PHP_EOL;

                $card = $this->drawCard($deck);
                $this->displayCard($card);
            } else {
                if ($this->getPlayerPoint() > 21) {
                    $this->bust = true;
                }
                return [
                    'name' => $this->name,
                    'bust' => $this->bust,
                    'point' => $this->getPlayerPoint()
                ];
            }
        }
    }
}
