<?php
require "versession.php";
include "conexao.php";
date_default_timezone_set("America/Cuiaba");
$datarancho = filter_input(INPUT_POST, "datarancho");

// VERIFICA A DISPONIBILIDADE DE DATAS
$convdata = strtotime(date_converter($datarancho));

$ds = date('D'); // pega o dia da semana da data atual

$dtlimite = date('Y-m-d', strtotime("+1 days"));
$dtcinco = date('Y-m-d', strtotime("+5 days"));
$dtquatro = date('Y-m-d', strtotime("+4 days"));
$dttres = date('Y-m-d', strtotime("+3 days"));

if ($convdata <= strtotime($dtlimite)) {
    $msgerro = base64_encode('DATA DEVE TER MAIS DE DOIS DIAS!');
    header("Location: index.php?token=' . $msgerro");
}

if ($ds == 'Thu') { //verifica se o dia da semana é quinta-feira
    if ($convdata < strtotime($dtquatro)) {
        $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', strtotime($dtquatro)));
        header("Location: index.php?token=' . $msgerro");
    }
}

if ($ds == 'Fri') { //verifica se o dia da semana é sexta-feira
    if ($convdata < strtotime($dtquatro)) {
        $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', strtotime($dtquatro)));
        header("Location: index.php?token=' . $msgerro");
    }
}

if ($ds == 'Sat') { //verifica se o dia da semana é sábado
    if ($convdata < strtotime($dttres)) {
        $msgerro = base64_encode("ARRANCHAMENTO LIBERADO SOMENTE A PARTIR DE " . date('d/m/Y', strtotime($dttres)));
        header("Location: index.php?token=' . $msgerro");
    }
}

$p1 = conectar("membros");
$p2 = conectar2("arranchamento"); // nova conexão com base de dados secundária
$sistema = base64_encode($_SESSION['sistema2']);
$idmembro = $_SESSION['user_id2'];
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
                                    <i class="fa fa-cutlery" aria-hidden="true">
                                    </i>
                                    <a href="#">Arranchamento em uma data específica</a>
                                </li>
                            </ul>
                        </div>
                    </div>                    
                    <div class="row animated fadeInUp">
                        <div class="col-sm-12">                             
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="panel">
                                        <div class="panel-header panel-success">
                                            <h3 class="panel-title">Arranchamento para o dia <?php echo($datarancho); ?></h3>
                                            <div class="panel-actions">
                                                <ul>
                                                    <li class="action toggle-panel panel-expand"><span></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-content">
                                            <div class="table-responsive">                                                
                                                <form action="gravaranchodia.php?dtr=<?php echo($datarancho); ?>" method="post">
                                                    <table class="table table-striped table-hover table-bordered text-center">
                                                        <?php
                                                        // PESQUISA SE EXISTE CARDÁPIO NO DIA
                                                        $psqcardapio = $p2->prepare("SELECT * FROM cardapio WHERE data = :data");
                                                        $psqcardapio->bindParam(':data', $datarancho);
                                                        $psqcardapio->execute();
                                                        $mcardapio = $psqcardapio->fetchAll(PDO::FETCH_ASSOC);
                                                        if (count($mcardapio) < 1) {
                                                            $cardcafe = "Cardápio não cadastrado.";
                                                            $cardalmoco = "Cardápio não cadastrado.";
                                                            $cardjantar = "Cardápio não cadastrado.";
                                                        } else {
                                                            $diacardapio = $mcardapio[0];
                                                            $cardcafe = $diacardapio['cafe'];
                                                            $cardalmoco = $diacardapio['almoco'];
                                                            $cardjantar = $diacardapio['jantar'];
                                                        }
                                                        // VERIFICA SE FOI ARRANCHADO NESTA DATA.
                                                        $inforancho = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :iduser AND data = :data");
                                                        $inforancho->bindParam(':iduser', $idmembro);
                                                        $inforancho->bindParam(':data', $datarancho);
                                                        $inforancho->execute();
                                                        $rancho = $inforancho->fetchAll(PDO::FETCH_ASSOC);
                                                        if (count($rancho) < 1) {
                                                            $ocafe = "";
                                                            $oalmoco = "";
                                                            $ojantar = "";
                                                        } else {
                                                            $dadosrancho = $rancho[0];
                                                            $ocafe = $dadosrancho['cafe'];
                                                            $oalmoco = $dadosrancho['almoco'];
                                                            $ojantar = $dadosrancho['jantar'];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>Refeição</td>
                                                            <td>Cardápio</td>
                                                        </tr>
                                                        <?php
                                                        if ($ocafe == "SIM") {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="ocafe" value="SIM" checked> Café</td>
                                                                <td><?php echo($cardcafe);?></td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="ocafe" value="SIM"> Café</td>
                                                                <td><?php echo($cardcafe);?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($oalmoco == "SIM") {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="oalmoco" value="SIM" checked> Almoço</td>
                                                                <td><?php echo($cardalmoco);?></td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="oalmoco" value="SIM"> Almoço</td>
                                                                <td><?php echo($cardalmoco);?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($ojantar == "SIM") {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="ojantar" value="SIM" checked> Jantar</td>
                                                                <td><?php echo($cardjantar);?></td>
                                                            </tr>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td><input type="checkbox" name="ojantar" value="SIM"> Jantar</td>
                                                                <td><?php echo($cardjantar);?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
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