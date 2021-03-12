<?php
require "versession.php";
include "conexao.php";
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
        <link rel="stylesheet" href="stylesheets/css/style.css">
        <link rel="stylesheet" href="vendor/data-table/media/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="vendor/data-table/extensions/Responsive/css/responsive.bootstrap.min.css">
        <link href="vendor/pace/pace-theme-minimal.css" rel="stylesheet" />
        <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
        <link rel="stylesheet" href="vendor/select2/css/select2-bootstrap.min.css">
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
                                    <a href="meurancho.php">Histórico de meus arranchamentos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row animated fadeInUp">                        
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-content">
                                    <table id="responsive-table" class="data-table table table-striped table-hover responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Registro
                                                </th> 
                                                <th>
                                                    Data
                                                </th>
                                                <th>
                                                    P/Grad
                                                </th>
                                                <th>
                                                    Nome Guerra
                                                </th>
                                                <th>
                                                    SU
                                                </th>
                                                <th>
                                                    Café
                                                </th>
                                                <th>
                                                    Almoço
                                                </th>
                                                <th>
                                                    Jantar
                                                </th>
                                                <th>
                                                    Modo
                                                </th>
                                                <th>
                                                    Data Grav
                                                </th>
                                                <th>
                                                    Hora Grav
                                                </th>
                                                <th>
                                                    Quem foi?
                                                </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pdo = conectar("arranchamento");
                                            $pdo2 = conectar2("membros");
                                            $conspronto = $pdo->prepare("SELECT * FROM arranchado");
                                            $conspronto->execute();
                                            while ($reg2 = $conspronto->fetch(PDO::FETCH_ASSOC)) :
                                                /* Para recuperar um ARRAY utilize PDO::FETCH_ASSOC */
                                                echo("<tr>");
                                                echo("<td>" . $reg2['id'] . "</td>");
                                                echo("<td>" . $reg2['data'] . "</td>");
                                                $conspgrad = $pdo2->prepare("SELECT * FROM postograd WHERE id =" . $reg2['idpgrad']);
                                                $conspgrad->execute();
                                                while ($regpgrad = $conspgrad->fetch(PDO::FETCH_ASSOC)) :
                                                    echo("<td>" . $regpgrad['postograd'] . "</td>");
                                                endwhile;
                                                echo("<td>" . $reg2['nomeguerra'] . "</td>");
                                                $conssu = $pdo2->prepare("SELECT * FROM subunidade WHERE id =" . $reg2['idsu']);
                                                $conssu->execute();
                                                while ($regsu = $conssu->fetch(PDO::FETCH_ASSOC)) :
                                                    echo("<td>" . $regsu['descricao'] . "</td>");
                                                endwhile;
                                                echo("<td>" . $reg2['cafe'] . "</td>");
                                                echo("<td>" . $reg2['almoco'] . "</td>");
                                                echo("<td>" . $reg2['jantar'] . "</td>");
                                                echo("<td>" . $reg2['modo'] . "</td>");
                                                echo("<td>" . $reg2['datagrava'] . "</td>");
                                                echo("<td>" . $reg2['horagrava'] . "</td>");
                                                echo("<td>" . $reg2['quemgrava'] . "</td>");
                                                echo("</tr>");
                                            endwhile;
                                            ?>
                                        </tbody>
                                    </table>
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
        <script src="javascripts/examples/forms/validation.js"></script>

        <script src="vendor/jquery-validation/jquery.validate.min.js"></script>

        <script src="vendor/data-table/media/js/jquery.dataTables.min.js"></script>
        <script src="vendor/data-table/media/js/dataTables.bootstrap.min.js"></script>
        <script src="vendor/data-table/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="vendor/data-table/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
        <script src="javascripts/examples/tables/data-tables.js"></script>


    </body>

</html>