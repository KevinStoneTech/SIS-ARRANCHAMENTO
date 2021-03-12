<div class="rightside-header">
    <div class="header-section" id="search-headerbox">
        <h2><?php echo($_SESSION['sistema2']); ?></h2>                
    </div>
    <div class="header-middle"></div>            
    <div class="header-section" id="user-headerbox">
        <div class="user-header-wrap">
            <div class="user-photo">
                <img src="favicon/geleia.png" alt="Usuário" />
            </div>
            <div class="user-info">
                <span class="user-name"><?php echo($_SESSION['user_pgradsimples2'] . " " . $_SESSION['user_guerra2']); ?></span>
                <span class="user-profile"><?php echo($_SESSION['user_tipoconta2']); ?></span>
            </div>
            <i class="fa fa-plus icon-open" aria-hidden="true"></i>
            <i class="fa fa-minus icon-close" aria-hidden="true"></i>
        </div>
        <div class="user-options dropdown-box">
            <div class="drop-content basic">
                <ul>
                    <li> <a href="<?php echo("cad_usu_indiv.php?tkusr=" . base64_encode($_SESSION['user_id2'])); ?>"><i class="fa fa-user" aria-hidden="true"></i> Meus dados</a></li>                            
                </ul>
            </div>
        </div>
    </div>
    <div class="header-separator"></div>
    <div class="header-section">
        <a href="logout.php" data-toggle="tooltip" data-placement="left" title="Sair do sistema"><i class="fa fa-sign-out log-out" aria-hidden="true"></i></a>
    </div>
</div>
