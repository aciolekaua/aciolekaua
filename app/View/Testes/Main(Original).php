<div id='divMensage'></div>
<form action="<?php echo(DIRPAGE."teste/cadastroempresaAPI");?>" method="post" enctype="multipart/form-data">
    <!--<input class='form-control' type='file' name='xml[]' accept='.xml' multiple/>-->
    <input class='form-control' type='file' name='certificado' accept='.pfx'/>
    <input class='btn btn-success' type='submit' name='enviar' value='Enviar'/>
</form>