<div id="left-nav" class="nano">
    <div class="nano-content">
        <nav>
            <ul class="nav" id="main-nav">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i><span>Página Principal</span></a></li>
                <!-- Essa linha deve ser inserida se o item do menu for correspondente ao que está aberto
                <li class="has-child-item open-item active-item">
                -->
                <li><a href="informacoes.php"><i class="fa fa-user-secret" aria-hidden="true"></i><span>Informações</span></a></li>
                <?php
                if ($_SESSION['user_numconta2'] == "2" || $_SESSION['user_numconta2'] == "3" || $_SESSION['user_numconta2'] == "4") {
                    ?>
                    <li class="has-child-item close-item">
                        <a><i class="fa fa-cutlery" aria-hidden="true"></i><span>Arranchamento</span></a>
                        <ul class="nav child-nav level-1">                        

                            <li><a href="individual.php">Individual</a></li>
                            <li><a href="porpg.php">Por Posto/Graduação</a></li>
                            <li><a href="select.php">Por Seleção</a></li>
                            <li class="has-child-item close-item">
                                <a>Relatórios</a>
                                <ul class="nav child-nav level-2 ">
                                    <li><a href="reladia.php">Quem se Arranchou?</a></li>
                                </ul>
                            </li>
                            <li><a href="todorancho.php">Todos Arranchamentos</a></li>
                        </ul>
                    </li>
                    <?php
                }
                if ($_SESSION['user_numconta2'] == "3" || $_SESSION['user_numconta2'] == "4") {
                    ?>
                    <li><a href="cadcardapio.php"><i class="fa fa-book" aria-hidden="true"></i><span>Cardápio</span></a></li>
                    <?php
                }
                ?>
                <?php
                if ($_SESSION['user_numconta2'] == "4") {
                    ?>
                    <li><a href="dadosmembros.php"><i class="fa fa-user" aria-hidden="true"></i><span>Dados de Usuários</span></a></li>
                                <?php
                            }
                            ?>
            </ul>
        </nav>
    </div>
</div>
