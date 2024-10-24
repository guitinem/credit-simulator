<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Projeto Simulador de Crédito

#### Api desenvolvida em Laravel para simulação de empréstimos com suporte a diferentes moedas e cenários de taxa de juros (fixa e variável)


### Rota para testar:
request
```bash
curl --location 'localhost:8000/api/loan-simulate' \
--header 'Content-Type: application/json' \
--data-raw '{
    "loan_amount": 10000,
    "birth_date": "01-01-1996",
    "term_in_months": 36,
    "email": "teste@gmail.com",
    "interest_type": "fixed",
    "currency": "ARS"
}'
```

response 
```bash
{
    "message": "Loan simulation successfully",
    "data": {
        "monthly_installment": 50213.48,
        "total_amount_to_be_paid": 1807685.28,
        "total_interest_paid": 81021.22
    }
}
```

Request Params
<table>
    <thead>
        <tr>
            <th style="text-align: left;">Campo</th>
            <th style="text-align: left;">Tipo</th>
            <th style="text-align: left;">Obrigatório</th>
            <th style="text-align: left;">Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light" tabindex="0">loan_amount</td>
            <td style="text-align: left;"><strong>int</strong></td>
            <td style="text-align: center;">Sim</td>
            <td style="text-align: left;">Valor do empréstimo</td>
        </tr>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light"
            tabindex="0"><span>birth_date</span></code></td>
            <td style="text-align: left;"><strong>string</strong></td>
            <td style="text-align: center;">Sim</td>
            <td style="text-align: left;">Data de nascimento, utilize o formato d-m-Y</td>
        </tr>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light" tabindex="0">
                <span>term_in_months</span></code>
            </td>
            <td style="text-align: left;"><strong>int</strong></td>
            <td style="text-align: center;">Sim</td>
            <td style="text-align: left;">Prazo de pagamento em meses</td>
        </tr>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light"tabindex="0">
                <span class="cm-s-neo">email</span></code>
            </td>
            <td style="text-align: left;"><strong>email</strong></td>
            <td style="text-align: center;">Não</td>
            <td style="text-align: left;">Email para receber um resumo da simulação do crédito</td>
        </tr>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light">
                <span class="cm-s-neo">interest_type</span></code>
            </td>
            <td style="text-align: left;"><strong>string</strong></td>
            <td style="text-align: center;">Não</td>
            <td style="text-align: left;">Tipo de taxa de juros, podendo ser fixa (fixed) ou variável(variable)<br>Valor default fixed</td>
        </tr>
        <tr>
            <td style="text-align: left;"><code class="rdmd-code lang- theme-light">
                <span class="cm-s-neo" data-testid="SyntaxHighlighter">currency</span></code>
            </td>
            <td style="text-align: left;"><strong>string</strong></td>
            <td style="text-align: center;">Não</td>
            <td style="text-align: left;">
                Moeda para fazer a conversão, valores aceitos:<br>USD, MXN, EUR, ARS, JPY<br>Caso não seja passado nenhum valor, a conversão seguira no real (BRL)
            </td>
        </tr>
    </tbody>
</table>

## Configurações adicionais
- Preencha os valores do provedor de email caso queira testar o envio de email's, sugiro o [mailtrap.io](https://mailtrap.io/)
- No campo API_KEY na **env**, coloque uma chave valida do site [currencylayer](https://currencylayer.com/), que é usado para fazer a conversão dos valores para moeda desejada



## Para rodar este projeto

```bash
-Entre na pasta raiz do projeto

$ composer install
$ cp .env.example .env
$ php artisan serve #inicia o projeto
```


## Pré-requisitos
- PHP >= 8.2
- Laravel >= 11.X
- Composer >= 2.8.1
- PostgreSql
