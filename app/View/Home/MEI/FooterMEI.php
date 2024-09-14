<script>
    /*const chartsLimeteDispesas = document.querySelector(".chart.limeteDispesas");
    const ctxLimeteDispesas = chartsLimeteDispesas.getContext('2d');
    const myChartLimeteDispesas = new Chart(ctxLimeteDispesas, {
        type: 'bar',
        data: {
            labels: ["Dispesas"],
            datasets: [{
                label: '<?php $limiteDispesas=$limite+($limite*0.2); echo("Seu limite é: {$limiteDispesas}");?>',
                data: [<?php echo("8000");?>],
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
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: <?php  echo("{$limiteDispesas}"); ?>
                }     
            }
        }
    });*/
</script>
<script>
   /* const chartsLimeteCompras = document.querySelector(".chart.limeteCompras");
    const ctxLimeteCompras = chartsLimeteCompras.getContext('2d');
    const myChartLimeteCompras = new Chart(ctxLimeteCompras, {
        type: 'bar',
        data: {
            labels: ["Compras"],
            datasets: [{
                label: '<?php $limiteCompra=$limite*0.8; echo("Seu limite é:{$limiteCompra}"); ?>',
                data: [<?php echo("8000");?>],
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
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: <?php echo("{$limiteCompra}"); ?>
                }     
            }
        }
    });*/
</script>
<script>
    const chartsLimeteGastos = document.querySelector(".chart.limeteGastos");
    const ctxLimeteGastos  = chartsLimeteGastos.getContext('2d');
    const myChartLimeteGastos = new Chart(ctxLimeteGastos, {
        type: 'bar',
        data: {
            labels: ["Gastos"],
            datasets: [{
                label: '<?php echo("Seu limite é: {$limite}"); ?>',
                data: [<?php echo("8000");?>],
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
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: <?php echo("{$limite}");?>
                }     
            }
            
        }
    });
</script>