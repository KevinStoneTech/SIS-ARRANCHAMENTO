<?php
require "versession.php";
include "conexao.php";
date_default_timezone_set("America/Manaus");
$pdo = conectar("membros");
$pdo2 = conectar2("arranchamento");
//limpa os arranchamentos vazios
$sqldeleta = "DELETE FROM arranchado WHERE cafe =  '' AND almoco = '' AND jantar = ''";
$sqlapaga = $pdo2->prepare($sqldeleta);
$sqlapaga->execute();
$datarancho = filter_input(INPUT_POST, "datarancho");
$subunidade = filter_input(INPUT_POST, "subunidade");
$postograd = filter_input(INPUT_POST, "postograd");
$meuidsu = $_SESSION['user_idsubun2'];
$quemgrava = $_SESSION['user_pgradsimples2'] . " " . $_SESSION['user_guerra2'];
if ($subunidade > 0) {
    $sql = "SELECT * FROM subunidade WHERE id = :idsu";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idsu', $subunidade, PDO::PARAM_INT);
    $stmt->execute();
    $descsu = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $SUnidade = $descsu[0];
}
$diasemana = array('DOMINGO', 'SEGUNDA-FEIRA', 'TERÇA-FEIRA', 'QUARTA-FEIRA', 'QUINTA-FEIRA', 'SEXTA-FEIRA', 'SÁBADO');
$convdata = date_converter($datarancho);
$diasemana_numero = date('w', strtotime($convdata));
echo "<table border=1 width=100% cellpadding=3 cellspacing=0>\n";
echo "<tr>";
echo "<th align='center' valign='middle' width=100%>";
echo "<font size=0.5> SISTEMA DE ARRANCHAMENTO - 12º GRUPO DE ARTILHARIA ANTIAÉREA DE SELVA </font>";
echo "</th>";
echo("</tr>");
echo("</table>");
echo("<p>");
echo "<table border=1 width=100% cellpadding=3 cellspacing=0>\n";
echo "<tr>";
echo "<th align='center' valign='middle' width=100%>";
if ($subunidade > 0) { // FOI ESCOLHIDO UMA SUBUNIDADE
    if ($postograd == 0) { // ESCOLHIDO TODOS POSTO/GRADUAÇÃO
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idsu = :idsu ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->bindParam(":idsu", $subunidade, PDO::PARAM_INT);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ") DA " . $SUnidade['descricao'] . "";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 1) { // ESCOLHIDO OFICIAIS
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idsu = :idsu AND idpgrad > 0 && idpgrad <= 8 ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->bindParam(":idsu", $subunidade, PDO::PARAM_INT);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ") DA " . $SUnidade['descricao'] . "";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 2) { // ST/SGT
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idsu = :idsu AND idpgrad > 8 && idpgrad < 13 ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->bindParam(":idsu", $subunidade, PDO::PARAM_INT);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ") DA " . $SUnidade['descricao'] . "";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 3) { // ESCOLHIDO CB/SD
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idsu = :idsu AND idpgrad >= 13 ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->bindParam(":idsu", $subunidade, PDO::PARAM_INT);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ") DA " . $SUnidade['descricao'] . "";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
} else { // FOI ESCOLHIDO TODAS AS SU
    if ($postograd == 0) { // ESCOLHIDO TODOS POSTO/GRADUAÇÃO
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ")";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 1) { // ESCOLHIDO OF
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idpgrad > 0 && idpgrad <= 8  ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ")";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 2) { // ESCOLHIDO ST/SGT
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idpgrad > 8 && idpgrad < 13 ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ")";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
    if ($postograd == 3) { // ESCOLHIDO CB/SD
        $crancho = $pdo2->prepare("SELECT * FROM arranchado WHERE data = :data AND idpgrad >= 13 ORDER BY idpgrad, nomeguerra ASC");
        $crancho->bindParam(":data", $datarancho, PDO::PARAM_STR);
        $crancho->execute();
        $subtitulo = "RELAÇÃO DE ARRANCHAMENTO PARA O DIA " . $datarancho . " (" . $diasemana[$diasemana_numero] . ")";
        echo("<font size=0.5>". $subtitulo . "</font>");
    }
}
if ($postograd <= 8) {
    $filtroPG = "SELECT * FROM postograd WHERE id <= 8";
}
if ($postograd > 8 && $postograd < 13) {
    $filtroPG = "SELECT * FROM postograd WHERE id > 8 AND id < 13";
}
if ($postograd >= 13) {
    $filtroPG = "SELECT * FROM postograd WHERE id >= 13";
}
echo "</th>";
echo("</tr>");
echo("</table>");
echo("<p>");
$totrancho = $crancho->fetchAll(PDO::FETCH_ASSOC);
$totalregistro = count($totrancho);
$resto = $totalregistro % 3;
// caso a quantidade de registros for menor que 3
if ($totalregistro < 2) {
    $coluna1 = 1;
    $coluna2 = 0;
    $coluna3 = 0;
}
if ($totalregistro > 1 && $totalregistro < 3) {
    $coluna1 = 1;
    $coluna2 = 1;
    $coluna3 = 0;
}
if ($totalregistro >= 3) {
    if ($resto == 1) {
        $coluna1 = (int) ($totalregistro / 3) + 1;
        $coluna2 = (int) ($totalregistro / 3);
        $coluna3 = (int) ($totalregistro / 3);
    }
    if ($resto == 2) {
        $coluna1 = (int) ($totalregistro / 3) + 1;
        $coluna2 = (int) ($totalregistro / 3) + 1;
        $coluna3 = (int) ($totalregistro / 3);
    }
    if ($resto == 0) {
        $coluna1 = (int) ($totalregistro / 3);
        $coluna2 = (int) ($totalregistro / 3);
        $coluna3 = (int) ($totalregistro / 3);
    }
    $coluna2 = ($coluna1 + $coluna2);    
}
?>
<html lang="pt-BR" class="fixed">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title><?php echo($_SESSION['sistema2']) ?></title>
        <link rel="apple-touch-icon" sizes="120x120" href="favicon/geleia.png">
        <link rel="icon" type="image/png" sizes="192x192" href="favicon/geleia.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/geleia.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/geleia.png">
    </head>
    <?php
    if ($totalregistro > 0) {
// Abre tabela HTML        
        echo "<table border=1 width=100% cellpadding=3 cellspacing=0>\n";
        echo "<tr>";
        echo "<th align='center' valign='middle' width=14%>";
        echo "<font size=0.5> MILITAR </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=10%>";
        echo "<font size=0.5> SU </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>C</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>A</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>J</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=0.5%>";
        echo "<font size=0.5>&nbsp;</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=14%>";
        echo "<font size=0.5>MILITAR</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=10%>";
        echo "<font size=0.5> SU </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>C</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>A</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>J</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=0.5%>";
        echo "<font size=0.5>&nbsp;</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=14%>";
        echo "<font size=0.5>MILITAR</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=10%>";
        echo "<font size=0.5> SU </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>C</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>A</font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=3%>";
        echo "<font size=0.5>J</font>";
        echo "</th>";
        echo "</tr>\n";
        for ($i = 0; $i < $coluna1; $i++) {
            $reg = $totrancho[$i];
            $idpgrad = $reg['idpgrad'];
            // PROCURA DESCRIÇÃO DE POSTO/GRAD
            $sql2 = "SELECT * FROM postograd WHERE id = :idpg";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':idpg', $idpgrad, PDO::PARAM_INT);
            $stmt2->execute();
            $descpg = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $PGdesc = $descpg[0];
            echo "<tr>";
            echo "<td align='center' valign='middle'>";
            echo "<font size=0.5>" . strtoupper($PGdesc["pgradsimples"] . " " . $reg["nomeguerra"]) . "</font>";
            echo "</td>";
            echo "<td align='center' valign='middle'>";
            // PROCURA SUBUNIDADE
            $meuidsu4 = $reg['idsu'];
            $sql4 = "SELECT * FROM subunidade WHERE id = :idsu";
            $stmt4 = $pdo->prepare($sql4);
            $stmt4->bindParam(':idsu', $meuidsu4, PDO::PARAM_INT);
            $stmt4->execute();
            $descsu4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            $SUnidade4 = $descsu4[0];
            echo "<font size=0.5>" . $SUnidade4['descricao'] . "</font>";
            echo "</td>";
            echo "<td align='center' valign='middle'>";
            if ($reg['cafe'] == "SIM") {
                echo "<font size=0.5> X </font>";
            } else {
                echo "<font size=0.5>   </font>";
            }
            echo "</td>";
            echo "<td align='center' valign='middle'>";
            if ($reg['almoco'] == "SIM") {
                echo "<font size=0.5> X </font>";
            } else {
                echo "<font size=0.5>   </font>";
            }
            echo "</td>";
            echo "<td align='center' valign='middle'>";
            if ($reg['jantar'] == "SIM") {
                echo "<font size=0.5> X </font>";
            } else {
                echo "<font size=0.5>   </font>";
            }
            echo "</td>";
            echo "<th align='center' valign='middle'>";
            echo "<font size=0.5>&nbsp;</font>";
            echo "</th>";
            if ($i < $coluna2) {
                $reg = $totrancho[($coluna1 + $i)];
                $idpgrad = $reg['idpgrad'];
                // PROCURA DESCRIÇÃO DE POSTO/GRAD
                $sql2 = "SELECT * FROM postograd WHERE id = :idpg";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->bindParam(':idpg', $idpgrad, PDO::PARAM_INT);
                $stmt2->execute();
                $descpg = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $PGdesc = $descpg[0];
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>" . strtoupper($PGdesc["pgradsimples"] . " " . $reg["nomeguerra"]) . "</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                // PROCURA SUBUNIDADE
                $meuidsu4 = $reg['idsu'];
                $sql4 = "SELECT * FROM subunidade WHERE id = :idsu";
                $stmt4 = $pdo->prepare($sql4);
                $stmt4->bindParam(':idsu', $meuidsu4, PDO::PARAM_INT);
                $stmt4->execute();
                $descsu4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                $SUnidade4 = $descsu4[0];
                echo "<font size=0.5>" . $SUnidade4['descricao'] . "</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['cafe'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['almoco'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['jantar'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
                echo "<th align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</th>";
            } else {
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<th align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</th>";
            }
            if ($i < $coluna3) {
                $reg = $totrancho[($coluna2 + $i)];
                $idpgrad = $reg['idpgrad'];
                // PROCURA DESCRIÇÃO DE POSTO/GRAD
                $sql2 = "SELECT * FROM postograd WHERE id = :idpg";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->bindParam(':idpg', $idpgrad, PDO::PARAM_INT);
                $stmt2->execute();
                $descpg = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $PGdesc = $descpg[0];
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>" . strtoupper($PGdesc["pgradsimples"] . " " . $reg["nomeguerra"]) . "</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                // PROCURA SUBUNIDADE
                $meuidsu4 = $reg['idsu'];
                $sql4 = "SELECT * FROM subunidade WHERE id = :idsu";
                $stmt4 = $pdo->prepare($sql4);
                $stmt4->bindParam(':idsu', $meuidsu4, PDO::PARAM_INT);
                $stmt4->execute();
                $descsu4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                $SUnidade4 = $descsu4[0];
                echo "<font size=0.5>" . $SUnidade4['descricao'] . "</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['cafe'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['almoco'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                if ($reg['jantar'] == "SIM") {
                    echo "<font size=0.5> X </font>";
                } else {
                    echo "<font size=0.5>   </font>";
                }
                echo "</td>";
            } else {
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
                echo "<td align='center' valign='middle'>";
                echo "<font size=0.5>&nbsp;</font>";
                echo "</td>";
            }
        }
        echo "</tr>";
        echo "</table>\n";
        // Fecha tabela
        //EXECUTA CONSULTA DE QUANTITATIVOS
        $qtdoficiais = $qtdstsgt = $qtdcbsd = 0;
        $cafeof = $cafestsgt = $cafecbsd = $almof = $almstsgt = $almcbsd = $jantof = $jantstsgt = $jantcbsd = 0;
        for ($i = 0; $i < count($totrancho); $i++) {
            $reg = $totrancho[$i];
            //if ($reg['cafe'] <> " " && $reg['almoco'] && $reg['jantar'] <> " ") {
            if ($reg['idpgrad'] <= 8) {
                $qtdoficiais++;
                if ($reg['cafe'] == "SIM") {
                    $cafeof++;
                }
                if ($reg['almoco'] == "SIM") {
                    $almof++;
                }
                if ($reg['jantar'] == "SIM") {
                    $jantof++;
                }
            }
            if ($reg['idpgrad'] > 8 && $reg['idpgrad'] < 13) {
                $qtdstsgt++;
                if ($reg['cafe'] == "SIM") {
                    $cafestsgt++;
                }
                if ($reg['almoco'] == "SIM") {
                    $almstsgt++;
                }
                if ($reg['jantar'] == "SIM") {
                    $jantstsgt++;
                }
            }
            if ($reg['idpgrad'] >= 13) {
                $qtdcbsd++;
                if ($reg['cafe'] == "SIM") {
                    $cafecbsd++;
                }
                if ($reg['almoco'] == "SIM") {
                    $almcbsd++;
                }
                if ($reg['jantar'] == "SIM") {
                    $jantcbsd++;
                }
            }
            //}
        }
        echo("<p>");
        echo "<table border=1 width=100% cellpadding=3 cellspacing=0>\n";
        echo "<tr>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> QUANTIDADE </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> CAFE </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> ALMOÇO </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> JANTAR </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> LISTADO </font>";
        echo "</th>";
        echo("</tr>");

        echo "<tr>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> OFICIAIS </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $cafeof . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $almof . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $jantof . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $qtdoficiais . " </font>";
        echo "</th>";
        echo("</tr>");

        echo "<tr>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> ST/SGT </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $cafestsgt . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $almstsgt . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $jantstsgt . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $qtdstsgt . " </font>";
        echo "</th>";
        echo("</tr>");

        echo "<tr>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> CB/SD </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $cafecbsd . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $almcbsd . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $jantcbsd . " </font>";
        echo "</th>";
        echo "<th align='center' valign='middle' width=20%>";
        echo "<font size=0.5> " . $qtdcbsd . " </font>";
        echo "</th>";
        echo("</tr>");
        echo("</table>");
        $datahoje = date("d/m/Y");
        $horagora = date("H:i:s");
    } else {
        echo "</br><B>NÃO EXISTE LANÇAMENTOS PARA ESTA DATA.</B>\n";
    }
    try {
        $tabela = "relatorios";
        $sistema = base64_encode($_SESSION['sistema2']);
        $obs = $subtitulo;
        $gravddos = $pdo->prepare("INSERT INTO $tabela(data, hora, ip, responsavel, sistema, obs) "
                . "VALUES (:data, :hora, :ip, :responsavel, :sistema, :obs)");
        $gravddos->bindParam(":data", $datahoje, PDO::PARAM_STR);
        $gravddos->bindParam(":hora", $horagora, PDO::PARAM_STR); // REGISTRA A SENHA IGUAL A IDENTIDADE
        $gravddos->bindParam(":ip", $_SESSION['user_ip2'], PDO::PARAM_STR);
        $gravddos->bindParam(":responsavel", $quemgrava, PDO::PARAM_STR);
        $gravddos->bindParam(":sistema", $sistema, PDO::PARAM_STR);
        $gravddos->bindParam(":obs", $obs, PDO::PARAM_STR);
        $executa = $gravddos->execute();
        ?>
        <table border='1' cellpadding='2' cellspacing='0' style='width: 100%'>
            <tbody>
                <tr>
                    <td align="center">                        
                        <?php
                        if ($executa) {
                            ?>
                            <font face = 'font-family:trebuchet ms,helvetica,sans-serif;' size=2>
                            Relatório gerado pelo <?php echo($quemgrava); ?> em <?php echo($datahoje); ?> às <?php echo($horagora); ?>
                            </font>
                            <?php
                        } else {
                            ?>
                            <font face = 'font-family:trebuchet ms,helvetica,sans-serif;' size=2>
                            Erro ao gravar os dados.<br>Relatório gerado pelo <?php echo($quemgrava); ?> em <?php echo($datahoje); ?> às <?php echo($horagora); ?>
                            </font>
                            <?php
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>    
                </td>
            </tr>
        </tbody>
    </table>
