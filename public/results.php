<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/results.css">
    <title>Conversor de Moedas</title>
</head>
<body>
    <?php
    //Consumindo API - Configurando URL 
        $dataHoje = date("m-d-Y");
        $dataPassada = date("m-d-Y", strtotime("-7 days"));
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $dataPassada .'\'&@dataFinalCotacao=\''. $dataHoje .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

    //Traduzindo o JSON e capturando os dados
        $dados = json_decode(file_get_contents($url), true);

    //Atribuindo o valor do dólar
        $dolar = $dados["value"][0]["cotacaoCompra"];
    ?>

    <div class="container">
        <div class="dolar-div">
            <p>Dólar<br/>Fonte: BACEN</p>
            <h2>$ <?= "$dolar" ?></h2>
        </div>
        <div class="conversor-div">
            <form action="" method="post">

            <?php
            //Capturando valor digitado pelo usuário
                $real = (float) $_POST['real'] ?? 0;
            //Convertendo para dólar e formatando
                $novoValor = (float) ($real / $dolar);
                $valorFormatado = round($novoValor, 2,2);
            ?>

                <div>
                    <div class="div-input">
                        <label for="real">BRL</label>
                        <span>R$<?="$real"?></span>
                    </div>
                    <span class="span">=</span>
                    <div class="div-results">
                        <label>USD</label>
                        <span>$<?="$valorFormatado"?></span>
                    </div>
                </div>  
            </form>
            <div class="div-voltar">
                <a class="input"
                href="./index.php">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>