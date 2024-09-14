<?php
 if($_SESSION['TipoCliente']=="PF"){
    if(isset($_POST['pj']) && !empty($_POST['pj'])){
        
        $Cnpj=(string)filter_input(INPUT_POST,'pj', FILTER_SANITIZE_SPECIAL_CHARS);
        $Validate->validateCNPJ($Cnpj);
        $Validate->validateIssetCNPJ($Cnpj,"verifivar existencia");
        $dados=$Validate->validateGetNota($_SESSION['ID'],$_SESSION['TipoCliente'],$_SESSION['TipoPermissao'],$Cnpj);
        
        if(!$dados){
            
        }else{
            $lNum=(count($dados));
            for($l=0;$l<=$lNum-1;$l++){
                $dados[$l]['Valor']=number_format($dados[$l]['Valor'], 2, ',', '.');
                $dados[$l]['DataDeEnvio']=date_format(date_create($dados[$l]['DataDeEnvio']),"d/m/Y H:i:s");
                $dados[$l]['Data']=date_format(date_create($dados[$l]['Data']),"d/m/Y");
                echo"<tr>";
                if($exclusao || $conselho){
                    $cnpj=$GestaoDeConselho->getCNPJ_IdTabela($dados[$l]['ID'],"Nota");
                    $CNPJ=$cnpj['dados']['str_empresa_Nota'];
                    $c=$GestaoDeConselho->issetAprovacao([
                        "IdTabela"=>$dados[$l]['ID'],
                        "cnpj"=>$CNPJ,
                        "cpf"=>$_SESSION['ID']
                        ],"Nota");
                    if($c<=0){
                        echo"<td><input class='form-check-input' type='checkbox' name='sel[]' value='{$dados[$l]['ID']}' /></td>";
                    }else{
                        echo"<td><input class='form-check-input' type='checkbox' name='checked' checked disabled/></td>";
                    }
                }
                echo"<td>{$dados[$l]['DataDeEnvio']}</td>";
                echo"<td>{$dados[$l]['PJ']}</td>";
                echo"<td>{$dados[$l]['PF']}</td>";
                echo"<td>{$dados[$l]['Prestador']}</td>";
                echo"<td>R$ {$dados[$l]['Valor']}</td>";
                echo"<td>{$dados[$l]['Data']}</td>";
                echo"<td><a href={$dados[$l]['Arquivo']} target=_blank >{$dados[$l]['Arquivo']}<a></td>";
                echo"</tr>";
            }
        }
    }
}else if($_SESSION['TipoCliente']=="PJ"){
    $dados=$Validate->validateGetNota($_SESSION['ID'],$_SESSION['TipoCliente']);
    
    $lNum=(count($dados));
    for($l=0;$l<=$lNum-1;$l++){
        $dados[$l]['Valor']=number_format($dados[$l]['Valor'], 2, ',', '.');
        $dados[$l]['DataDeEnvio']=date_format(date_create($dados[$l]['DataDeEnvio']),"d/m/Y H:i:s");
        $dados[$l]['Data']=date_format(date_create($dados[$l]['Data']),"d/m/Y");
        echo"<tr>";
        echo"<td><input class='form-check-input' type='checkbox' name='sel[]' value='{$dados[$l]['ID']}' /></td>";
        echo"<td>{$dados[$l]['DataDeEnvio']}</td>";
        echo"<td>{$dados[$l]['PJ']}</td>";
        echo"<td>{$dados[$l]['PF']}</td>";
        echo"<td>{$dados[$l]['Prestador']}</td>";
        echo"<td>R$ {$dados[$l]['Valor']}</td>";
        echo"<td>{$dados[$l]['Data']}</td>";
        echo"<td><a href={$dados[$l]['Arquivo']} target=_blank >{$dados[$l]['Arquivo']}<a></td>";
        $d=$Validate->validateGetVotacaoConselho(
        ["cnpj"=>$_SESSION['ID'],"IdTabela"=>$dados[$l]['ID']],
        "Nota"
        );
        if($d!=false){
            $y=0;
            $n=count($numConselherios);
            if($n>0){
                foreach($d as $key => $value){if(!empty($value[0])){echo"<td>{$value[0]}</td>"; $y++;}}
                if($y<$n){for($o=1;$o<=($n-$y);$o++){echo"<td></td>";}}
            }
        }else{
            $n=count($numConselherios);
            for($o=1;$o<=$n;$o++){echo"<td></td>";}
        }
        echo"</tr>";
    }
}
?>