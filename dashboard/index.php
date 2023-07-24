<?php include_once "../layouts/session.php"; ?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/menu.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php //echo mb_strtoupper($_SESSION['nomemp']); ?>
            <!-- <small>Control panel</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
            <li class="active"><?php // echo $title; ?></li>
        </ol>
    </section>
    <!-- Content Header (Page header) -->
    
    <!-- /.content -->
</div><!-- /.content-wrapper -->


<?php include '../layouts/footer.php'?>
