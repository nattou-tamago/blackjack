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

$userResult = $user->play($deck);
$dealerResult = $dealer->play($deck);

$results = [$userResult, $dealerResult];

$evaluator = new Evaluator();
$evaluator->getWinner($results);
