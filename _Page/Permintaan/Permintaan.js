//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/Permintaan/TabelPermintaan.php',
        data: ProsesFilter,
        success: function(data) {
            $('#TabelPermintaan').html(data);
            // Re-inisialisasi tooltip setelah data dimuat
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });
}

$(document).ready(function() {

    //tangkap 'put_id_permintaan'
    if ($('#put_id_permintaan').length) {
        var put_id_permintaan=$('#put_id_permintaan').val();
    }else{
        var put_id_permintaan="";
    }
    
    //Menampilkan Data Pada Saat Pertama Kali
    filterAndLoadTable();

    //Proses Filter/Pencarian
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        filterAndLoadTable();
        $('#ModalFilterPermintaan').modal('hide');
    });

    //Ketika keyword_by diubah
    $('#KeywordBy').change(function(){
        var KeywordBy =$('#KeywordBy').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormFilter.php',
            data        : {KeywordBy: KeywordBy},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Ketika Modal Tambah Muncul
    $('#ModalTambah').on('show.bs.modal', function (e) {
        $('#select_siswa').select2({
            placeholder     : "Cari Siswa...",
            theme           : 'bootstrap-5',
            dropdownParent: $('#ModalTambah'),
            ajax: {
                url         : '_Page/Permintaan/SelectSiswa.php',
                type        : 'POST',
                dataType    : 'json',
                delay       : 250,
                data: function(params) {
                    return { search: params.term };
                },
                processResults: function(data) {
                    return { results: data };
                },
                cache: true
            }
        });
    });

    //Proses Tambah
    $('#ProsesTambah').submit(function(){
        $('#NotifikasiTambah').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesTambah')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/ProsesTambah.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiTambah').html(data);
                var NotifikasiTambahBerhasil=$('#NotifikasiTambahBerhasil').html();
                if(NotifikasiTambahBerhasil=="Success"){
                    $('#NotifikasiTambah').html('');
                    $('#page').val("1");
                    $("#ProsesFilter")[0].reset();
                    $("#ProsesTambah")[0].reset();
                    $('#ModalTambah').modal('hide');
                    Swal.fire(
                        'Success!',
                        'Tambah Permintaan Berhasil!',
                        'success'
                    )
                    //Menampilkan Data
                    filterAndLoadTable();
                }
            }
        });
    });

    //Detail Permintaan
    $('#ModalDetail').on('show.bs.modal', function (e) {
        var id_permintaan = $(e.relatedTarget).data('id');
        $('#FormDetail').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormDetail.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    //Modal Update Status Permintaan
    $('#ModalUpdateStatusPermiintaan').on('show.bs.modal', function (e) {

        //Tangkap id_permiintaan
        var id_permintaan = $(e.relatedTarget).data('id');

        //Tampilkan Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormUpdateStatusPermiintaan.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){

                //Tampilkan Form
                $('#FormUpdateStatusPermiintaan').html(data);

                //Tangkap status_put
                var status_put=$('#status_put').val();

                if(status_put=="Selesai"){
                    $(".button_update_status_permintaan").prop("disabled", true);
                }
                if(status_put=="Ditolak"){
                    $(".button_update_status_permintaan").prop("disabled", true);
                }
                if(status_put==""){
                    $(".button_update_status_permintaan").prop("disabled", false);
                }
                if(status_put=="Diterima"){
                    $(".button_update_status_permintaan").prop("disabled", false);
                }
                if(status_put=="Proses"){
                    $(".button_update_status_permintaan").prop("disabled", false);
                }

                //Form Lanjutan Di Kosongkan
                $('#FormLanjutan').html("");

                //Pastikan Notifikasi Dikosongkan
                $('#NotifikasiUpdateStatusPermiintaan').html("");
            }
        });
    });

    //Detail Foto
    $('#ModalDetailFoto').on('show.bs.modal', function (e) {
        var foto = $(e.relatedTarget).data('foto');
        $('#FormDetailFoto').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormDetailFoto.php',
            data        : {foto: foto},
            success     : function(data){
                $('#FormDetailFoto').html(data);
            }
        });
    });

    $(document).on('change', '#status', function(){
        var status = $(this).val();

        // Loading
        $('#FormLanjutan').html('Loading...');
        $.ajax({
            type    : 'POST',
            url     : '_Page/Permintaan/FormLanjutan.php',
            data    : { status: status },
            success : function(data){
                $('#FormLanjutan').html(data);
            }
        });
    });

    //Proses Update Status Permintaan
    $('#ProsesUpdateStatusPermiintaan').submit(function(){

        //Loading Notifikasi
        $('#NotifikasiUpdateStatusPermiintaan').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');

        //Tangkap Data
        var form = $('#ProsesUpdateStatusPermiintaan')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/ProsesUpdateStatusPermiintaan.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiUpdateStatusPermiintaan').html(data);

                //Tangkap Variabel Notifikasi Proses
                var NotifikasiUpdateStatusPermiintaanBerhasil=$('#NotifikasiUpdateStatusPermiintaanBerhasil').html();

                //Jika Berhasil
                if(NotifikasiUpdateStatusPermiintaanBerhasil=="Success"){
                    if(put_id_permintaan==""){
                        //Kosongkan Notifikasi dan Form lanjutan
                        $('#NotifikasiUpdateStatusPermiintaan').html('');
                        $('#FormLanjutan').html('');

                        //Tutup Modal
                        $('#ModalUpdateStatusPermiintaan').modal('hide');

                        //Tampilkan Swal
                        Swal.fire(
                            'Success!',
                            'Ubah Status Permintaan Berhasil!',
                            'success'
                        )

                        //Menampilkan Ulang Data
                        filterAndLoadTable();
                    }else{
                        location.reload();
                    }
                    
                }
            }
        });
    });

    //Edit Permintaan
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_permintaan = $(e.relatedTarget).data('id');
        $('#FormEdit').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormEdit.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){
                $('#FormEdit').html(data);

                //select2
                $('#select_siswa_edit').select2({
                    placeholder     : "Cari Siswa...",
                    theme           : 'bootstrap-5',
                    dropdownParent: $('#ModalEdit'),
                    ajax: {
                        url         : '_Page/Permintaan/SelectSiswaEdit.php',
                        type        : 'POST',
                        dataType    : 'json',
                        data        : {id_permintaan: id_permintaan},
                        delay       : 250,
                        data: function(params) {
                            return { search: params.term };
                        },
                        processResults: function(data) {
                            return { results: data };
                        },
                        cache: true
                    }
                });
            }
        });
    });

    //Proses Edit Permintaan
    $('#ProsesEdit').submit(function(){
        $('#NotifikasiEdit').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesEdit')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/ProsesEdit.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiEdit').html(data);
                var NotifikasiEditBerhasil=$('#NotifikasiEditBerhasil').html();
                if(NotifikasiEditBerhasil=="Success"){

                    if(put_id_permintaan==""){
                        $('#NotifikasiEdit').html('');
                        $('#ModalEdit').modal('hide');
                        Swal.fire(
                            'Success!',
                            'Ubah Permintaan Berhasil!',
                            'success'
                        )
                        //Menampilkan Data
                        filterAndLoadTable();
                    }else{
                        location.reload();
                    }
                }
            }
        });
    });

    
    //Modal Hapus Permintaan
    $('#ModalHapus').on('show.bs.modal', function (e) {
        var id_permintaan = $(e.relatedTarget).data('id');
        $('#FormHapus').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/FormHapus.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    //Proses Hapus Permintaan
    $('#ProsesHapus').submit(function(){
        $('#NotifikasiHapus').html('<div class="spinner-border text-secondary" role="status"><span class="sr-only"></span></div>');
        var form = $('#ProsesHapus')[0];
        var data = new FormData(form);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Permintaan/ProsesHapus.php',
            data 	    :  data,
            cache       : false,
            processData : false,
            contentType : false,
            enctype     : 'multipart/form-data',
            success     : function(data){
                $('#NotifikasiHapus').html(data);
                var NotifikasiHapusPermintaanBerhasil=$('#NotifikasiHapusPermintaanBerhasil').html();
                if(NotifikasiHapusPermintaanBerhasil=="Success"){
                    if(put_id_permintaan==""){
                        $('#NotifikasiHapus').html('');
                        $('#ModalHapus').modal('hide');
                        Swal.fire(
                            'Success!',
                            'Hapus Data Permintaan Berhasil!',
                            'success'
                        )
                        //Menampilkan Data
                        filterAndLoadTable();
                    }else{
                        window.location.href = 'index.php?Page=Permintaan';
                    }
                }
            }
        });
    });

});