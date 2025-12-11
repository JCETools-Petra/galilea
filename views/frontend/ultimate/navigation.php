<?php
// Mengambil Logo
$logo_light  = $this->settings_model->get_logo_light();
$system_name  = get_frontend_settings('website_title');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-custom shadow-sm py-3 sticky-top">
  <div class="container">
    
    <a class="navbar-brand d-flex align-items-center" href="<?php echo site_url('home'); ?>">
      <img src="<?php echo $logo_light;?>" 
           alt="Logo Kampus"
           style="height: 60px; width: auto; object-fit: contain; max-width: 200px;">
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBar" aria-controls="navBar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBar">
      <ul class="navbar-nav ms-auto align-items-center">
        
        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'home') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home');?>">
             <?php echo get_phrase('Home'); ?>
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'noticeboard' || $page_name == 'notice_details') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home/noticeboard');?>">
             <?php echo get_phrase('Noticeboard'); ?>
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'event') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home/events');?>">
             <?php echo get_phrase('Events'); ?>
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'teacher') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home/teachers');?>">
             Dosen
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'gallery' || $page_name == 'gallery_view') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home/gallery');?>">
             <?php echo get_phrase('Gallery'); ?>
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?php if($page_name == 'contact') echo 'active fw-bold text-warning';?>" href="<?php echo site_url('home/contact');?>">
             <?php echo get_phrase('Contact'); ?>
          </a>
        </li>

      </ul>

      <div class="d-flex ms-lg-4 gap-2 align-items-center mt-3 mt-lg-0">
        <a href="<?php echo site_url('home/online_admission');?>" 
           class="btn btn-outline-light rounded-pill px-4 <?php if($page_name == 'online_admission') echo 'active';?>">
           <i class="fas fa-edit me-1"></i> <?php echo get_phrase('Admission'); ?>
        </a>

        <?php if($this->session->userdata('user_login') != 1): ?>
            <a href="<?php echo site_url('login'); ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
        <?php else: ?>
            <a href="<?php echo site_url('admin/dashboard'); ?>" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
            </a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</nav>

<style>
    /* Gradient Background untuk Navbar */
    .bg-gradient-custom {
        /* Gradient Biru Dongker ke Hitam (Senada dengan Hero) */
        background: linear-gradient(135deg, #003366 0%, #001e3c 100%) !important;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    /* Styling Link Menu */
    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255,255,255,0.85); /* Putih agak transparan */
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 10px 15px;
        border-radius: 5px;
    }

    /* Efek Hover Menu */
    .navbar-dark .navbar-nav .nav-link:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.1); /* Efek glass saat hover */
        transform: translateY(-1px);
    }

    /* Menu Aktif */
    .navbar-dark .navbar-nav .nav-link.active {
        color: #ffc107 !important; /* Warna Kuning Emas */
        background: transparent;
    }

    /* Mobile Responsiveness */
    @media (max-width: 991px) {
        .navbar-collapse {
            background: #001e3c; /* Latar solid untuk menu mobile */
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .navbar-nav .nav-item {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 5px;
        }
        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }
        .btn {
            width: 100%;
            margin-top: 10px;
        }
    }
</style>