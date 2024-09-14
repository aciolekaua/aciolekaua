<style>
    #btnQRCode:hover{
        background:#073C8A;
        transition:all 0.7s ease;
    }
    #btnQRCode{transition:all 0.7s ease;}
</style>
<script src="<?php echo(DIRJS."lancamentos/pagemento.js");?>"></script>
<script src="<?php echo(DIRJS."LeitorDeQRCode/html5-qrcode.js")?>"></script>
<script>
    
    function startQRCODE() {
        const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 20, qrbox: 250 });
        
        html5QrcodeScanner.render(onScanSuccess);
        
        console.log(html5QrcodeScanner);
        const qrcodeURL = document.querySelector('input[name=QRCodeURL]');
        const qrcodeURLModal = document.querySelector('div[id=qrcode]');
        const avisoQRCodeURL = document.querySelector('#avisoQRCodeURL');
        const btnQRCode = document.querySelector("#btnQRCode");
        var lastResult, countResults = 0;
        
        function onScanSuccess(decodedText, decodedResult) {
            
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                
                qrcodeURL.value=decodedText;
                
                if(qrcodeURL.value!=""){
                    btnQRCode.setAttribute('class','btn btn-success');
                    btnQRCode.setAttribute('disabled', true);
                    btnQRCode.innerHTML='Copiado <i class="bi bi-check-circle-fill"></i>';
                    html5QrcodeScanner.clear();
                    document.getElementById("html5-qrcode-button-camera-stop").click();
                    $('#qrcode').modal('hide');
                }
            }
        }
        
    }

    document.getElementById("btnCloseModal").addEventListener("click",()=>{
        document.getElementById("html5-qrcode-button-camera-stop").click();
    });
</script>