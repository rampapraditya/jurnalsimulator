<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#home" aria-expanded="false" aria-controls="home">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Home</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="home">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/homenoadmin">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/profilenon">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/changepassnon">Ganti Password</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#trans" aria-expanded="false" aria-controls="trans">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="trans">
                <ul class="nav flex-column sub-menu">
                    <?php
                    if($nmrole == "DEPRENLAT"){
                        ?>
                    <!-- RENLAT --> 
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/suratmasuknon">Jurnal Surat Masuk</a></li>
                        <?php
                    }else if($nmrole == "DEPOPSLAT"){
                        ?>
                    <!-- OPSLAT -->
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/oprsimnon">Jurnal Ops Simulator</a></li> 
                    <!-- SAKIT SIMULATOR -->
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/sakitsimnon">Jurnal Sakit Simulator</a></li> 
                        <?php
                    }else if($nmrole == "DEPDUKOPSLAT"){
                        ?>
                    <!-- JURNAL SAKIT DIVISI HARSIS -->
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/sshnon">Jurnal Sakit Harsis</a></li> 
                    <!-- JURNAL PERAWATAN SIMULATOR SAKIT -->
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/jhhnon">Jurnal Harwat Harsis</a></li> 
                        <?php
                    }else if($nmrole == "KOMANDAN" || $nmrole == "WADAN"){
                        ?>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/suratmasuknon">Jurnal Surat Masuk</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/oprsimnon">Jurnal Ops Simulator</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/sakitsimnon">Jurnal Sakit Simulator</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/sshnon">Jurnal Sakit Harsis</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/jhhnon">Jurnal Harwat Harsis</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </li>
    </ul>
</nav>
<div class="main-panel">