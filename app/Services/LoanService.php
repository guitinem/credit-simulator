<?php

namespace App\Services;

use Carbon\Carbon;


class LoanService
{   
    private const INTEREST_RATE_1 = 5;
    private const INTEREST_RATE_2 = 3;
    private const INTEREST_RATE_3 = 2;
    private const INTEREST_RATE_4 = 4;


    /**
     * Simulate Loan Value
     * 
     * @param $loanAmount
     * @param $birthDate
     * @param $termInMonths
     * 
     * @return array
     * 
     */
    public function simulateLoan($loanAmount, $birthDate, $termInMonths)  
    {
        $interestRate = $this->getMonthlyInterestRate($birthDate);

        $fixedInstallmentValue = $this->getFixedInstallmentValue($loanAmount, $interestRate, $termInMonths);

        $totalAmount = $fixedInstallmentValue * $termInMonths;

        $totalInterestPaid = $totalAmount - $loanAmount;

        return [
            'monthly_installment' => round($fixedInstallmentValue, 2),
            'total_amount_to_be_paid' => round($totalAmount, 2),
            'total_interest_paid' => round($totalInterestPaid, 2),
        ];
    }

    private function getMonthlyInterestRate($birthDate)
    {   
        $interestRate = 0;
        $age = Carbon::parse($birthDate)->age;

        if ($age <= 25) {
            $interestRate = self::INTEREST_RATE_1;
        } else if($age >= 26 && $age <= 40) {
            $interestRate = self::INTEREST_RATE_2;
        } else if ($age >= 41 && $age <= 60 ) {
            $interestRate = self::INTEREST_RATE_3;
        } else {
            $interestRate = self::INTEREST_RATE_4;
        }

        $monthlyInterestRate = ($interestRate / 100) / 12;

        return $monthlyInterestRate;
    }

    private function getFixedInstallmentValue($loanAmount, $monthlyInterestRate, $termInMonths)
    {
        if($monthlyInterestRate == 0) {
            return $loanAmount / $termInMonths;
        }
        $fixedInstallmentValue = ($loanAmount * $monthlyInterestRate) / 
        (1 - pow(1 + $monthlyInterestRate, -$termInMonths));
        
        return round($fixedInstallmentValue, 2);
    }
}