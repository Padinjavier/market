<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="d-flex justify-content-end align-items-center" style="height: 50px;">
        <!-- <img class="w-25" src="<?= media(); ?>/tienda/images/logo.png" alt=""> -->
        <a class="app-sidebar__toggle text-dark" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"> <i
                class="fas fa-bars"></i> </a>
    </div>
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/avatar.png"
            alt="User Image">
        <div>
            <p class="app-sidebar__user-name">
            <strong>
            <?= $_SESSION['userData']['nombres']; ?>
            </strong>   
            </p>
            <p class="app-sidebar__user-designation">
                <?= $_SESSION['userData']['nombrerolusuario']; ?>
            </p>
        </div>
    </div>
    <ul class="app-menu">

        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
                <i class="app-menu__icon bi bi-house-door-fill"></i>
                    <span class="app-menu__label">Dashboard</span>
                </a>
            </li>
        <?php } ?>

        <!-- empleados rol empleados  -->
        <?php if (!empty($_SESSION['permisos'][2]['r']) || !empty($_SESSION['permisos'][3]['r'])) { ?>
            <li class="treeview" id="menu-empleados">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-people-fill"></i>
                    <span class="app-menu__label">Empleados</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
        <!-- empleados  -->

                    <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                    <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/empleados">
                            Empleados</a></li>
                    <?php } ?>
        <!-- rol empleados  -->
                    <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                    <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/rolesEmpleados">
                            Roles</a></li>
                    <?php } ?>
                    
                </ul>
            </li>
            <?php } ?>

        <!-- clientes  -->
        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <li class="treeview" id="menu-clientes">
                <a class="app-menu__item" href="<?= base_url(); ?>/clientes">
                    <i class="app-menu__icon bi bi-person-fill"></i>
                    <span class="app-menu__label">Clientes</span>
                </a>
            </li>
        <?php } ?>
        <!-- usuarios rol usuarios  -->
        <?php if (!empty($_SESSION['permisos'][5]['r']) || !empty($_SESSION['permisos'][6]['r'])) { ?>
            <li class="treeview" id="menu-usuario">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-mouse-fill"></i>
                    <span class="app-menu__label">Usuario</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
        <!-- usuarios  -->
                <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/usuarios">
                            Usuarios</a></li>
                            <?php } ?>
        <!-- rol usuarios  -->
                            <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>              
                    <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/rolesUsuarios">
                            Permisos</a></li>
                            
                            <?php } ?>
                </ul>
            </li>
            <?php } ?>

        <!-- punto de ventas - ventas- salidas - servicios  -->
        <?php if (!empty($_SESSION['permisos'][7]['r']) || !empty($_SESSION['permisos'][8]['r']) || !empty($_SESSION['permisos'][9]['r'])) { ?>
            <li class="treeview" id="menu-puntoventa">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-archive-fill"></i>
                    <span class="app-menu__label">Punto de venta</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
        <!-- ventas  -->

                    <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
                        <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/ventas">
                                Venta</a></li>
                    <?php } ?>
        <!--  salidas   -->

                    <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
                        <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/salidas">
                                Salida</a></li>
                    <?php } ?>
        <!-- servicios  -->

                    <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
                        <li><a class="treeview-item pl-5" href="<?= base_url(); ?>/servicios">
                                Servicios</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
       

        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/logout">
                <i class="app-menu__icon bi bi-arrow-bar-right"></i>
                <span class="app-menu__label">Cerrar sesión</span>
            </a>
        </li>
    </ul>
</aside>

<script>
</script>