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
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/home">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/identitas">Identitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/profile">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/changepass">Ganti Password</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/pangkat">Pangkat</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/korps">Korps</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/personil">Personil</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/role">Departemen</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/divisi">Divisi</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>/sim">Simulator</a></li>
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
                    <!-- RENLAT --> 
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/suratmasuk">Surat Masuk</a></li> 
                    <!-- OPSLAT -->
                    <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/oprsim">Operasional Simulator</a></li> 
                </ul>
            </div>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cetak" aria-expanded="false" aria-controls="cetak">
                <i class="mdi mdi-printer menu-icon"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cetak">
                <ul class="nav flex-column sub-menu">
                     <li class="nav-item"><a class="nav-link" href="#">Kondisi KRI</a></li> 
                </ul>
            </div>
        </li>
        -->
    </ul>
</nav>
<div class="main-panel">