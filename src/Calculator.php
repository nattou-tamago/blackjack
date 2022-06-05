<?php

namespace Blackjack;

class Calculator
{
    public function calculateMoney(float $fund, float $latch, array $judgmentResult): float
    {
        if ($judgmentResult['surrender']) {
            $fund += $latch / 2;
        } elseif ($judgmentResult['win']) {
            $fund += $latch * 2;
        } elseif ($judgmentResult['push']) {
            $fund += $latch;
        }
        return $fund;
    }
}
