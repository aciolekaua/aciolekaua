function html_to_excel($seletor,$nameFile){
    $seletor=$seletor.toString();
    $nameFile=$nameFile.toString();
    var table2excel = new Table2Excel();
    table2excel.export(document.querySelectorAll($seletor),$nameFile);
}
  
