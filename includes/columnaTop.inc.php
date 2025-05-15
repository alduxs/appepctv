<li class="nav-header">
    <div class="dropdown profile-element">
        <?php if ($_SESSION["imagen"] != "nd") { ?>
            <span>


                <img alt="image" class="img-circle" src="usuarios/<?php echo $_SESSION["imagen"]; ?>" width="48px" height="auto"/>
            </span>
        <?php } else { ?>
            <span>
                <img alt="image" class="img-circle" src="img/profile_small.jpg" />
            </span>
        <?php } ?>
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION["strName"]; ?></strong>
                </span> <span class="text-muted text-xs block"> Usuario <b class="caret"></b></span> </span> </a>
        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a href="updPerfil.php?seccion=perfil&id=<?php echo $_SESSION["id"]; ?>">Editar Perfil</a></li>
            <li class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="logo-element">
        <img src="img/logo2.png" class="img-responsive center-block">
    </div>
</li>