<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Conversor de Moedas</h1>
        <?php
            // Verifica se o valor em $_REQUEST["din"] está definido e é numérico
            if (isset($_REQUEST["din"]) && is_numeric($_REQUEST["din"])) {
               
                // Data inicial e final para a consulta
                $inicio = date("m-d-Y", strtotime("-7 days"));
                $fim = date("m-d-Y");
                
                // URL da API para obter a cotação do dólar
                $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
                
                // Faz a solicitação à API e decodifica o JSON de resposta
                $dados = json_decode(file_get_contents($url), true);
                
                // Obtém a cotação do dólar
                $cotacao = $dados["value"][0]["cotacaoCompra"];
                
                // Valor em reais informado pelo usuário
                $real = $_REQUEST["din"];
                
                // Calcula a equivalência em dólar
                $dolar = $real / $cotacao;
                
                echo "Seus R$" . number_format($real, 2, ",", ".") . " equivalem a US$" . number_format($dolar, 2, ",", ".");
            } else {
                echo "Por favor, forneça um valor válido em reais.";
            }
        ?>
        <button onclick="javascript:history.go(-1)">Voltar</button>
    </main>
</body>
</html>
