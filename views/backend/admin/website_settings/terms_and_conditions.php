<div class="card">
  <div class="card-body">
    <h4 class="header-title"><?php echo get_phrase('terms_and_conditions_settings') ;?></h4>
    
    <form method="POST" class="col-12" action="<?php echo route('terms_and_conditions/update') ;?>" id="terms_form" enctype="multipart/form-data">
      <div class="row justify-content-left">
        <div class="col-12">
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="terms_content"> <?php echo get_phrase('terms_and_conditions') ;?></label>
            <div class="col-md-9">
              <textarea name="terms_and_conditions" id="terms_content" class="form-control" rows="8" cols="80"><?php echo get_frontend_settings('terms_conditions'); ?></textarea>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" id="update_btn" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12"><?php echo get_phrase('update_settings') ;?></button>
          </div>
        </div>
      </div>
    </form>

  </div> 
</div>

<script type="text/javascript">
$(document).ready(function () {
    // 1. Inisialisasi Summernote secara manual agar kita punya kontrol penuh
    $('#terms_content').summernote({
        height: 300,
        callbacks: {
            // Setiap kali ada perubahan ketikan, paksa simpan ke textarea asli
            onChange: function(contents, $editable) {
                $('#terms_content').val(contents);
            }
        }
    });

    // 2. Tangani proses submit form (Mencegah submit bawaan yang gagal)
    $('#terms_form').on('submit', function(e) {
        e.preventDefault(); // Stop reload halaman

        // Ambil tombol untuk efek loading
        var btn = $('#update_btn');
        var originalText = btn.text();
        btn.text('Loading...').prop('disabled', true);

        // Sinkronisasi akhir (PENTING: Mengambil kode HTML dari Summernote dan memasukkan ke textarea)
        var finalContent = $('#terms_content').summernote('code');
        $('#terms_content').val(finalContent);

        // Buat data form
        var formData = new FormData(this);

        // Kirim via AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Kembalikan tombol
                btn.text(originalText).prop('disabled', false);

                // Parsing respon JSON dari server
                var res = (typeof response === 'string') ? JSON.parse(response) : response;
                
                if(res.status == true) {
                    // Tampilkan notifikasi sukses
                    if(typeof success_notify === 'function') {
                        success_notify(res.notification);
                    } else {
                        // Fallback jika fungsi notifikasi bawaan tidak ada
                        alert(res.notification);
                    }
                } else {
                    if(typeof error_notify === 'function') {
                        error_notify('Gagal menyimpan data.');
                    } else {
                        alert('Gagal menyimpan data.');
                    }
                }
            },
            error: function() {
                btn.text(originalText).prop('disabled', false);
                alert('Terjadi kesalahan server.');
            }
        });
    });
});
</script>