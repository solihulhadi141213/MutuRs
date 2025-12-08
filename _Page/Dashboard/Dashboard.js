// Fungsi Untuk Menampilkan Grafik
function ShowGrafik() {
    $.getJSON("_Page/Dashboard/Grafik.php", function (data) {
        const categories = data.map(item => item.x);
        const seriesData = data.map(item => parseFloat(item.y));

        var options = {
            chart: {
                type: 'area',
                height: 400
            },
            series: [{
                name: 'Permintaan',
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
                        return value + ' Permintaan';
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Grafik Permintaan Bulanan ' + new Date().getFullYear(),
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

// Fungsi untuk menampilkan tanggal
function tampilkanTanggal() {
    const waktu = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const tanggal = waktu.toLocaleDateString('id-ID', options);
    
    $('#tanggal_menarik').text(tanggal);
}

// Fungsi untuk menampilkan dashboard
function ShowDashboard() {
    $.ajax({
        type: 'POST',
        url: '_Page/Dashboard/CountDashboard.php',
        dataType: 'json',
        success: function(data) {
            $('#put_siswa').hide().html(data.siswa).fadeIn('slow');
            $('#put_kelas').hide().html(data.kelas).fadeIn('slow');
            $('#put_permintaan').hide().html(data.permintaan).fadeIn('slow');
            $('#put_permintaan_selesai').hide().html(data.selesai).fadeIn('slow');
        },
        error: function(xhr, status, error) {
            console.error("Gagal mengambil data dashboard:", error);
        }
    });
}


$(document).ready(function () {
    //Menampilkan Data Pertama Kali
    ShowGrafik();
    ShowDashboard();

    ShowDashboard();
    // Update setiap 10 detik
    setInterval(ShowDashboard, 10000);
    
    //Jam Menarik
    tampilkanTanggal(); // Tampilkan tanggal saat halaman dimuat
    tampilkanJam();     // Tampilkan jam pertama kali
    setInterval(tampilkanJam, 1000); // Perbarui jam setiap detik
});