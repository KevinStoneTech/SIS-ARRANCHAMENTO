<?php
require "versession.php";
include "conexao.php";
date_default_timezone_set("America/Cuiaba");
$pdo2 = conectar2("arranchamento"); // nova conexão com base de dados secundária
$sistema = base64_encode($_SESSION['sistema2']);
$idmembro = $_SESSION['user_id2'];
$datacardapio = filter_input(INPUT_POST, "datacardapio");
$pesquisa = "SELECT * FROM cardapio WHERE data = :datacardapio";
$stmt = $pdo2->prepare($pesquisa);
$stmt->bindParam(':datacardapio', $datacardapio);
$stmt->execute();
$contcardapio = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($contcardapio) < 1) {
    $cardcafe = "";
    $cardalmoco = "";
    $cardjantar = "";
} else {
    $selecard = $contcardapio[0];
    $cardcafe = $selecard['cafe'];
    $cardalmoco = $selecard['almoco'];
    $cardjantar = $selecard['jantar'];
}
$convdata = strtotime(date_converter($datacardapio));
$dtlimite = date('Y-m-d', strtotime("+1 days"));
if ($convdata <= strtotime($dtlimite)) {
    $editavel = "NAO";
} else {
    $editavel = "SIM";
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
                                    <i class="fa fa-book" aria-hidden="true">
                                    </i>
                                    <a href="#">Cadastro/Consulta de cardápio</a>
                                </li>
                            </ul>
                        </div>
                    </div>                    
                    <div class="row animated fadeInUp">
                        <div class="col-sm-12">
                            <?php
                            if ($editavel == "SIM") {
                                ?>
                                <form class="form-horizontal form-stripe" action="confcardapio.php?dtc=<?php echo($datacardapio); ?>" method="post">
                                    <?php
                                } else {
                                    ?>                                                        
                                    <form class="form-horizontal form-stripe" action="cadcardapio.php" method="post">
                                        <?php
                                    }
                                    ?>                            
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel">                                        
                                                <div class="panel-header  panel-success">
                                                    <h3 class="panel-title"><i class="fa fa-coffee"></i> <i class="fa fa-cutlery"></i> Cardápio do dia <?php echo($datacardapio); ?></h3>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                                
                                        <div class="col-sm-4">                                    
                                            <div class="panel">                                        
                                                <div class="panel-header  panel-warning">
                                                    <h3 class="panel-title"><i class="fa fa-coffee"></i> Café</h3>
                                                    <div class="panel-actions">
                                                        <ul>
                                                            <li class="action toggle-panel panel-expand"><span></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-content">                              
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="textareaMaxLength" class="control-label"></label>
                                                            <?php
                                                            if ($editavel == "SIM") {
                                                                ?>
                                                                <textarea name="cardcafe" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do café da manhã" maxlength="1000" required><?php echo($cardcafe) ?></textarea>
                                                                <?php
                                                            } else {
                                                                ?>                                                        
                                                                <textarea name="cardcafe" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do café da manhã" maxlength="1000" disabled><?php echo($cardcafe) ?></textarea>
                                                                <?php
                                                            }
                                                            ?>
                                                            <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>Máximo de caracteres <span class="code">1000</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-md">
                                                    </div>
                                                    <div class="clearfix">

                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div>
                                        <div class="col-sm-4">                                    
                                            <div class="panel">                                        
                                                <div class="panel-header  panel-warning">
                                                    <h3 class="panel-title"><i class="fa fa-cutlery"></i> Almoço</h3>
                                                    <div class="panel-actions">
                                                        <ul>
                                                            <li class="action toggle-panel panel-expand"><span></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-content">                              
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="textareaMaxLength2" class="control-label"></label>
                                                            <?php
                                                            if ($editavel == "SIM") {
                                                                ?>
                                                                <textarea name="cardalmoco" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do Almoço" maxlength="1000" required><?php echo($cardalmoco) ?></textarea>
                                                                <?php
                                                            } else {
                                                                ?>                                                        
                                                                <textarea name="cardalmoco" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do Almoço" maxlength="1000" disabled><?php echo($cardalmoco) ?></textarea>
                                                                <?php
                                                            }
                                                            ?>                                                        
                                                            <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>Máximo de caracteres <span class="code">1000</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-md">
                                                    </div>
                                                    <div class="clearfix">

                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div>
                                        <div class="col-sm-4">                                    
                                            <div class="panel">                                        
                                                <div class="panel-header  panel-warning">
                                                    <h3 class="panel-title"><i class="fa fa-cutlery"></i> Jantar</h3>
                                                    <div class="panel-actions">
                                                        <ul>
                                                            <li class="action toggle-panel panel-expand"><span></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-content">                              
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="textareaMaxLength3" class="control-label"></label>
                                                            <?php
                                                            if ($editavel == "SIM") {
                                                                ?>
                                                                <textarea name="cardjantar" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do Jantar" maxlength="1000" required><?php echo($cardjantar) ?></textarea>
                                                                <?php
                                                            } else {
                                                                ?>                                                        
                                                                <textarea name="cardjantar" class="form-control" rows="4" id="textareaMaxLength" placeholder="Dados do Jantar" maxlength="1000" disabled><?php echo($cardjantar) ?></textarea>
                                                                <?php
                                                            }
                                                            ?>
                                                            <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>Máximo de caracteres <span class="code">1000</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-md">
                                                    </div>
                                                    <div class="clearfix">
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-hand-right">
                                                        Continua
                                                    </i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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