<main id="content" role="main">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root { 
            --primary-color: #003366; 
            --secondary-color: #001e3c;
            --accent-color: #ffc107; 
            --text-light: #f8f9fa;
        }
        body { font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }

        /* --- 1. HERO SLIDER SECTION --- */
        .hero-slider {
            width: 100%;
            height: 100vh;
            min-height: 600px;
            position: relative;
        }
        .hero-slide {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .slide-bg {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-size: cover; background-position: center; z-index: 1;
            transform: scale(1); transition: transform 8s ease;
        }
        .swiper-slide-active .slide-bg { transform: scale(1.1); }
        .slide-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(0,30,60,0.6), rgba(0,30,60,0.9)); z-index: 2;
        }
        .slide-content {
            position: relative; z-index: 3; text-align: center; color: white;
            padding: 20px; max-width: 900px;
        }
        .slide-title {
            font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem;
            opacity: 0; transform: translateY(30px); transition: all 0.8s ease 0.3s;
        }
        .slide-desc {
            font-size: 1.25rem; font-weight: 300; margin-bottom: 2.5rem;
            opacity: 0; transform: translateY(30px); transition: all 0.8s ease 0.5s; line-height: 1.6;
        }
        .slide-btns { opacity: 0; transform: translateY(30px); transition: all 0.8s ease 0.7s; }
        .swiper-slide-active .slide-title, .swiper-slide-active .slide-desc, .swiper-slide-active .slide-btns { opacity: 1; transform: translateY(0); }
        .swiper-button-next, .swiper-button-prev { color: var(--accent-color); }
        .swiper-pagination-bullet-active { background: var(--accent-color); }

        /* --- 2. STATISTIK --- */
        .stat-section { margin-top: -80px; position: relative; z-index: 10; padding-bottom: 50px; }
        .stat-card { 
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            padding: 30px; border-radius: 15px; text-align: center; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-bottom: 4px solid transparent; transition: 0.3s;
        }
        .stat-card:hover { transform: translateY(-10px); border-bottom-color: var(--accent-color); }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--primary-color); }

        /* --- 3. HOMEPAGE NOTE (NEW) --- */
        .note-section { position: relative; }
        .note-content { font-size: 1.1rem; line-height: 1.8; color: #555; }

        /* --- GLOBAL COMPONENTS --- */
        .hover-card { transition: all 0.3s; border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .section-title { position: relative; display: inline-block; padding-bottom: 15px; margin-bottom: 40px; }
        .section-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 70px; height: 4px; background: var(--accent-color); border-radius: 2px; }
        .date-badge { background: var(--primary-color); color: white; padding: 12px; border-radius: 10px; text-align: center; min-width: 80px; }
        
        .lecturer-img { width: 130px; height: 130px; object-fit: cover; border-radius: 50%; border: 5px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 15px; transition: 0.3s; }
        .lecturer-card:hover .lecturer-img { transform: scale(1.05); border-color: var(--accent-color); }
        .social-btn { width: 36px; height: 36px; line-height: 36px; border-radius: 50%; display: inline-block; margin: 0 3px; color: white; transition: 0.3s; }
        .social-btn:hover { opacity: 0.8; transform: translateY(-3px); }
        .social-fb { background: #3b5998; } .social-tw { background: #1da1f2; } .social-li { background: #0077b5; } .social-em { background: #ea4335; }

        @media (max-width: 768px) { .slide-title { font-size: 2rem; } .hero-slider { height: 600px; } }
    </style>

    <section class="hero-slider">
        <div class="swiper heroSwiper h-100">
            <div class="swiper-wrapper">
                <?php 
                if(isset($slider_images) && !empty($slider_images)):
                    foreach($slider_images as $slide): 
                        $slide_img = base_url('uploads/images/slider/' . $slide->image);
                ?>
                <div class="swiper-slide hero-slide">
                    <div class="slide-bg" style="background-image: url('<?php echo $slide_img; ?>');"></div>
                    <div class="slide-overlay"></div>
                    <div class="slide-content container">
                        <h1 class="slide-title"><?php echo $slide->title; ?></h1>
                        <p class="slide-desc mx-auto"><?php echo htmlspecialchars_decode($slide->description); ?></p>
                        <div class="slide-btns d-flex justify-content-center gap-4 flex-wrap">
                            <?php if($this->session->userdata('user_login') != 1): ?>
                                <a href="<?php echo site_url('login'); ?>" class="btn btn-warning btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold text-dark"><i class="fas fa-sign-in-alt me-2"></i> Login Portal</a>
                            <?php else: ?>
                                <a href="<?php echo site_url('admin/dashboard'); ?>" class="btn btn-success btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                            <?php endif; ?>
                            <a href="<?php echo site_url('home/online_admission'); ?>" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold"><i class="fas fa-user-plus me-2"></i> Daftar Online</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="swiper-slide hero-slide">
                    <div class="slide-bg" style="background-color: #003366;"></div>
                    <div class="slide-overlay"></div>
                    <div class="slide-content container">
                        <h1 class="slide-title">Selamat Datang</h1>
                        <p class="slide-desc">Silakan atur gambar slider di panel admin.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="swiper-button-next d-none d-md-block"></div>
            <div class="swiper-button-prev d-none d-md-block"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="stat-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card h-100">
                        <i class="fas fa-user-graduate fa-3x mb-3 text-primary"></i>
                        <div class="stat-number"><?php echo $stat_students; ?></div>
                        <h6 class="text-muted text-uppercase fw-bold mt-2">Mahasiswa</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card h-100">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-warning"></i>
                        <div class="stat-number"><?php echo $stat_teachers; ?></div>
                        <h6 class="text-muted text-uppercase fw-bold mt-2">Dosen</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card h-100">
                        <i class="fas fa-users fa-3x mb-3 text-success"></i>
                        <div class="stat-number"><?php echo $stat_parents; ?></div>
                        <h6 class="text-muted text-uppercase fw-bold mt-2">Wali</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="note-section py-5 bg-white overflow-hidden">
        <div class="position-absolute top-0 start-0 translate-middle bg-primary opacity-10 rounded-circle" style="width: 300px; height: 300px; filter: blur(80px);"></div>
        
        <div class="container py-4 position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center" data-aos="fade-up">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill text-uppercase fw-bold border border-primary border-opacity-10">
                        Selamat Datang
                    </span>
                    
                    <h2 class="display-6 fw-bold mb-4 text-dark">
                        <?php echo get_frontend_settings('homepage_note_title'); ?>
                    </h2>
                    
                    <div class="note-content mx-auto" style="max-width: 800px;">
                        <?php echo htmlspecialchars_decode(get_frontend_settings('homepage_note_description')); ?>
                    </div>
                    
                    <div class="mt-5">
                        <a href="<?php echo site_url('home/about'); ?>" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">
                            <?php echo get_phrase('learn_more'); ?> <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title fw-bold display-6">Agenda & Acara Kampus</h2>
                <p class="text-muted">Jangan lewatkan kegiatan penting yang akan datang.</p>
            </div>

            <div class="row g-4">
                <?php if(isset($upcoming_events) && count($upcoming_events) > 0): ?>
                    <?php foreach($upcoming_events as $event): ?>
                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm hover-card event-card p-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-3 col-md-2 text-center">
                                    <div class="date-badge w-100 py-3">
                                        <span class="h3 d-block fw-bold mb-0 lh-1"><?php echo date('d', $event['timestamp']); ?></span>
                                        <small class="text-uppercase fw-bold" style="font-size: 0.75rem;"><?php echo date('M', $event['timestamp']); ?></small>
                                    </div>
                                </div>
                                <div class="col-9 col-md-8 ps-3">
                                    <h5 class="fw-bold mb-1 text-dark text-truncate" title="<?php echo $event['title']; ?>"><?php echo $event['title']; ?></h5>
                                    <div class="text-muted small mb-0 d-flex align-items-center flex-wrap">
                                        <span class="me-3"><i class="far fa-clock text-primary me-1"></i> <?php echo date('H:i', $event['timestamp']); ?> WIB</span>
                                        <?php if(isset($event['location'])): ?>
                                            <span class="text-truncate" style="max-width: 150px;"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo $event['location']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none d-md-flex justify-content-end">
                                    <a href="<?php echo site_url('home/events'); ?>" class="btn btn-light text-primary rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5"><div class="bg-white rounded-3 p-5 border border-light"><h5 class="text-muted fw-normal">Belum ada agenda acara.</h5></div></div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-5">
                <a href="<?php echo site_url('home/events'); ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold small">Lihat Semua Agenda <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title fw-bold display-6">Dosen Profesional</h2>
                <p class="text-muted">Belajar dari para ahli yang berdedikasi tinggi.</p>
            </div>
            <div class="swiper lecturer-slider pb-5" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php if(isset($lecturers) && count($lecturers) > 0): foreach($lecturers as $lecturer):
                        $img_url = $this->user_model->get_user_image($lecturer['id']);
                        $social = json_decode($lecturer['social_links'], true); ?>
                    <div class="swiper-slide">
                        <div class="card hover-card border-0 h-100 lecturer-card">
                            <div class="text-center"><img src="<?php echo $img_url; ?>" alt="<?php echo $lecturer['name']; ?>" class="lecturer-img"></div>
                            <h5 class="fw-bold mb-1 text-truncate text-center px-2"><?php echo $lecturer['name']; ?></h5>
                            <p class="text-primary small fw-bold mb-3 text-center"><?php echo strtoupper($lecturer['designation']); ?></p>
                            <div class="text-center mt-auto">
                                <?php if(!empty($social['facebook'])): ?> <a href="<?php echo $social['facebook']; ?>" class="social-btn social-fb"><i class="fab fa-facebook-f"></i></a> <?php endif; ?>
                                <?php if(!empty($social['twitter'])): ?> <a href="<?php echo $social['twitter']; ?>" class="social-btn social-tw"><i class="fab fa-twitter"></i></a> <?php endif; ?>
                                <?php if(!empty($social['linkedin'])): ?> <a href="<?php echo $social['linkedin']; ?>" class="social-btn social-li"><i class="fab fa-linkedin-in"></i></a> <?php endif; ?>
                                <a href="mailto:<?php echo $lecturer['email']; ?>" class="social-btn social-em"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; else: ?><div class="col-12 text-center">Belum ada data dosen.</div><?php endif; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="row align-items-center mb-5">
                <div class="col-md-8"><h2 class="fw-bold mb-1">Papan Pengumuman</h2><p class="text-muted mb-0">Informasi penting dari akademik.</p></div>
                <div class="col-md-4 text-md-end"><a href="<?php echo site_url('home/noticeboard'); ?>" class="btn btn-dark rounded-pill px-4">Arsip Pengumuman</a></div>
            </div>
            <div class="row g-4">
                <?php if(isset($frontend_notices) && count($frontend_notices) > 0): foreach($frontend_notices as $row): ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm hover-card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">Info Sekolah</span>
                            <small class="text-muted fw-bold"><?php echo !empty($row['date']) ? date('d M Y', strtotime($row['date'])) : date('d M Y', $row['create_timestamp']); ?></small>
                        </div>
                        <h5 class="card-title fw-bold mb-3"><a href="<?php echo site_url('home/notice_details/'.$row['id']); ?>" class="text-dark text-decoration-none stretched-link"><?php echo $row['notice_title']; ?></a></h5>
                        <p class="card-text text-muted small mb-0"><?php echo substr(strip_tags($row['notice']), 0, 100) . '...'; ?></p>
                    </div>
                </div>
                <?php endforeach; else: ?><div class="col-12"><p class="text-muted">Tidak ada pengumuman.</p></div><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #001e3c 0%, #003366 100%);">
        <div class="container py-4" data-aos="zoom-in">
            <h2 class="mb-3 fw-bold">Siap Bergabung Bersama Kami?</h2>
            <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 600px;">Daftarkan putra-putri Anda sekarang untuk mendapatkan pendidikan terbaik.</p>
            <a href="<?php echo site_url('home/online_admission'); ?>" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold text-dark shadow-lg">Daftar Sekarang</a>
        </div>
    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800 });
    var heroSwiper = new Swiper(".heroSwiper", { loop: true, effect: "fade", speed: 1000, autoplay: { delay: 6000, disableOnInteraction: false }, pagination: { el: ".swiper-pagination", clickable: true }, navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" } });
    var lecturerSwiper = new Swiper(".lecturer-slider", { slidesPerView: 1, spaceBetween: 20, loop: true, autoplay: { delay: 3000 }, pagination: { el: ".swiper-pagination", clickable: true }, breakpoints: { 640: { slidesPerView: 2 }, 992: { slidesPerView: 3 }, 1200: { slidesPerView: 4 } } });
</script>