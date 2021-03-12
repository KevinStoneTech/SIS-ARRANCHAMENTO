<?php
require "versession.php";
include "conexao.php";
$pdo = conectar("membros");
$pdo2 = conectar2("arranchamento");
$datarancho = filter_input(INPUT_POST, "datarancho");
$meuidsu = $_SESSION['user_idsubun2'];
$convdata = strtotime(date_converter($datarancho));

$ds = date('D'); // pega o dia da semana da data atual

$dtlimiteA = date('Y-m-d', strtotime("+2 days"));
$dtlimite = strtotime($dtlimiteA);
$dtcincoA = date('Y-m-d', strtotime("+5 days"));
$dtcinco = strtotime($dtcincoA);
$dtquatroA = date('Y-m-d', strtotime("+4 days"));
$dtquatro = strtotime($dtquatroA);
$dttresA = date('Y-m-d', strtotime("+3 days"));
$dttres = strtotime($dttresA);
$erro = 0;

if ($convdata < $dtlimite) {
    $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', $dtlimite));
    $erro = 1;
}

if ($ds == 'Fri') { //verifica se o dia da semana � sexta-feira
    if ($convdata < $dttres) {
        $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', $dtquatro));
        $erro = 1;
    }
}

if ($ds == 'Sat') { //verifica se o dia da semana � s�bado
    if ($convdata < $dttres) {
        $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', $dttres));
        $erro = 1;
    }
}
if ($erro < 1) {
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
            <div class="wrap">
                <div class="page-header">
                    <div class="leftside-header">
                        <?php include 'copright.php' ?>
                        <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open"
                             data-target="html">
                            <i class="fa fa-bars" aria-label="Toggle sidebar">
                            </i>
                        </div>
                    </div>
                    <?php include 'painel_usu.php'; ?>
                </div>
                <div class="page-body">
                    <div class="left-sidebar">
                        <!-- left sidebar HEADER -->
                        <div class="left-sidebar-header">
                            <div class="left-sidebar-title">
                                Menu de Navegação
                            </div>
                            <div class="left-sidebar-toggle c-hamburger c-hamburger--htla hidden-xs"
                                 data-toggle-class="left-sidebar-collapsed" data-target="html">
                                <span>
                                </span>
                            </div>
                        </div>
                        <?php include 'menu_opc.php'; ?>
                    </div>
                    <div class="content">
                        <div class="content-header">
                            <div class="leftside-content-header">
                                <ul class="breadcrumbs">
                                    <li>
                                        <i class="fa fa-home" aria-hidden="true">
                                        </i>
                                        <a href="#">Arranchamento por seleção em <?php echo($datarancho) ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>                    
                        <div class="row animated fadeInUp">
                            <div class="col-sm-12">                             
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel">
                                            <div class="panel-header panel-success">
                                                <?php
                                                if ($_SESSION['user_numconta2'] == "2") { // CONTA DO FURRIEL
                                                    $consultausu = $pdo->prepare("SELECT * FROM usuarios WHERE idsubunidade = :idsubunidade AND userativo = 'S' ORDER BY idpgrad, nomeguerra ASC");
                                                    $consultausu->bindParam(":idsubunidade", $meuidsu, PDO::PARAM_STR);
                                                } else {
                                                    $consultausu = $pdo->prepare("SELECT * FROM usuarios WHERE userativo = 'S' ORDER BY idpgrad, nomeguerra ASC");
                                                }
                                                $consultausu->execute();
                                                $qtdusers = $consultausu->fetchAll(PDO::FETCH_ASSOC);
                                                $qtd_users = count($qtdusers);
                                                ?>
                                                <h3 class="panel-title">Marque/Desmarque os arranchamentos abaixo listados <?php echo("(" . $qtd_users . ")"); ?> referentes ao dia <?php echo($datarancho) ?></h3>
                                                <div class="panel-actions">
                                                    <ul>
                                                        <li class="action toggle-panel panel-expand"><span></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-content">
                                                <div class="table-responsive">                                                    
                                                    <form action="gravselect.php<?php echo("?qtduser=$qtd_users&datarancho=$datarancho") ?>" method="post">
                                                        <table class="table table-striped table-hover table-bordered text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID Usuário</th>
                                                                    <th>P/G</th>
                                                                    <th>Nome guerra</th>
                                                                    <th>Cafe</th>
                                                                    <th>Almoço</th>
                                                                    <th>Jantar</th>
                                                                    <th>Responsável</th>
                                                                    <th>Situação</th>
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
                                                                    echo("<tr>");
                                                                    $userid = "userid" . $i;
                                                                    $nmgrr = "nomeguerra" . $i;
                                                                    $useridpg = "useridpg" . $i;
                                                                    $useridsu = "useridsu" . $i;
                                                                    $_SESSION[$userid] = $reg['id'];
                                                                    $_SESSION[$nmgrr] = $reg['nomeguerra'];
                                                                    $_SESSION[$useridpg] = $regidpgrad;
                                                                    $_SESSION[$useridsu] = $reg['idsubunidade'];
                                                                    echo("<td>" . $_SESSION[$userid] . "</td>");
                                                                    echo("<td>" . $regpg['pgradsimples'] . "</td>");
                                                                    echo("<td>" . $_SESSION[$nmgrr] . "</td>");
                                                                    //Pesquisa situação de arranchamento
                                                                    $consultarancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :datarancho AND iduser = :iduser");
                                                                    $consultarancho->bindParam(":datarancho", $datarancho, PDO::PARAM_STR);
                                                                    $consultarancho->bindParam(":iduser", $reg['id'], PDO::PARAM_STR);
                                                                    $consultarancho->execute();
                                                                    $orancho = $consultarancho->fetchAll(PDO::FETCH_ASSOC);
                                                                    if (count($orancho) < 1) {
                                                                        ?>
                                                                    <td><input type="checkbox" name=<?php echo("ocafe" . $i . ""); ?> value="SIM"></td>
                                                                    <td><input type="checkbox" name=<?php echo("oalmoco" . $i . ""); ?> value="SIM"></td>
                                                                    <td><input type="checkbox" name=<?php echo("ojantar" . $i . ""); ?> value="SIM"></td>                                                                    
                                                                    <td></td>
                                                                    <td></td>
                                                                    <?php
                                                                } else {
                                                                    $regrancho = $orancho[0];
                                                                    if ($regrancho['cafe'] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("ocafe" . $i . ""); ?> value="SIM" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("ocafe" . $i . ""); ?> value="SIM"></td>
                                                                        <?php
                                                                    }
                                                                    if ($regrancho['almoco'] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("oalmoco" . $i . ""); ?> value="SIM" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("oalmoco" . $i . ""); ?> value="SIM"></td>
                                                                        <?php
                                                                    }
                                                                    if ($regrancho['jantar'] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("ojantar" . $i . ""); ?> value="SIM" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" name=<?php echo("ojantar" . $i . ""); ?> value="SIM"></td>
                                                                        <?php
                                                                    }
                                                                    echo("<td>" . $regrancho['quemgrava'] . "</td>");
                                                                    echo("<td>" . $regrancho['modo'] . "</td>");
                                                                }
                                                                echo("</tr>");
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                        <div class="mb-md">
                                                        </div>
                                                        <div class="clearfix">
                                                            <div class="pull-right">
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="glyphicon glyphicon-hand-right">
                                                                        Confirma
                                                                    </i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
                </div>
            </div>
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
    <?php
} else {
    header('Location: select.php?token=' . $msgerro);
}
?>