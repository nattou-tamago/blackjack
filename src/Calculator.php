<?php

namespace Blackjack;

class Calculator
{
    public function calculateMoney(float $fund, float $latch, array $judgmentResult): float
    {
        if ($judgmentResult['win']) {
            $fund += $latch * 2;
        } elseif ($judgmentResult['push']) {
            $fund += $latch;
        }
        return $fund;
    }
}
