<?php

session_start();
date_default_timezone_set("America/Cuiaba");
require "conexao.php";
$pdo1 = conectar("membros");
$login = base64_encode(filter_input(INPUT_POST, "login"));
$senha = base64_encode(filter_input(INPUT_POST, "senha"));
$sistema = base64_encode($_SESSION['sistema2']);
$sql = "SELECT * FROM usuarios WHERE identidade = :login AND senha = :senha";
$stmt = $pdo1->prepare($sql);
$stmt->bindParam(':login', $login);
$stmt->bindParam(':senha', $senha);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($users) < 1) {
    session_destroy();
    $msgerro = base64_encode('Usuário ou senha inválido!');
    header('Location: signin.php?token=' . $msgerro);
} else {
// pega o primeiro usuário
    $user = $users[0];
    if ($user['userativo'] == "S") {
        if ($user['acessorancho'] == "S") {
            $_SESSION['logado2'] = true;
            $_SESSION['user_id2'] = $user['id'];
            $_SESSION['user_guerra2'] = $user['nomeguerra'];
            $_SESSION['user_idpgrad2'] = $user['idpgrad'];
            $_SESSION['user_idsubun2'] = $user['idsubunidade'];
            if ($user['contarancho'] == "1") {
                $_SESSION['user_tipoconta2'] = "Usuário comum";
                $_SESSION['user_numconta2'] = $user['contarancho'];
            } else {
                if ($user['contarancho'] == "2") {
                    $_SESSION['user_tipoconta2'] = "Furriel";
                    $_SESSION['user_numconta2'] = $user['contarancho'];
                } else {
                    if ($user['contarancho'] == "3") {
                        $_SESSION['user_tipoconta2'] = "Aprovisionador";
                        $_SESSION['user_numconta2'] = $user['contarancho'];
                    } else {
                        if ($user['contarancho'] == "4") {
                            $_SESSION['user_tipoconta2'] = "Administrador";
                            $_SESSION['user_numconta2'] = $user['contarancho'];
                        } else {
                            $msgerro = base64_encode('Não definido tipo de conta para este usuário');
                            header('Location: signin.php?token=' . $msgerro);
                        }
                    }
                }
            }
            $consultapg = $pdo1->prepare("SELECT * FROM postograd WHERE id = :idpgrad");
            $consultapg->bindParam(':idpgrad', $_SESSION['user_idpgrad2']);
            $consultapg->execute();
            $pg = $consultapg->fetchAll(PDO::FETCH_ASSOC);
            if (count($pg) <= 0) {
                session_destroy();
                $msgerro = base64_encode('Erro ao buscar informação adicional (Posto/Graduação)!');
                header('Location: signin.php?token=' . $msgerro);
            }
            $pgs = $pg[0];
            $_SESSION['user_pgradsimples2'] = $pgs['pgradsimples'];
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            exec('wmic COMPUTERSYSTEM Get Username', $acesuser);
            $_SESSION['acesuser2'] = $acesuser[1];
            $_SESSION['user_ip2'] = $ip;
            $data = date("d/m/Y");
            $hora = date("H:i:s");
            try {
                $stmtez = $pdo1->prepare("INSERT INTO logins(idmembro, data, hora, sistema, ip) "
                        . "VALUES (:idmembro, :data, :hora, :sistema, :ip)");
                $stmtez->bindParam(":idmembro", $_SESSION['user_id2'], PDO::PARAM_INT);
                $stmtez->bindParam(":data", $data, PDO::PARAM_STR);
                $stmtez->bindParam(":hora", $hora, PDO::PARAM_STR);
                $stmtez->bindParam(":sistema", $sistema, PDO::PARAM_STR);
                $stmtez->bindParam(":ip", $ip, PDO::PARAM_STR);
                $executa = $stmtez->execute();
                if ($executa) {
                    echo 'Dados inseridos com sucesso';
                } else {
                    session_destroy();
                    $msgerro = base64_encode('Erro na tentativa de registrar o acesso!');
                    header('Location: signin.php?token=' . $msgerro);
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            header('Location: index.php');
        } else {
            session_destroy();
            $msgerro = base64_encode('Usuário não tem acesso ao sistema!');
            header('Location: signin.php?token=' . $msgerro);
        }
    } else {
        session_destroy();
        $msgerro = base64_encode('Usuário não está ativo. Contate o administrador do sistema.');
        header('Location: signin.php?token=' . $msgerro);
    }
}
?>

