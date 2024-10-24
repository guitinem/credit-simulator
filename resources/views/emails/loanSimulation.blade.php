<html>
<head>
    <meta charset="utf-8" />
    <title>Simulação de Crédito</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #49E295;
            padding: 30px 0;
            text-align: center;
            color: #ffffff;
        }
        .content {
            padding: 20px 30px;
            background-color: #ffffff;
            text-align: center;
        }
        .details-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .summary {
            
        }
        .footer {
            background-color: #1f2d27;
            padding: 20px 0;
            text-align: center;
            color: #a5aea7;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Sua simulação está pronta</h2>
    </div>

    <div class="content">
        <table class="details-table">
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>Valor total a ser pago:</td>
                <td><strong>{{ $loanSimulation['total_amount_to_be_paid'] }}</strong></td>
            </tr>
            <tr>
                <td>Parcelas mensais:</td>
                <td>{{ $loanSimulation['monthly_installment'] }}</td>
            </tr>
            <tr>
                <td>Total de juros pagos:</td>
                <td>{{ $loanSimulation['total_interest_paid'] }}</td>
            </tr>
        </table>

        <p class="summary">
            Valor simulado: <strong>{{ $loanSimulation['original_loan_amount'] }}</strong><br>
            @if ($loanSimulation['currency'] != 'BRL')
                @switch($loanSimulation['currency'])
                    @case('USD')
                        Moeda convertida: 🇺🇸
                        @break
                    @case('MXN')
                        Moeda convertida: 🇲🇽
                        @break
                    @case('EUR')
                        Moeda convertida: 🇪🇺
                        @break
                    @case('ARS')
                        Moeda convertida: 🇦🇷
                        @break
                    @case('JPY')
                        Moeda convertida: 🇯🇵
                        @break
                    @default
                        Moeda convertida: 🇺🇸
                        @break
                @endswitch
            @endif
        </p>
    </div>

    <div class="footer">
        <h4>Simulation Loan INC</h4>
        <h4>2024</h4>
    </div>
</div>

</body>
</html>
