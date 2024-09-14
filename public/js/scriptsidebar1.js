window.addEventListener("load", ()=>{
   
    if(sessionStorage.getItem('TipoCliente')=="PJ"){
        var TipoClientePF = document.querySelectorAll(".TipoClientePF");
        for(let i=0;i<=(TipoClientePF.length-1);i++){
            TipoClientePF[i].style.display='none';
        }
    }else if(sessionStorage.getItem('TipoCliente')=="PF"){
        var TipoClientePJ = document.querySelectorAll(".TipoClientePJ");
        for(let i=0;i<=(TipoClientePJ.length-1);i++){
            TipoClientePJ[i].style.display='none';
        }
    }
    
    $.ajax({
        url:getRoot('home/dadosSideBar'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            const dadosPerfil = document.querySelector("div#dadosPerfil");
            dadosPerfil.innerHTML='';
            if(data.nome!="" && data.nome!=null && data.nome!=undefined){
                dadosPerfil.innerHTML+='<h4 class="text-matrix">'+data.nome+'</h4>';
            }
            if(data.id!="" && data.id!=null && data.id!=undefined){
                if(data.id.length>11){
                    data.id = data.id.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, "$1.$2.$3/$4-$5");
                }else{
                    data.id = data.id.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, "$1.$2.$3-$4");
                }
                dadosPerfil.innerHTML+='<small class="text-matrix">'+data.id+'</small>';
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });

});

const data = {
  // labels: ['Jan', 'Fev', 'Mar','Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  labels: ['Bom', 'Ruim', 'Risco'],
  datasets: [{
    label: 'Weekly Sales',
    // data: [5550, 5633, 5800, 5988, 4811, 4399, 2121, 4177, 6700, 6733, 12000, 14000],
    data: [50000, 18000, 13000],
    backgroundColor: [
      '#2fa52d',
      '#ffc15e',
      '#f42d2d',
    ],
    needleValue: 23000,
    borderColor:'#afb7bf',
    borderWidth: 2,
    cutout: '95%',
    circumference: 180,
    rotation: 270,
    borderRadius:5,
  }]
};

  // gaugeNeedle
  const gaugeNeedle = {
    id: 'gaugeNeedle',
    afterDatasetDraw(chart, args, options) {
      const { ctx, config, data, chartArea: { top, bottom, left, right, 
        width, height } } = chart;

      ctx.save();
      // console.log(data);
      const needleValue = data.datasets[0].needleValue;
      const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0)
      const angle = Math.PI + (1 / dataTotal * needleValue * Math.PI)
      // const angle = dataTotal / needleValue
      const cx = width / 2;
      const cy = chart._metasets[0].data[0].y;
      // console.log(chart._metasets[0].data[0].y);
      // console.log(ctx);
      
      // needle
      ctx.translate(cx, cy);
      ctx.rotate(angle);
      ctx.beginPath();
      ctx.moveTo(0, -2);
      ctx.lineTo((cy / 1.8)  + 20, 0);
      ctx.lineTo(0, 2);
      ctx.fillStyle ='#afb7bf';
      ctx.fill();
      ctx.restore();

      // needle dot
      ctx.beginPath();
      ctx.arc(cx, cy, 5, 0, 10);
      ctx.fill();
      ctx.restore();
      
      const calculo = 81000 - needleValue;


      ctx.font = '16px Helvetica';
      ctx.fillStyle = '#afb7bf';
      ctx.fillText('Total 12 Meses: ' +'R$ ' + calculo, cx, cy + 30);
      ctx.textAlign = 'center';
      ctx.restore();
    }
  }
 // config 
 const config = {
  type: 'doughnut',
  data,
  options: {
    plugins:{
      legend: {
        display: false
      },
      tooltip: {
        yAlign: 'bottom',
        displayColors: false,
        callbacks: {
          label: function(tooltipItem, data, value) {
            const tracker = tooltipItem.dataset.needleValue;
            return `Limite Usado: ${tracker}`;
          }
        }
      }
    }
  },
  plugins: [gaugeNeedle]
};
// render init block
const limite = new Chart(
  document.getElementById('myChartLimite'),
  config
);