<?php

namespace App\Services;

use Carbon\Carbon;

use App\Requesters\CurrencyConversionRequester;


class LoanService
{   
    private array $interestRageAge;

    private CurrencyConversionRequester $conversionRequester;


    public function __construct(CurrencyConversionRequester $conversionRequester)
    {
        $this->interestRageAge = [
            "1" => intval(env("INTEREST_RATE_AGE_1", 5)),
            "2" => intval(env("INTEREST_RATE_AGE_2", 3)),
            "3" => intval(env("INTEREST_RATE_AGE_3", 2)),
            "4" => intval(env("INTEREST_RATE_AGE_4", 4)),
        ];

        $this->conversionRequester = $conversionRequester;
    }


    /**
     * Simulate Loan Value
     * 
     * @param $loanAmount
     * @param $birthDate
     * @param $termInMonths
     * @param $interestType
     * 
     * @return array
     * 
     */
    public function simulateLoan($loanAmount, $birthDate, $termInMonths, $interestType, $currency)  
    {
        $interestRate = $this->getInterestRate($birthDate, $interestType, $termInMonths);

        if($currency) {
            $loanAmount = $this->conversionRequester->getConversionRate($currency, $loanAmount);

            if(!$loanAmount || is_string($loanAmount)) {
                return [
                    "message" => "Ocurred an error to convert the loan amount to " . $currency,
                    "error" => $loanAmount ?? "Internal Server Api Currency Error"
                ];
            }
        }

        $fixedInstallmentValue = $this->getFixedInstallmentValue($loanAmount, $interestRate, $termInMonths);

        $totalAmount = $fixedInstallmentValue * $termInMonths;

        $totalInterestPaid = $totalAmount - $loanAmount;

        return [
            'monthly_installment' => $fixedInstallmentValue,
            'total_amount_to_be_paid' => round($totalAmount, 2),
            'total_interest_paid' => round($totalInterestPaid, 2),
            'currency' => $currency ?? 'BRL'
        ];
    }

    private function getMonthlyInterestRate($birthDate)
    {   
        $interestRate = 0;
        $age = Carbon::parse($birthDate)->age;

        if ($age <= 25) {
            $interestRate = $this->interestRageAge['1'];
        } else if($age >= 26 && $age <= 40) {
            $interestRate = $this->interestRageAge['2'];
        } else if ($age >= 41 && $age <= 60 ) {
            $interestRate = $this->interestRageAge['3'];
        } else {
            $interestRate = $this->interestRageAge['4'];
        }

        $monthlyInterestRate = ($interestRate / 100) / 12;

        return $monthlyInterestRate;
    }

    private function getVariableInterestRate($termInMonths)
    {
        if ($termInMonths <= 12) {
            return 4.5; 
        } else if ($termInMonths <= 24) {
            return 5.0; 
        } else {
            return 6.0; 
        }
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

    private function getInterestRate($birthDate, $interestType, $termInMonths)
    {   
        $type = $interestType ?? 'fixed';

        if($type == 'fixed') {
            return $this->getMonthlyInterestRate($birthDate);
        }

        return $this->getVariableInterestRate($termInMonths);
    }
}