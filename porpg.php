<?php
require "versession.php";
include "conexao.php";
$token = base64_decode(filter_input(INPUT_GET, "token"));
$p1 = conectar("membros");
$sistema = base64_encode($_SESSION['sistema2']);
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
        </div>
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li>
                            <i class="fa fa-cutlery" aria-hidden="true">
                            </i>
                            <a href="#"> Arranchamento por Posto/Graduação</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="col-sm-12">
                    <form action="gravporpg.php" method="post">
                        <div class="row">                                            
                            <div class="col-sm-4">
                                <div class="panel">
                                    <div class="panel-header  panel-warning">
                                        <h3 class="panel-title">Data</h3>
                                        <div class="panel-actions">
                                            <ul>
                                                <li class="action toggle-panel panel-expand"><span></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-content">
                                        <p>Escolha a data para realizar o arranchamento. </p>
                                        <div class="form-group">
                                            <label for="default-datepicker" class="col-sm-2 control-label ">Data</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date" id="default-datepicker">
                                                    <span class="input-group-addon x-primary"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="datarancho" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel">
                                    <div class="panel-header  panel-warning">
                                        <h3 class="panel-title">Posto/Graduação</h3>
                                        <div class="panel-actions">
                                            <ul>
                                                <li class="action toggle-panel panel-expand"><span></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-content">
                                        <p>Escolha o Posto/Graduação na lista abaixo.</p>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <select name="postograd" id="select2-example-basic" class="form-control" style="width: 100%" required>
                                                        <?php
                                                        $consulta = $p1->prepare("SELECT * FROM postograd ORDER BY id ASC");
                                                        $consulta->execute();
                                                        echo("<optgroup label='Posto / Graduação'>");
                                                        while ($reg = $consulta->fetch(PDO::FETCH_ASSOC)) :
                                                            /* Para recuperar um ARRAY utilize PDO::FETCH_ASSOC */
                                                            echo("<option value=" . $reg['id'] . ">" . $reg['postograd']."</option>");
                                                        endwhile;
                                                        echo("</optgroup>");
                                                        ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="panel">
                                    <div class="panel-header  panel-warning">
                                        <h3 class="panel-title">Refeição</h3>
                                        <div class="panel-actions">
                                            <ul>
                                                <li class="action toggle-panel panel-expand"><span></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-content">
                                        <p>Marque a refeição desejada.</p>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <div class="checkbox-custom checkbox-inline checkbox-primary">
                                                        <input type="checkbox" id="checkboxCustom2" name="cafe" value="SIM">
                                                        <label class="check" for="checkboxCustom2">Café</label>
                                                    </div>
                                                    <div class="checkbox-custom checkbox-inline checkbox-primary">
                                                        <input type="checkbox" id="checkboxCustom3" name="almoco" value="SIM">
                                                        <label class="check" for="checkboxCustom3">Almoço</label>
                                                    </div>
                                                    <div class="checkbox-custom checkbox-inline checkbox-primary">
                                                        <input type="checkbox" id="checkboxCustom4" name="jantar" value="SIM">
                                                        <label class="check" for="checkboxCustom4">Jantar</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                        </div>
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
                                    </div>
                                </div>
                            </div>                                            
                        </div>
                    </form>
                </div>
            </div>
            <?php
            if ($token != "") {
                ?>
                <div class="alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <h4><strong><?php echo($token); ?></strong></h4>
                </div>
                <?php
            }
            ?>
            <div class="alert alert-danger fade in">
                <?php
                if ($_SESSION['user_numconta2'] == "2") {
                    $msgm = "Você está acessando com a conta de FURRIEL. Poderá arranchar somente os usuários pertencentes a sua companhia.";
                }
                if ($_SESSION['user_numconta2'] == "3") {
                    $msgm = "Você está acessando com a conta de APROVISIONADOR. Poderá arranchar TODOS os usuários cadastrados selecionados pela opção.";
                }
                if ($_SESSION['user_numconta2'] == "4") {
                    $msgm = "Você está acessando com a conta de ADMINISTRADOR. Poderá arranchar TODOS os usuários cadastrados selecionados pela opção.";
                }
                ?>
                <h4><strong><?php echo($msgm); ?></strong></h4>
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