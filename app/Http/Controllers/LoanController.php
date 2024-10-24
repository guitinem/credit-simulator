<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use App\Mail\LoanSimulation;
use App\Services\LoanService;

class LoanController extends Controller
{

    private LoanService $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function simulate(Request $request)
    {
        try {
            $request->validate([
                'term_in_months' => 'required|numeric|gt:1',
                'birth_date' => 'required|date_format:d-m-Y',
                'loan_amount' => 'required|numeric|gt:0',
                'email' => 'nullable|email:rfc,dns',
                'interest_type' => ['nullable', Rule::in(['fixed', 'variable'])],
                'currency' => ['nullable', Rule::in('USD', 'MXN', 'EUR', 'ARS', 'JPY')],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        }


        $loanAmount = $request->input('loan_amount');
        $termInMonths = $request->input('term_in_months');
        $birthDate = $request->input('birth_date');
        $interestType = $request->input('interest_type');
        $currency = $request->input('currency');

        $simulateLoan = $this->loanService->simulateLoan(
            $loanAmount,
            $birthDate,
            $termInMonths,
            $interestType,
            $currency
        );

        if (isset($simulateLoan['error'])) {
            return response()->json($simulateLoan, 500);
        }

        // Validate to send Email
        if ($request->has('email')) {
            Mail::to($request->input('email'))->queue(new LoanSimulation(loanSimulation: $simulateLoan));
        }

        return response()->json([
            'message' => 'Loan simulation successfully',
            'data' => $simulateLoan
        ]);
    }
}
