<?php
require "versession.php";
include "conexao.php";
$idusuario = filter_input(INPUT_POST, "usuario");
$p1 = conectar("membros");
$consulta = $p1->prepare("SELECT * FROM usuarios WHERE id = $idusuario AND userativo = 'S'");
$consulta->execute();
$users = $consulta->fetchAll(PDO::FETCH_ASSOC);
$user = $users[0];
$nomeguerra = $user['nomeguerra'];
$idpgrad = $user['idpgrad'];
$consultapg = $p1->prepare("SELECT * FROM postograd WHERE id = $idpgrad");
$consultapg->execute();
$pgd = $consultapg->fetchAll(PDO::FETCH_ASSOC);
$pgd2 = $pgd[0];
$postograd = $pgd2['pgradsimples'];
$oarranchado = $postograd . " " . $nomeguerra;
$sistema = base64_encode($_SESSION['sistema2']);
$p2 = conectar2("arranchamento"); // nova conexão com base de dados secundária
$somadias = 2;
$diasemana = date('D');
if ($diasemana == 'Thu') { // verifica se o dia da semana é quinta-feira
    $somadias = 4;
}
if ($diasemana == 'Fri') { // verifica se o dia da semana é sexta-feira
    $somadias = 4;
}
if ($diasemana == 'Sat') { // verifica se o dia da semana é sábado
    $somadias = 3;
}
$contadias = $somadias;
for ($i = 0; $i < 10; $i++) {
    $odia[$i] = date('d/m/Y', strtotime("+" . $contadias . " days"));
    $semana[$i] = date('D', strtotime("+" . $contadias . " days"));
    $contadias++;
    if ($semana[$i] == "Sun") {
        $semana[$i] = "Domingo";
    }
    if ($semana[$i] == "Mon") {
        $semana[$i] = "Segunda-feira";
    }
    if ($semana[$i] == "Tue") {
        $semana[$i] = "Terça-feira";
    }
    if ($semana[$i] == "Wed") {
        $semana[$i] = "Quarta-feira";
    }
    if ($semana[$i] == "Thu") {
        $semana[$i] = "Quinta-feira";
    }
    if ($semana[$i] == "Fri") {
        $semana[$i] = "Sexta-feira";
    }
    if ($semana[$i] == "Sat") {
        $semana[$i] = "Sábado";
    }
}
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
                                    <a href="#"><?php echo($_SESSION['sistema2']); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>                    
                    <div class="row animated fadeInUp">
                        <div class="col-sm-12">                             
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="panel">
                                        <div class="panel-header panel-success">
                                            <h3 class="panel-title">Arranchamento para o <?php echo($oarranchado); ?></h3>
                                            <div class="panel-actions">
                                                <ul>
                                                    <li class="action toggle-panel panel-expand"><span></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-content">
                                            <div class="table-responsive">                                                
                                                <form action="dezdiasind.php?soma=<?php echo($somadias); ?>&usr=<?php echo($idusuario); ?>" method="post">
                                                    <table class="table table-striped table-hover table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Dia Semana</th>
                                                                <th>Data</th>
                                                                <th>Café</th>
                                                                <th>Almoço</th>
                                                                <th>Jantar</th>
                                                                <th>Cardápio</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            for ($i = 0; $i < 10; $i++) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo($semana[$i]); ?></td>
                                                                    <td><?php echo($odia[$i]); ?></td>
                                                                    <?php
                                                                    $inforancho = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :iduser AND data = :data");
                                                                    $inforancho->bindParam(':iduser', $idusuario);
                                                                    $inforancho->bindParam(':data', $odia[$i]);
                                                                    $inforancho->execute();
                                                                    $rancho = $inforancho->fetchAll(PDO::FETCH_ASSOC);
                                                                    if (count($rancho) < 1) {
                                                                        $ocafe[$i] = "";
                                                                        $oalmoco[$i] = "";
                                                                        $ojantar[$i] = "";
                                                                    } else {
                                                                        $dadosrancho = $rancho[0];
                                                                        $ocafe[$i] = $dadosrancho['cafe'];
                                                                        $oalmoco[$i] = $dadosrancho['almoco'];
                                                                        $ojantar[$i] = $dadosrancho['jantar'];
                                                                    }
                                                                    if ($ocafe[$i] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" name="<?php echo("ocafe" . $i . ""); ?>" value="SIM" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" value="SIM" name="<?php echo("ocafe" . $i . ""); ?>"></td>
                                                                        <?php
                                                                    }
                                                                    if ($oalmoco[$i] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" value="SIM" name="<?php echo("oalmoco" . $i . ""); ?>" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" name="<?php echo("oalmoco" . $i . ""); ?>" value="SIM"></td>
                                                                        <?php
                                                                    }
                                                                    if ($ojantar[$i] == "SIM") {
                                                                        ?>
                                                                        <td><input type="checkbox" name="<?php echo("ojantar" . $i . ""); ?>" value="SIM" checked></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><input type="checkbox" name="<?php echo("ojantar" . $i . ""); ?>" value="SIM"></td>
                                                                        <?php
                                                                    }
                                                                    $psqcardapio = $p2->prepare("SELECT * FROM cardapio WHERE data = :data");
                                                                    $psqcardapio->bindParam(':data', $odia[$i]);
                                                                    $psqcardapio->execute();
                                                                    $mcardapio = $psqcardapio->fetchAll(PDO::FETCH_ASSOC);
                                                                    $cardia = $odia[$i];
                                                                    if (count($mcardapio) < 1) {
                                                                        ?>
                                                                        <td>
                                                                            <a> <i class="fa fa-close"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>                                                                                
                                                                            <a href="<?php echo('mostracard.php?out=' . $cardia); ?>" class='fa fa-eye' data-toggle='modal' data-target='#lg-modal'></a>                                                                                   
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <?php
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
        <div class="modal fade" id="lg-modal" tabindex="-1" role="dialog" aria-labelledby="modal-large-label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header state modal-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-large-label">Large modal</h4>
                    </div>
                    <div class="modal-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aspernatur dignissimos minima nostrum omnis sapiente! Aut, culpa cum cupiditate, delectus dolor eos esse, harum id illo in maxime minima molestiae nostrum odio recusandae sunt voluptates? Autem esse ipsum libero saepe.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery-1.12.3.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.js"></script>
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