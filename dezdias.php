<?php

require "versession.php";
include "conexao.php";
$pdo1 = conectar("membros");
$pdo2 = conectar2("arranchamento");

date_default_timezone_set("America/Cuiaba");
$somadias = filter_input(INPUT_GET, "soma");

$hoje = date("d/m/Y");
$quemgrava = $_SESSION['user_pgradsimples2'] . " " . $_SESSION['user_guerra2'];
$iduser = $_SESSION['user_id2'];
$horaini = date("H:i:s");
$grav = $atualz = 0;
for ($indice = 0; $indice < 10; $indice++) {
    $rdia[$indice] = date('d/m/Y', strtotime("+" . $somadias . " days"));
    $somadias++;
    $rcafe[$indice] = filter_input(INPUT_POST, "ocafe" . $indice);
    $ralmoco[$indice] = filter_input(INPUT_POST, "oalmoco" . $indice);
    $rjantar[$indice] = filter_input(INPUT_POST, "ojantar" . $indice);

    $pesquisa = "SELECT * FROM arranchado WHERE iduser = :iduser and data = :data";
    $stmt = $pdo2->prepare($pesquisa);
    $stmt->bindParam(':iduser', $_SESSION['user_id2']);
    $stmt->bindParam(':data', $rdia[$indice]);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rcafe[$indice] != "SIM") {
        $rcafe[$indice] = "";
    }
    if ($ralmoco[$indice] != "SIM") {
        $ralmoco[$indice] = "";
    }
    if ($rjantar[$indice] != "SIM") {
        $rjantar[$indice] = "";
    }

    if (count($result) < 1) {
        if ($rcafe[$indice] == "" && $ralmoco[$indice] == "" && $rjantar[$indice] == "") {
            
        } else {
            $agora = date("H:i:s");
            $modo = "Criado";
            $stmtez = $pdo2->prepare("INSERT INTO arranchado(data, iduser, idpgrad, idsu, nomeguerra, cafe, almoco, jantar, datagrava, horagrava, quemgrava, modo) "
                    . "VALUES (:data, :iduser, :idpgrad, :idsu, :nomeguerra, :cafe, :almoco, :jantar, :datagrava, :horagrava, :quemgrava, :modo)");
            $stmtez->bindParam(":data", $rdia[$indice], PDO::PARAM_STR);
            $stmtez->bindParam(":iduser", $_SESSION['user_id2'], PDO::PARAM_INT);
            $stmtez->bindParam(":idpgrad", $_SESSION['user_idpgrad2'], PDO::PARAM_INT);
            $stmtez->bindParam(":idsu", $_SESSION['user_idsubun2'], PDO::PARAM_INT);
            $stmtez->bindParam(":nomeguerra", $_SESSION['user_guerra2'], PDO::PARAM_STR);
            $stmtez->bindParam(":cafe", $rcafe[$indice], PDO::PARAM_STR);
            $stmtez->bindParam(":almoco", $ralmoco[$indice], PDO::PARAM_STR);
            $stmtez->bindParam(":jantar", $rjantar[$indice], PDO::PARAM_STR);
            $stmtez->bindParam(":datagrava", $hoje, PDO::PARAM_STR);
            $stmtez->bindParam(":horagrava", $agora, PDO::PARAM_STR);
            $stmtez->bindParam(":quemgrava", $quemgrava, PDO::PARAM_STR);
            $stmtez->bindParam(":modo", $modo, PDO::PARAM_STR);
            $executa = $stmtez->execute();
            $grav++;
        }
    } else {
        $agora = date("H:i:s");
        $dadosrancho = $result[0];
        $modo = "Atualizado";
        if ($rcafe[$indice] <> $dadosrancho['cafe'] || $ralmoco[$indice] <> $dadosrancho['almoco'] || $rjantar[$indice] <> $dadosrancho['jantar']) {
            $stmtup = $pdo2->prepare("UPDATE arranchado SET idsu = :idsu, cafe = :cafe, almoco = :almoco, jantar = :jantar, datagrava = :datagrava, horagrava = :horagrava, quemgrava = :quemgrava, idpgrad = :idpgrad, nomeguerra = :nomeguerra, modo = :modo WHERE iduser = :iduser and data = :data");
            $stmtup->bindParam(":idsu", $_SESSION['user_idsubun2'], PDO::PARAM_STR);
            $stmtup->bindParam(":cafe", $rcafe[$indice], PDO::PARAM_STR);
            $stmtup->bindParam(":almoco", $ralmoco[$indice], PDO::PARAM_STR);
            $stmtup->bindParam(":jantar", $rjantar[$indice], PDO::PARAM_STR);
            $stmtup->bindParam(":datagrava", $hoje, PDO::PARAM_STR);
            $stmtup->bindParam(":horagrava", $agora, PDO::PARAM_STR);
            $stmtup->bindParam(":quemgrava", $quemgrava, PDO::PARAM_STR);
            $stmtup->bindParam(":idpgrad", $_SESSION['user_idpgrad2'], PDO::PARAM_INT);
            $stmtup->bindParam(":nomeguerra", $_SESSION['user_guerra2'], PDO::PARAM_STR);
            $stmtup->bindParam(":modo", $modo, PDO::PARAM_STR);
            $stmtup->bindParam(":iduser", $iduser, PDO::PARAM_INT);
            $stmtup->bindParam(":data", $rdia[$indice], PDO::PARAM_STR);
            $execup = $stmtup->execute();
            $atualz++;
        }
    }
}
$horafim = date("H:i:s");
$diftime = calculaTempo($horaini, $horafim);
$msgerro = base64_encode($grav. " registros gravados, ".$atualz." atualizados em ".$diftime. "(H:m:s)");
header('Location: index.php?token=' . $msgerro);
?>