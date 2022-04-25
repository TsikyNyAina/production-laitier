<?php 
    $ustilasateur = $this->session->get_userdata();

    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<title>Production Laitier || Acceuil</title>
<link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/plugins/charts-c3/plugin.css"/>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/plugins/morrisjs/morris.min.css" />
<!-- Custom Css -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets1/css/style.min.css">
</head>

<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo base_url(); ?>assets1/images/loader.svg" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    
</div>

<!-- Right Icon menu Sidebar -->
<div class="navbar-right">
    <ul class="navbar-nav">
        <li><a href="<?php echo base_url('Login/logout'); ?>" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a></li>
    </ul>
</div>

<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="<?php echo base_url(); ?>assets1/images/logo.svg" width="25" alt="Aero"><span class="m-l-10">Production</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    
                    <div class="detail">
                        <h4><?php echo $ustilasateur['nom']; ?></h4>
                        <?php if(isset($ustilasateur['isSuperAdmin'])){ ?>
                        <small>Super Admin</small>                        
                        <?php }else{ ?>
                        <small>Simple utilisateur</small>
                        <?php } ?>
                    </div>
                </div>
            </li>
             <?php if(isset($ustilasateur['isSuperAdmin'])){ ?>
            <li class="active open"><a href="<?php echo base_url('Login/validation'); ?>"><i class="zmdi zmdi-home"></i><span>Validation Inscription</span></a></li>
            <?php } ?>
            <li class="menu-toggle"><a href="<?php echo base_url('Matiere'); ?>"><i class="zmdi zmdi-assignment"></i><span>Insertion Achat</span></a></li>
            <li class="menu-toggle"><a href="<?php echo base_url('Matiere/listeAchatNec'); ?>"><i class="zmdi zmdi-assignment"></i><span>Liste Achat A Faire</span></a></li>
            <li class="menu-toggle"><a href="<?php echo base_url('Matiere/mouvement'); ?>"><i class="zmdi zmdi-grid"></i><span>Etat de stock</span></a></li>
            <li class="menu-toggle"><a href="<?php echo base_url('Produit'); ?>"><i class="zmdi zmdi-grid"></i><span>Ajout Produit</span></a></li>
            <li class="menu-toggle"><a href="<?php echo base_url('Produit/mouvement'); ?>"><i class="zmdi zmdi-grid"></i><span>Etat de stock Produit</span></a></li>
            <li class="menu-toggle"><a href="<?php echo base_url('Produit/insertVente'); ?>"><i class="zmdi zmdi-grid"></i><span>Vente Produit</span></a></li>
        </ul>
    </div>
</aside>

<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
</aside>

<!-- Main Content -->

<section class="content">
    <div class="">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Bienvenue <?php echo $ustilasateur['nom']; ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Production laitier</a></li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            
            <div class="row clearfix">
                
            </div>
            <div class="row clearfix">
              
            </div>
            <div class="row clearfix">
            </div>
            <div class="row clearfix">
            </div>
        </div>
    </div>
</section>


<!-- Jquery Core Js --> 
<script src="<?php echo base_url(); ?>assets1/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="<?php echo base_url(); ?>assets1/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->

<script src="<?php echo base_url(); ?>assets1/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
<script src="<?php echo base_url(); ?>assets1/bundles/sparkline.bundle.js"></script> <!-- Sparkline Plugin Js -->
<script src="<?php echo base_url(); ?>assets1/bundles/c3.bundle.js"></script>

<script src="<?php echo base_url(); ?>assets1/bundles/mainscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets1/js/pages/index.js"></script>
</body>


</html>