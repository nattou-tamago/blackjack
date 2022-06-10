<?php

namespace Blackjack;

class Calculator
{
    public function calculateMoney(float $fund, float $latch, array $result): float
    {
        if ($result['surrender']) {
            $fund += $latch / 2;
        } elseif ($result['win']) {
            $fund += $latch * 2;
        } elseif ($result['push']) {
            $fund += $latch;
        }
        return $fund;
    }

    public function calculateMoneyForSplit(float $fund, float $latch, array $result): float
    {
        if (array_sum($result) === 1) {
            if ($result['win']) {
                $fund += $latch * 2;
            } elseif ($result['push']) {
                $fund += $latch;
            }
        } elseif (array_sum($result) === 2) {
            if ($result['win'] === 2) {
                $fund += $latch * 4;
            } elseif ($result['push'] === 2) {
                $fund += $latch * 2;
            } elseif ($result['win'] === 1 && $result['lose'] === 1) {
                $fund += $latch * 2;
            } elseif ($result['win'] === 1 && $result['push'] === 1) {
                $fund += $latch * 3;
            } elseif ($result['lose'] === 1 && $result['push'] === 1) {
                $fund += $latch;
            }
        }

        return $fund;
    }
}
