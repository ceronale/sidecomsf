<?php
require_once("class.menu.php");
$menu_class = new menu();
?>

<style>
  #treeview2 {
    background-color: #2d5260 !important
  }

  #treeview3 {
    background-color: #4c92af !important
  }

  ;
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
</nav>
<!-- /.navbar -->
<style>
  /* ... Otros estilos que ya tienes ... */

  .sticky-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    /* Puedes ajustar la anchura del menú según tus necesidades */
    width: 250px;
    /* Agrega otros estilos que necesites para que el menú se vea bien */
  }
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sticky-sidebar">

  <!-- Brand Logo -->
  <a href="../dashboard/" class="brand-link">
    <img src="../assets/img/logo/sidecoms-logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Sidecoms</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->




    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->




        <?php
        $data  = $menu_class->getMenuPpal();
        $key   = $data[1];
        foreach ($key as $menu) {  ?>
          <?php if ($menu['url'] === '#') { ?>

            <li class="nav-item">
              <a href="<?php print $menu['url']; ?>" class="nav-link">
                <i class="nav-icon <?php print $menu['icon']; ?>"></i>
                <p>
                  <?php print $menu['nombre_menu']; ?>
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">



                <?php
                $data2    = $menu_class->getSubMenu($menu['id_menu']);
                $key2   = $data2[1];
                $count_submenu = count($data2[1]);
                //
                if ($count_submenu >= 1) { ?>

                  <?php foreach ($key2 as $sub_menu) { ?>
                    <?php if ($sub_menu['url'] === '#') { ?>

                      <li class="nav-item">
                        <a href="<?php print $sub_menu['url']; ?>" class="nav-link">
                          <i class="<?php print $sub_menu['icon']; ?> nav-icon"></i>
                          <p>
                            <?php print $sub_menu['nombre_sub_menu']; ?>
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview" id="treeview2" name="treeview2">

                          <?php
                          $data3      = $menu_class->getSubMenuLevel2($sub_menu['id_sub_menu']);
                          $key3   = $data3[1];
                          $count_menu_sub_level_2 = count($data3[1]);
                          //
                          if ($count_menu_sub_level_2 >= 1) { ?>
                            <?php foreach ($key3 as $menu_sub_level_2) { ?>
                              <?php if ($menu_sub_level_2['url'] === '#') { ?>

                                <li class="nav-item">
                                  <a href="<?php print $menu_sub_level_2['url']; ?>" class="nav-link">
                                    <i class="<?php print $menu_sub_level_2['icon']; ?> nav-icon"></i>
                                    <p>
                                      <?php print $menu_sub_level_2['nombre_sub_menu_level_2']; ?>
                                      <i class="right fas fa-angle-left"></i>
                                    </p>
                                  </a>
                                  <ul class="nav nav-treeview" id="treeview3" name="treeview3">


                                    <?php
                                    $data4      = $menu_class->getSubMenuLevel3($menu_sub_level_2['id_sub_menu_level_2']);
                                    $key4   = $data4[1];
                                    $count_menu_sub_level_3 = count($data4[1]);
                                    //
                                    if ($count_menu_sub_level_3 >= 1) { ?>
                                      <?php foreach ($key4 as $menu_sub_level_3) { ?>

                                        <li class="nav-item">
                                          <a href="<?php print $menu_sub_level_3['url']; ?>" class="nav-link">
                                            <i class="<?php print $menu_sub_level_3['icon']; ?> nav-icon"></i>
                                            <p><?php print $menu_sub_level_3['nombre_sub_menu_level_3']; ?></p>
                                          </a>
                                        </li>



                                    <?php   }
                                    } ?>

                                  </ul>
                                </li>

                              <?php   } else {

                              ?>

                                <li class="nav-item">
                                  <a href="<?php print $menu_sub_level_2['url']; ?>" class="nav-link">
                                    <i class="<?php print $menu_sub_level_2['icon']; ?> nav-icon"></i>
                                    <p><?php print $menu_sub_level_2['nombre_sub_menu_level_2']; ?></p>
                                  </a>
                                </li>

                            <?php  }
                            } ?>

                        </ul>
                      </li>

                    <?php   } else { ?>
              </ul>
            </li>

          <?php }
                        } else {   ?>



          <li class="nav-item">
            <a href="<?php print $sub_menu['url']; ?>" class="nav-link">
              <i class="<?php print $sub_menu['icon']; ?> nav-icon"></i>
              <p><?php print $sub_menu['nombre_sub_menu']; ?></p>
            </a>
          </li>

      <?php   }
                      }



      ?>

    <?php
                } else { ?>





    <?php } ?>


      </ul>
      </li>
    <?php   } else { ?>

      <li class="nav-item">
        <a href="<?php print $menu['url']; ?>" class="nav-link">
          <i class="<?php print $menu['icon']; ?> nav-icon"></i>
          <p><?php print $menu['nombre_menu']; ?></p>
        </a>
      </li>

  <?php  }
        } ?>







  </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>