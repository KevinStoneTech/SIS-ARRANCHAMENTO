<?php
require "versession.php";
include "conexao.php";
date_default_timezone_set("America/Cuiaba");
$token = base64_decode(filter_input(INPUT_GET, "token"));
$p1 = conectar("membros");
$p2 = conectar2("arranchamento");
$sistema = base64_encode($_SESSION['sistema2']);
$idmembro = $_SESSION['user_id2'];
$idusuario = filter_input(INPUT_POST, "usuario");
$consulta = $p1->prepare("SELECT * FROM usuarios WHERE id = $idusuario AND userativo = 'S'");
$consulta->execute();
$users = $consulta->fetchAll(PDO::FETCH_ASSOC);
$user = $users[0];
$nomeguerra = $user['nomeguerra'];
$idpgrad = $user['idpgrad'];

$conslogin = $p1->prepare("SELECT * FROM logins WHERE idmembro = :idusuario AND sistema = :sistema");
$conslogin->bindParam(':idusuario', $idusuario);
$conslogin->bindParam(':sistema', $sistema);
$conslogin->execute();
$login = $conslogin->fetchAll(PDO::FETCH_ASSOC);
$totlogin = count($login);
if ($totlogin > 0) {
    $dadoslogin = $login[$totlogin - 1];
    $ultimologin = $dadoslogin['data'] . " " . $dadoslogin['hora'];
} else {
    $ultimologin = "***";
}

$consultapg = $p1->prepare("SELECT * FROM postograd WHERE id = $idpgrad");
$consultapg->execute();
$pgd = $consultapg->fetchAll(PDO::FETCH_ASSOC);
$pgd2 = $pgd[0];
$postograd = $pgd2['pgradsimples'];
$confirmado = "SIM";
$cafe = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :idusuario AND cafe = :cafe");
$cafe->bindParam(':idusuario', $idusuario);
$cafe->bindParam(':cafe', $confirmado);
$cafe->execute();
$oscafes = $cafe->fetchAll(PDO::FETCH_ASSOC);
$totalcafe = count($oscafes);
if ($totalcafe > 0) {
    $ultimocafe = $oscafes[$totalcafe - 1];
    $datacafe = $ultimocafe['data'];
} else {
    $datacafe = "***";
}

$almoco = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :idusuario AND almoco = :almoco");
$almoco->bindParam(':idusuario', $idusuario);
$almoco->bindParam(':almoco', $confirmado);
$almoco->execute();
$osalmocos = $almoco->fetchAll(PDO::FETCH_ASSOC);
$totalalmoco = count($osalmocos);
if ($totalalmoco > 0) {
    $ultimoalmoco = $osalmocos[$totalalmoco - 1];
    $dataalmoco = $ultimoalmoco['data'];
} else {
    $dataalmoco = "***";
}

$janta = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :idusuario AND jantar = :janta");
$janta->bindParam(':idusuario', $idusuario);
$janta->bindParam(':janta', $confirmado);
$janta->execute();
$osjantas = $janta->fetchAll(PDO::FETCH_ASSOC);
$totaljanta = count($osjantas);
if ($totaljanta > 0) {
    $ultimojanta = $osjantas[$totaljanta - 1];
    $datajanta = $ultimojanta['data'];
} else {
    $datajanta = "***";
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
        <link rel="stylesheet" href="vendor/data-table/media/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="vendor/data-table/extensions/Responsive/css/responsive.bootstrap.min.css">
        <link href="vendor/pace/pace-theme-minimal.css" rel="stylesheet" />
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
                                    <i class="fa fa-archive" aria-hidden="true">
                                    </i>
                                    <a href="#"> Informações Individuais de Usuários</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row animated fadeInUp">
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <span class="icon fa fa-user color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-8">
                                                    <h4 class="subtitle color-darker-1"><?php echo($postograd); ?></h4>
                                                    <h1 class="title color-primary"> <?php echo($nomeguerra); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <span class="icon fa fa-globe color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-8">
                                                    <h4 class="subtitle color-darker-1">Acessos ao <?php echo(base64_decode($sistema)); ?></h4>
                                                    <h1 class="title color-primary"> <?php echo($totlogin); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <span class="icon fa fa-user-secret color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-8">
                                                    <h4 class="subtitle color-darker-1">Último acesso em:</h4>
                                                    <h1 class="title color-primary"> <?php echo($ultimologin); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-coffee color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Total Arranchado Café</h4>
                                                    <h1 class="title color-primary"><?php echo($totalcafe); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-cutlery color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Total Arranchado Almoço</h4>
                                                    <h1 class="title color-primary"><?php echo($totalalmoco); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-cutlery color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Total Arranchado Janta</h4>
                                                    <h1 class="title color-primary"><?php echo($totaljanta); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-coffee color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Último Arranchado Café</h4>
                                                    <h1 class="title color-primary"><?php echo($datacafe); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-cutlery color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Último Arranchado Almoço</h4>
                                                    <h1 class="title color-primary"><?php echo($dataalmoco); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel widgetbox wbox-2 bg-scale-0">
                                        <div class="panel-content">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <span class="icon fa fa-cutlery color-darker-1"></span>
                                                </div>
                                                <div class="col-xs-9">
                                                    <h4 class="subtitle color-darker-1">Último Arranchado Janta</h4>
                                                    <h1 class="title color-primary"><?php echo($datajanta); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
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
                                            $listarancho = $p2->prepare("SELECT * FROM arranchado WHERE iduser = :iduser");
                                            $listarancho->bindParam(':iduser', $idusuario);
                                            $listarancho->execute();
                                            while ($reg2 = $listarancho->fetch(PDO::FETCH_ASSOC)) :
                                                /* Para recuperar um ARRAY utilize PDO::FETCH_ASSOC */
                                                echo("<tr>");
                                                echo("<td>" . $reg2['id'] . "</td>");
                                                echo("<td>" . $reg2['data'] . "</td>");
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
                        <div class="col-sm-5">
                            <div class="panel">
                                <div class="panel-content">
                                    <table id="responsive-table" class="data-table table table-striped table-hover responsive nowrap"
                                           cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Id
                                                </th>
                                                <th>
                                                    Data
                                                </th>
                                                <th>
                                                    Hora
                                                </th>
                                                <th>
                                                    IP
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for($ll = 0; $ll < $totlogin; $ll++){
                                                $reglogin = $login[$ll];
                                                echo("<tr>");
                                                echo("<td>" . $reglogin['id'] . "</td>");
                                                echo("<td>" . $reglogin['data'] . "</td>");
                                                echo("<td>" . $reglogin['hora'] . "</td>");
                                                echo("<td>" . $reglogin['ip'] . "</td>");
                                                echo("</tr>");
                                            }
                                            while ($login = $conslogin->fetchAll(PDO::FETCH_ASSOC)) :
                                                /* Para recuperar um ARRAY utilize PDO::FETCH_ASSOC */
                                                
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
        <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="vendor/data-table/media/js/jquery.dataTables.min.js"></script>
        <script src="vendor/data-table/media/js/dataTables.bootstrap.min.js"></script>
        <script src="vendor/data-table/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="vendor/data-table/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
        <script src="javascripts/examples/tables/data-tables.js"></script>
    </body>
</html>