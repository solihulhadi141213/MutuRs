//Fungsi Menampilkan Data
function filterAndLoadTable() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    $.ajax({
        type: 'POST',
        url: '_Page/PermintaanSiswa/TabelPermintaan.php',
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
            url 	    : '_Page/PermintaanSiswa/FormFilter.php',
            data        : {KeywordBy: KeywordBy},
            success     : function(data){
                $('#FormFilter').html(data);
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
            url 	    : '_Page/PermintaanSiswa/FormDetail.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });


    //Detail Foto
    $('#ModalDetailFoto').on('show.bs.modal', function (e) {
        var foto = $(e.relatedTarget).data('foto');
        $('#FormDetailFoto').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PermintaanSiswa/FormDetailFoto.php',
            data        : {foto: foto},
            success     : function(data){
                $('#FormDetailFoto').html(data);
            }
        });
    });

    //Edit Permintaan
    $('#ModalEdit').on('show.bs.modal', function (e) {
        var id_permintaan = $(e.relatedTarget).data('id');
        $('#FormEdit').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/PermintaanSiswa/FormEdit.php',
            data        : {id_permintaan: id_permintaan},
            success     : function(data){
                $('#FormEdit').html(data);
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
                        window.location.href = 'index.php?Page=PermintaanSiswa';
                    }
                }
            }
        });
    });

});