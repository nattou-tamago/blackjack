<?php

namespace Blackjack;

require_once('Card.php');

abstract class PlayerBase
{
    protected string $name;
    protected array $hands = [];
    // protected int $point = 0;
    protected bool $bust = false;

    const CARD_POINT = [
        'A' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
    ];

    abstract public function play(Deck $deck): array;

    protected function drawCard(Deck $deck): Card
    {
        $card = $deck->getCard();
        $this->hands[] = $card;
        return $card;
    }

    protected function displayCard(Card $card): void
    {
        echo $this->name . 'の引いたカードは' . $card->getSuit() . 'の' . $card->getNumber() . 'です。' . PHP_EOL;
    }


    protected function getPlayerPoint(): int
    {
        $hasA = in_array('A', array_map(function (Card $card) {
            return $card->getNumber();
        }, $this->hands));

        $point = array_sum(array_map(function (Card $card) {
            return self::CARD_POINT[$card->getNumber()];
        }, $this->hands));

        if ($hasA) {
            if ($point > 11) {
                return $point;
            }
            return $point + 10;
        } else {
            return $point;
        }

        // return array_sum(array_map(function (Card $card) {
        //     return self::CARD_POINT[$card->getNumber()];
        // }, $this->hands));
    }

    protected function displayPoint(): void
    {
        echo $this->name . 'の現在の得点は' . $this->getPlayerPoint() . 'です。';
    }
}
