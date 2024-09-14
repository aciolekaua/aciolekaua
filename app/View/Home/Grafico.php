<?php
use Src\Classes\ClassValidate;
$Validate = new ClassValidate;
$dados=$Validate->validateRecebimentoAnual([
    "ID"=>$_SESSION['ID'],
    "TipoCliente"=>$_SESSION['TipoCliente'],
    "DataAtual"=>date("Y-m-d")
]);
//var_dump($dados);
$mesesRecebimento=array();
for($i=1;$i<=12;$i++){$mesesRecebimento+=[$i=>00.00];}
$l=0;
foreach($dados as $key => $array){
    $mesesRecebimento[$array['Mes']]=(float)$array["Valor"];
    if($l==0){$mesDeComeco=(int)$array['Mes'];}
    $l++;
}
$limite = 6750*((12-$mesDeComeco)+1);

if($_SESSION['TipoJuridico']=="302066064"){include_once("MEI/FooterMEI.php");}

?>

<script>
    const chartsReceita = document.querySelector(".chart.recebimento");
    const ctxReceita = chartsReceita.getContext('2d');
    const myChartReceita = new Chart(ctxReceita, {
        type: 'bar',
        data: {
            labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            datasets: [{
                label: 'Entradas',
                data: [<?php echo("{$mesesRecebimento[1]},{$mesesRecebimento[2]},{$mesesRecebimento[3]},{$mesesRecebimento[4]},{$mesesRecebimento[5]},{$mesesRecebimento[6]},{$mesesRecebimento[7]},{$mesesRecebimento[8]},{$mesesRecebimento[9]},{$mesesRecebimento[10]},{$mesesRecebimento[11]},{$mesesRecebimento[12]}");?>],
                  backgroundColor: [
                    "rgba(34,139,34, 0.2)"
                  ],
                  borderColor: [
                    "rgba(34,139,34, 1)"
                  ],
                borderWidth: 1
            }]
            
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                    
                }
            }
        }
    });
   
</script>
<?php
$dados=$Validate->validateGastoAnual([
    "ID"=>$_SESSION['ID'],
    "TipoCliente"=>$_SESSION['TipoCliente'],
    "DataAtual"=>date("Y-m-d")
]);

$mesesPagamento=array();
for($i=1;$i<=12;$i++){$mesesPagamento+=[$i=>00.00];}
$mesesContrato=array();
for($i=1;$i<=12;$i++){$mesesContrato+=[$i=>00.00];}
$mesesNota=array();
for($i=1;$i<=12;$i++){$mesesNota+=[$i=>00.00];}

foreach($dados['Pagamento'] as $key=>$value){$mesesPagamento[$value['Mes']]=(float)$value['Valor'];}
foreach($dados['Contrato'] as $key=>$value){$mesesContrato[$value['Mes']]=(float)$value['Valor'];}
foreach($dados['Nota'] as $key=>$value){$mesesNota[$value['Mes']]=(float)$value['Valor'];}
?>
<script>
    const chartsGastos = document.querySelector(".chart.gastos");
    const ctxGastos = chartsGastos.getContext('2d');
    const myChartGastos = new Chart(ctxGastos, {
        type: 'bar',
        data: {
            labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
            datasets: [
                {
                    label:  'Pagamento',
                    data: [<?php echo("{$mesesPagamento[1]},{$mesesPagamento[2]},{$mesesPagamento[3]},{$mesesPagamento[4]},{$mesesPagamento[5]},{$mesesPagamento[6]},{$mesesPagamento[7]},{$mesesPagamento[8]},{$mesesPagamento[9]},{$mesesPagamento[10]},{$mesesPagamento[11]},{$mesesPagamento[12]}");?>],
                      backgroundColor: [
                        "rgba(255, 99, 132, 0.2)"
                      ],
                      borderColor: [
                        "rgba(255, 99, 132, 1)"
                      ],
                    borderWidth: 1
                },
                {
                    label:  'Contrato',
                    data: [<?php echo("{$mesesContrato[1]},{$mesesContrato[2]},{$mesesContrato[3]},{$mesesContrato[4]},{$mesesContrato[5]},{$mesesContrato[6]},{$mesesContrato[7]},{$mesesContrato[8]},{$mesesContrato[9]},{$mesesContrato[10]},{$mesesContrato[11]},{$mesesContrato[12]}");?>],
                      backgroundColor: [
                        "rgba(54, 162, 235, 0.2)"
                      ],
                      borderColor: [
                        "rgba(54, 162, 235, 1)"
                      ],
                    borderWidth: 1
                },
                {
                    label:  'Nota',
                    data: [<?php echo("{$mesesNota[1]},{$mesesNota[2]},{$mesesNota[3]},{$mesesNota[4]},{$mesesNota[5]},{$mesesNota[6]},{$mesesNota[7]},{$mesesNota[8]},{$mesesNota[9]},{$mesesNota[10]},{$mesesNota[11]},{$mesesNota[12]}");?>],
                      backgroundColor: [
                        "rgba(237, 142, 13  , 0.2)"
                      ],
                      borderColor: [
                        "rgba(237, 142, 13  , 1)"
                      ],
                    borderWidth: 1
                }
            ]
            
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                    
                }
            }
        }
    });
   
</script>
