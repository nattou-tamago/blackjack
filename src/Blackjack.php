<?php

namespace Blackjack;

require_once('Deck.php');
require_once('User.php');
require_once('Dealer.php');
require_once('Evaluator.php');


echo 'ブラックジャックを開始します。' . PHP_EOL;


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

echo 'ブラックジャックを終了します。' . PHP_EOL;
