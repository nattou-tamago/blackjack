<?php

namespace Blackjack;

require_once('PlayerBase.php');
require_once('Deck.php');

class User extends PlayerBase
{
    private int $fund = 1000;
    private int $latch = 100;

    public function __construct(Deck $deck)
    {
        $this->name = 'あなた';

        for ($i = 0; $i < 2; $i++) {
            $card = $this->drawCard($deck);
            $this->displayCard($card);
        }
    }


    public function play(Deck $deck): array
    {
        $this->fund -= $this->latch;

        while (true) {
            $this->displayPoint();

            if ($this->getPlayerPoint() > 21) {
                $this->bust = true;
                break;
            }

            $input = $this->getUserInput();

            if ($input) {
                $card = $this->drawCard($deck);
                $this->displayCard($card);
            } else {
                break;
            }
        }

        return [
            'name' => $this->name,
            'bust' => $this->bust,
            'point' => $this->getPlayerPoint()
        ];

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
