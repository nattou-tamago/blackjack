<?php

namespace Blackjack;

require_once('Card.php');

class Deck
{
    const CARD_SUITS = ['ダイヤ', 'ハート', 'クラブ', 'スペード'];
    const CARD_NUMBERS = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

    private array $cardList = [];

    public function __construct()
    {
        foreach (self::CARD_SUITS as $mark) {
            foreach (self::CARD_NUMBERS as $number) {
                $this->cardList[] = new Card($mark, $number);
            }
        }

        shuffle($this->cardList);
    }

    public function getCard(): Card
    {
        return array_pop($this->cardList);
    }
}
