
var opt = {
    margin: 1,
    filename: 'Nota Fiscal.pdf',
    image: {type:'jpeg', quality:1},
    html2canvas: {scale:2},
    jsPDF: {
        orientation: 'p',
        unit: 'ex',
        format: 'a4',
        putOnlyUsedFonts:true,
        floatPrecision: 16 
        
    }
}
html2pdf().set(opt).from(document.body.innerHTML).save();
 console.log('oi');