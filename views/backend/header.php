<style>
    .delete-notice {
    display: none;
}

.notify-item:hover .delete-notice {
    display: inline-block;
}

/* CUSTOM HEADER AND LOGO STYLES */
.navbar-custom {
    min-height: 110px !important; /* Increase header height */
    display: flex;
    align-items: center;
}

.topnav-logo {
    display: flex;
    align-items: center;
    height: 100%;
}

.topnav-logo img {
    height: auto !important;
    max-height: 85px !important; /* Adjust based on header height */
    width: auto !important;
    object-fit: contain;
}
</style>
<?php

$this->load->database();

// Fetch notice IDs from the notifications table for the logged-in user
$user_id = $this->session->userdata('user_id');

$this->db->select('notice_id');
$this->db->select('user_id');
$this->db->where('user_id', $user_id);
$notification_data = $this->db->get('notifications')->result_array();


// Extract only the notice IDs
$notice_ids = array_column($notification_data, 'notice_id');
$notification_userid = array_column($notification_data, 'user_id');


$notices = [];
if (!empty($notice_ids)) {
    // Fetch corresponding notices from the noticeboard table using notice IDs
    $this->db->where_in('id', $notice_ids);
    $this->db->order_by('id', 'DESC');
    $notices = $this->db->get('noticeboard')->result();
}

?>

<!-- Topbar Start -->
<div class="navbar-custom topnav-navbar topnav-navbar-dark">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="<?php echo site_url($this->session->userdata('role')); ?>" class="topnav-logo" style = "min-width: unset;">
            <span class="topnav-logo-lg">
                <img src="<?php echo $this->settings_model->get_logo_light(); ?>" alt="">
            </span>
            <span class="topnav-logo-sm">
                <img src="<?php echo $this->settings_model->get_logo_light('small'); ?>" alt="">
            </span>
        </a>
        <ul class="list-unstyled topbar-menu float-end mb-0">
            <?php if ($this->session->userdata('user_type') != 'superadmin'): ?>
                <?php
                // Fetch unread notification count for the logged-in user
                $user_id = $this->session->userdata('user_id');
                $this->db->where('user_id', $user_id);
                $this->db->where('status', 'unread'); // Count only unread notifications
                $unread_count = $this->db->count_all_results('notifications');
                ?>

                <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none me-0 position-relative" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" onclick="markAsRead(<?php echo $user_id; ?>)">
                        <img style="height: 42px; width: auto; margin-top: 14px;" 
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAADt0lEQVR4nO2aTYhURxDHK5qDRgNRxPiRxKhRMIQgCnrRnHJIBIP4FVRCPOQQREM+ZBUREQUFPRhCgqdcAwprcvIgUcEv2OQiak4RBkY246LuvH1d/5rnqUPpzlprXNeN773pGfsHBcO+3n/1++jqruomikQikUgkEolECqVer89NgbUpsE1Evn2S6TVtU2803qZOwHs/TkS2MHMPAxiTMfeIyGbVoHZERN5k4OKYb/y/dgHAG9ROZFm2iIGKvRGI3GGRbgBHHXDwSabXHrTRtsMfQkU1qR3w3k+FyA1z4/dYpKtWq016Vo2+vr7JLLILIv1G57pqU+gw80/NTjugBmDZ/9UCsJyB20NfgsgPFDIDAwMLGEhNIPvoeTWZeZUZCgNJksynUGGR3eZtdeemy/yb0e2iUAFwttnRFFiTl66uDYZiAfA7hQoDN83nPzMvXQCzzTD4m0LEez/OjH/nvR+fo/bLqtmMA0Eujrz3U4eiP/OtvPUd8E9T33v/GoVGkiTvmDn7at76AP5q6idJMo9CA8AyM07P563PwGUTX5ZQaIjIRvMATuStb6fCFFhPoQHgiJmrdxegv9+sMA9TaDBwbqiDjcaHeesDWG1izBkKid7e3lcgcnewg+y9n5K3DwCzbGZZrVYnUig45zbYQkZRfjQjNHFgHYUCi3Sbpeo3hflh3mfizEkKAefcdAaS5gqwyOpNlmULzUxTT9N0GrUaBxwy0fl00f7sesABB4r291SYecaw8lUO+f9oiMgmEwzvanCkVsEi35edpmoi5Jj/NLHgGLWCLMveNWMfIvJBWb4BfGKrRM6596lMvPcv6Rs3b+FU2f4137Bfn/6ttA5wo7HVjMN+rQVSybj799/Tt29ewuel5f2O+ZZxvIdaxIN9BFODKKVsziJd5u1fq1QqE6hFeO9ftWU4EdlZuFMGThiHnxbucLT+MH9hAuIvZTg8brOykXZ6yzLtgxmOPxb+ANI0XakZXw6bnnkbp2m6gsoAwNemShuCpQC+orKLoAC+HGmntyzTPgS9XRZ50RGRtwZT2Mt6auQZS18XGLjSLzKH2h08DJjNdPnX0dprpcesM76jdoeZFw+bMUQ+G6mtHoqy0xqApdQJsDk1olOWA7brhmfzuv7WI3KPHa44Tp1Cn575Yf7Dzt261+eAn9Xsvt/gzffo/1An4Zx7fdj+3sh2SdtSJ1KtVicOlrYfHXx6VOCsMfPeoDY8ikKPzDHzxw7Yoaa/x3KMLhKJRCKRSCQSoefmXwkzkQW25NV6AAAAAElFTkSuQmCC" alt="Notification Icon">
                        
                        <?php if ($unread_count > 0): ?>
                            <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="bottom: 1px; right: 19px;">
                                <?php echo $unread_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" style="min-width: 300px;">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0"><?php echo get_phrase('Notification'); ?>!</h6>
                        </div>

                        <?php if (!empty($notices)): ?>
                            <?php foreach ($notices as $notice): ?>
                                <?php 
                                    if (in_array($user_id, $notification_userid)):
                                ?>
                                    <div class="dropdown-item notify-item d-flex align-items-start" id="notice-<?php echo $notice->id; ?>">
                                        <div class="me-2">
                                            <i style="line-height: 36px" class="mdi mdi-bell-ring-outline noti-icon"></i>
                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <a href="<?php echo site_url('home/notice_details/'.$notice->id);?>" class="font-weight-bold" style="margin-right: 7px;">
                                                    <?php 
                                                        $notice_text = $notice->notice_title;
                                                        echo (strlen($notice_text) > 20) ? substr($notice_text, 0, 40) . '...' : $notice_text;
                                                    ?>
                                                </a>
                                                <p class="text-muted mb-0" style="font-size: 10px;">
                                                    <?php 
                                                        $notice_text = $notice->notice;
                                                        echo (strlen($notice_text) > 10) ? substr($notice_text, 0, 40) . '...' : $notice_text;
                                                    ?>
                                                </p>
                                            </div>
                                            <span class="text-muted small"><?php echo date('M j, Y', strtotime($notice->date)); ?></span> 
                                        </div>
                                        <button class="btn btn-sm btn-secondary ms-2 delete-notice" data-notice-id="<?php echo $notice->id; ?>">
                                            <i class="mdi mdi-close"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center text-muted"><?php echo get_phrase('no_notices_available'); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endif; ?>
          <?php if ($this->session->userdata('user_type') == 'superadmin'): ?>
              <li class="dropdown notification-list topbar-dropdown d-none d-lg-block">
                  <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" onclick="getLanguageList()">
                      <i class="mdi mdi-translate noti-icon"></i> <?php echo ucfirst(get_settings('language')); ?>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                      <!-- item-->
                      <div class="dropdown-item noti-title">
                          <h5 class="m-0">
                              <?php echo get_phrase('language'); ?>
                          </h5>
                      </div>

                      <div class="slimscroll" id="language-list" style="min-height: 150px;">

                      </div>
                  </div>
              </li>
          <?php endif; ?>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name"><?php echo $user_name; ?></span>
                        <?php if (strtolower($this->db->get_where('users', array('id' => $user_id))->row('role')) == 'admin'): ?>
                            <span class="account-position"><?php echo get_phrase('school_admin'); ?></span>
                        <?php else: ?>
                            <span class="account-position"><?php echo ucfirst($this->db->get_where('users', array('id' => $user_id))->row('role')); ?></span>
                        <?php endif; ?>

                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><?php echo get_phrase('welcome'); ?> !</h6>
                    </div>

                    <!-- item-->
                    <a href="<?php echo route('profile'); ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span><?php echo get_phrase('my_account'); ?></span>
                    </a>
                    <?php if ($this->session->userdata('user_type') == 'superadmin'): ?>
                        <!-- item-->
                        <a href="<?php echo route('system_settings'); ?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-edit me-1"></i>
                            <span><?php echo get_phrase('settings'); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'superadmin' || $this->session->userdata('user_type') == 'admin'): ?>
                        <!-- item-->
                        <a href="mailto:support@creativeitem.com?Subject=Help%20On%20This" target="_blank" class="dropdown-item notify-item">
                            <i class="mdi mdi-lifebuoy me-1"></i>
                            <span><?php echo get_phrase('support'); ?></span>
                        </a>
                    <?php endif; ?>

                    <!-- item-->
                    <a href="<?php echo site_url('login/logout'); ?>" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span><?php echo get_phrase('logout'); ?></span>
                    </a>

                </div>
            </li>

        </ul>
        <div class="app-search dropdown pt-1 mt-2">
            <h4 style="color: #fff; float: left;" class="d-none d-md-inline-block"> <?php echo get_settings('system_name'); ?></h4>
            <a href="<?php echo site_url(); ?>" target="" class="btn btn-outline-light ms-2 d-none d-md-inline-block"><?php echo get_phrase('visit_website'); ?></a>
        </div>
        <a class="button-menu-mobile disable-btn">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
    </div>
</div>
<!-- end Topbar -->


<script type="text/javascript">

$(document).on('click', '.delete-notice', function(event) {
    event.stopPropagation(); 
    event.preventDefault();

    var noticeId = $(this).data('notice-id');

    $.ajax({
        url: "<?php echo base_url('home/delete_notification'); ?>",
        type: "POST",
        data: { notice_id: noticeId },
        success: function(response) {
            if (response == "success") {
                $("#notice-" + noticeId).fadeOut("slow", function() {
                    $(this).remove();
                });

                updateUnreadCount();
            } else {
                alert("Failed to delete notification.");
            }
        }
    });
    
});



function markAsRead(user_id) {
    $.ajax({
        url: "<?php echo site_url('home/mark_as_read'); ?>",
        type: "POST",
        data: { user_id: user_id },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.success) {
                // Hide the notification count badge
                $(".badge.bg-danger").fadeOut();
                
                // Optionally, you can also change the styling of notifications in the dropdown
                $(".dropdown-item.notify-item").addClass("text-muted");
            }
        }
    });
}


function getLanguageList() {
    $.ajax({
        url: "<?php echo route('language/dropdown'); ?>",
        success: function(response){
            $('#language-list').html(response);
        }
    });
}
</script>
