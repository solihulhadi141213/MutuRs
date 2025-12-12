// Fungsi Untuk Menampilkan Grafik
function ShowGrafik() {
    $.getJSON("_Page/Dashboard/Grafik.php", function (data) {
        const categories = data.map(item => item.x);
        const seriesData = data.map(item => parseFloat(item.y));

        var options = {
            chart: {
                type: 'bar',
                height: 500
            },
            series: [{
                name: 'Pasien',
                data: seriesData
            }],
            xaxis: {
                categories: categories
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return value + ' Pasien';
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Jumlah Pemeriksaan Radiologi ' + new Date().getFullYear(),
                align: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
}

// Fungsi untuk menampilkan jam digital
function tampilkanJam() {
    const waktu = new Date();
    let jam = waktu.getHours().toString().padStart(2, '0');
    let menit = waktu.getMinutes().toString().padStart(2, '0');
    let detik = waktu.getSeconds().toString().padStart(2, '0');

    $('#jam_menarik').text(`${jam}:${menit}:${detik}`);
}


function formatRibuan(angka) {
    if (!angka) return "0";
    return new Intl.NumberFormat('id-ID').format(angka);
}

// Fungsi untuk menampilkan dashboard
function ShowDashboard() {
    $.ajax({
        type: 'POST',
        url: '_Page/Dashboard/CountDashboard.php',
        dataType: 'json',
        success: function(data) {
            $('#put_pasien').hide().html(formatRibuan(data.pasien)).fadeIn('slow');
            $('#put_kunjungan').hide().html(formatRibuan(data.kunjungan)).fadeIn('slow');
            $('#put_ranap').hide().html(formatRibuan(data.ranap)).fadeIn('slow');
            $('#put_rajal').hide().html(formatRibuan(data.rajal)).fadeIn('slow');
        },
        error: function(xhr, status, error) {
            console.error("Gagal mengambil data dashboard:", error);
        }
    });
}

//fungsi untuk menampilkan rekapitulasi pemeriksaan
function TabelRekapPemeriksaan() {

    var ProsesFilterPemeriksaan = $('#ProsesFilterPemeriksaan').serialize();

    // Elemen tabel
    var tabel = $('#tabel_rekap_pemeriksaan');

    // Fade-out isi tabel
    tabel.fadeTo(200, 0.3, function () {

        // Tampilkan loading spinner
        tabel.html(`
            <tr>
                <td colspan="5" class="text-center py-3">
                    <div class="spinner-border text-success" role="status" style="width:2.2rem;height:2.2rem;"></div>
                    <div><small>Memuat data...</small></div>
                </td>
            </tr>
        `);

        $.ajax({
            type    : 'POST',
            url     : '_Page/Dashboard/TabelRekapPemeriksaan.php',
            data    : ProsesFilterPemeriksaan,
            success: function(data) {

                // Ganti isi tabel dengan data baru
                tabel.html(data);

                // Fade-in tabel perlahan
                tabel.fadeTo(300, 1);
            },

            error: function() {
                tabel.html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger py-3">
                            <small>Terjadi kesalahan memuat data</small>
                        </td>
                    </tr>
                `);
                tabel.fadeTo(300, 1);
            }
        });
    });
}

function TabelDetail() {
    //Tangkap Form
    var ProsesFilterDetail = $('#ProsesFilterDetail').serialize();

    // Loading Table
    $('#TabelPelayananRadiologi').html('<tr><td class="text-center" colspan="9"><small>Loading..</small></td></tr>');

    //Tampilkan Tabel Dengan AJAX
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dashboard/TabelPelayananRadiologi.php',
        data        : ProsesFilterDetail,
        success     : function(data){
            $('#TabelPelayananRadiologi').html(data);
        }
    });
}


$(document).ready(function () {
    //Menampilkan Data Pertama Kali
    ShowGrafik();
    ShowDashboard();

    ShowDashboard();
    TabelRekapPemeriksaan();

    //Ketika Filter Di Submit
    $('#ProsesFilterPemeriksaan').submit(function(){
        $('#page_rekap_pemeriksaan').val("1");
        TabelRekapPemeriksaan();
        $('#ModalFilterPemeriksaan').modal('hide');
    });

    //Pagging tabel pemeriksaan
    $(document).on('click', '#next_button_rekap_pemeriksaan', function() {
        var page_now = parseInt($('#page_rekap_pemeriksaan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_rekap_pemeriksaan').val(next_page);
        TabelRekapPemeriksaan(0);
    });
    $(document).on('click', '#prev_button_rekap_pemeriksaan', function() {
        var page_now = parseInt($('#page_rekap_pemeriksaan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_rekap_pemeriksaan').val(next_page);
        TabelRekapPemeriksaan(0);
    });

    //Ketika click 'show_modal_detail'
    $(document).on('click', '.show_modal_detail', function(){
        var permintaan_pemeriksaan = $(this).data('key');
        var periode_1 = $(this).data('periode_1');
        var periode_2 = $(this).data('periode_2');

        //Tampilkan Modal
        $('#ModalDetail').modal('show');

        //menempelkan ke form
        $('#page_detail').val('1');
        $('#periode_1_detail').val(periode_1);
        $('#periode_2_detail').val(periode_2);
        $('#keyword_detail').val(permintaan_pemeriksaan);

        TabelDetail();
    });

    //Pagging tabel Detail
    $(document).on('click', '#next_button_detail', function() {
        var page_now = parseInt($('#page_detail').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_detail').val(next_page);
        TabelDetail(0);
    });
    $(document).on('click', '#prev_button_detail', function() {
        var page_now = parseInt($('#page_detail').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_detail').val(next_page);
        TabelDetail(0);
    });

    //Ketika Modal Export Pemeriksaan Muncul
    $('#ModalExportRekap').on('show.bs.modal', function (e) {

        //Ambil Data Dari Form 'ProsesFilterPemeriksaan'
        var ProsesFilterPemeriksaan = $('#ProsesFilterPemeriksaan').serialize();

        //Pasing Sengan AJAX ke 'FormExportPemeriksaan'
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Dashboard/FormExportPemeriksaan.php',
            data        : ProsesFilterPemeriksaan,
            success     : function(data){
                $('#FormExportPemeriksaan').html(data);
            }
        });

    });

    //Ketika Modal Modal Detail Pemeriksaan
    $('#ModalDetailPemeriksaan').on('show.bs.modal', function (e) {

        //Ambil Data 'id_rad'
        var id_rad = $(e.relatedTarget).data('id');

        //Pasing Sengan AJAX ke 'FormExportPemeriksaan'
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Dashboard/FormDetailPemeriksaan.php',
            data        : {id_rad: id_rad},
            success     : function(data){
                $('#FormDetailPemeriksaan').html(data);
            }
        });

    });

    // Ketika Click 'kembali_ke_detai'
    $('.kembali_ke_detai').on('click', function() {
        $('#ModalDetailPemeriksaan').modal('hide');
        $('#ModalExportDataPasien').modal('hide');
        $('#ModalDetail').modal('show');
    });

    //Ketika Click 'export_data_pasien'
    $('#export_data_pasien').on('click', function() {
        //Ambil Data dari Form 'ProsesFilterDetail'
        var ProsesFilterDetail = $('#ProsesFilterDetail').serialize();

        //Tampilkan Modal
        $('#ModalExportDataPasien').modal('show');

        //tutup modal detail
        $('#ModalDetail').modal('hide');

        //Loading Form
        $('#FormExportDataPasien').html('Loading...');

        //Pasing Sengan AJAX ke 'FormExportPemeriksaan'
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Dashboard/FormExportDataPasien.php',
            data        : ProsesFilterDetail,
            success     : function(data){
                $('#FormExportDataPasien').html(data);
            }
        });

    });


    // Update setiap 10 detik
    setInterval(ShowDashboard, 50000);
    
});