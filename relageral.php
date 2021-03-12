<?php
include "conexao.php";
date_default_timezone_set("America/Cuiaba");
$pdo = conectar("membros");
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$fp = fopen("registra.txt", "a");
 
// Escreve "exemplo de escrita" no bloco1.txt
$conteudo = "$ip\r\n";
$escreve = fwrite($fp, $conteudo);
 
// Fecha o arquivo
fclose($fp);
?>
<!doctype html>
<html lang="pt-BR" class="fixed">
    <head>
        <?php include 'cabecalho.php'; ?>
        <script src="vendor/pace/pace.min.js"></script>
        <link href="vendor/pace/pace-theme-minimal.css" rel="stylesheet" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="vendor/animate.css/animate.css">
        <link rel="stylesheet" href="vendor/toastr/toastr.min.css">
        <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css">
        <link rel="stylesheet" href="stylesheets/css/style.css">
        <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
        <link rel="stylesheet" href="vendor/select2/css/select2-bootstrap.min.css">
        <link rel="stylesheet" href="vendor/bootstrap_date-picker/css/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="vendor/bootstrap_time-picker/css/timepicker.css">
        <link rel="stylesheet" href="vendor/bootstrap_color-picker/css/bootstrap-colorpicker.min.css">
    </head>
    <body>
        <div class="panel">
            <div class="panel-header panel-success">
                <h4>Caso seu nome não apareça listado abaixo, solicite o cadastro 
                    juntamente ao FURRIEL de sua SU. Dúvidas quanto ao acesso e senha,
                    deverá reportar ao pessoal da SEÇÃO DE INFORMÁTICA. O cadastro
                    para o novo SISTEMA DE ARRANCHAMENTO funciona também para o 
                    sistema de PLANO DE CHAMADAS</h4>
                <?php
                $consultausu = $pdo->prepare("SELECT * FROM usuarios WHERE userativo = 'S' ORDER BY idpgrad, nomeguerra ASC");
                $consultausu->execute();
                $qtdusers = $consultausu->fetchAll(PDO::FETCH_ASSOC);
                $qtd_users = count($qtdusers);
                ?>
            </div>
            <div class="panel-content">
                <div class="table-responsive">                                                    
                    <form action="#">
                        <table class="table table-striped table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>ID Usuário</th>
                                    <th>P/G</th>
                                    <th>Nome guerra</th>
                                    <th>Subunidade</th>
                                    <th>Identidade</th>
                                    <th>Senha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $qtd_users; $i++) {
                                    $reg = $qtdusers[$i];
                                    //Pesquisa Posto Graduação
                                    $consultapg = $pdo->prepare("SELECT * FROM postograd WHERE id = :idpg");
                                    $regidpgrad = $reg['idpgrad'];
                                    $consultapg->bindParam(":idpg", $regidpgrad, PDO::PARAM_STR);
                                    $consultapg->execute();
                                    $opostograd = $consultapg->fetchAll(PDO::FETCH_ASSOC);
                                    $regpg = $opostograd[0];
                                    //Pesquisa Subunidade
                                    $regsu = $reg['idsubunidade'];
                                    $consultasu = $pdo->prepare("SELECT * FROM subunidade WHERE id = :idsu");
                                    $consultasu->bindParam(":idsu", $regsu, PDO::PARAM_STR);
                                    $consultasu->execute();
                                    $asu = $consultasu->fetchAll(PDO::FETCH_ASSOC);
                                    $descsu = $asu[0];
                                    echo("<tr>");
                                    echo("<td>" . $reg['id'] . "</td>");
                                    echo("<td>" . $regpg['postograd'] . "</td>");
                                    echo("<td>" . $reg['nomeguerra'] . "</td>");
                                    echo("<td>" . $descsu['descricao'] . "</td>");
                                    if ($reg['identidade'] <> "") {
                                        $idt = "OK";
                                    } else {
                                        $idt = "SEM ACESSO";
                                    }
                                    if ($reg['senha'] <> "") {
                                        $snh = "OK";
                                    } else {
                                        $snh = "SEM ACESSO";
                                    }
                                    echo("<td>" . $idt . "</td>");
                                    echo("<td>" . $snh . "</td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="mb-md">
                        </div>
                        <div class="clearfix">
                            <h3>Total listado: <?php echo($qtd_users); ?></h3>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    <script src="vendor/jquery/jquery-1.12.3.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/nano-scroller/nano-scroller.js"></script>
    <script src="javascripts/template-script.min.js"></script>
    <script src="javascripts/template-init.min.js"></script>
    <script src="vendor/bootstrap_max-lenght/bootstrap-maxlength.js"></script>
    <script src="vendor/select2/js/select2.min.js"></script>
    <script src="vendor/input-masked/inputmask.bundle.min.js"></script>
    <script src="vendor/input-masked/phone-codes/phone.js"></script>
    <script src="vendor/bootstrap_date-picker/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap_time-picker/js/bootstrap-timepicker.js"></script>
    <script src="vendor/bootstrap_color-picker/js/bootstrap-colorpicker.min.js"></script>
    <script src="javascripts/examples/forms/advanced.js"></script>
</body>
</html>
