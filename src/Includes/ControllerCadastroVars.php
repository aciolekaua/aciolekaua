<?php
    use Src\Classes\ClassValidate;
    $Validade=new ClassValidate;
    if(isset($_POST['nome'])){
        $nome=filter_input(INPUT_POST,'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateNome($nome)){array_push($arrayPost,$nome);}
    }
    if(isset($_POST['email'])){
        $email=filter_input(INPUT_POST,'email', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateEmail($email)){array_push($arrayPost,$email);}
    }
    if(isset($_POST['cpf'])){
        $cpf=filter_input(INPUT_POST,'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateCPF($cpf)){array_push($arrayPost,$cpf);}
    }
    if(isset($_POST['tel'])){
        $tel=filter_input(INPUT_POST,'tel', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateTelefone($tel)){array_push($arrayPost,$tel);}
    }
    if(isset($_POST['cep'])){
        $cep=filter_input(INPUT_POST,'cep', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateCEP($cep)!=false){array_push($arrayPost,$cep);}
    }
    if(isset($_POST['dtnascimento'])){
        $dtNascimento=filter_input(INPUT_POST,'dtnascimento', FILTER_SANITIZE_SPECIAL_CHARS);
        if($Validade->validateData($dtNascimento)){array_push($arrayPost,$dtNascimento);}
    }
    if(isset($_POST['endereco'])){
        $endereco=filter_input(INPUT_POST,'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
        array_push($arrayPost,$endereco);
    }
    if(isset($_POST['numero'])){
        $numero=filter_input(INPUT_POST,'numero', FILTER_SANITIZE_SPECIAL_CHARS);
        array_push($arrayPost,$numero);
    }
    if(isset($_POST['complemento'])){
        $complemento=filter_input(INPUT_POST,'complemento', FILTER_SANITIZE_SPECIAL_CHARS);
        //array_push($arrayPost,$complemento);
    }
    if(isset($_POST['bairro'])){
        $bairro=filter_input(INPUT_POST,'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
        array_push($arrayPost,$bairro);
    }
    if(isset($_POST['cidade'])){
        $cidade=filter_input(INPUT_POST,'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
        array_push($arrayPost,$cidade);
    }
    if(isset($_POST['uf'])){
        $uf=filter_input(INPUT_POST,'uf', FILTER_SANITIZE_SPECIAL_CHARS);
        array_push($arrayPost,$uf);
    }
    if(isset($_POST['senha'])){
        $senha=filter_input(INPUT_POST,'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha=$objPass->passHash($senha,$const);
        array_push($arrayPost,$senha);
    }
?>