//Fungsi Menampilkan Data Pelayanan
function FilterPelayanan() {
    // Tangkap Data Dari Form
    var FilterPelayanan = $('#FilterPelayanan').serialize();

    //Loading Row
    $('#TabelPelayananRadiologi').html('<tr><td class="text-center" colspan="11"><small>Loading...</small></td></tr>');

    //Tampilkan Data Dengan Ajax
    $.ajax({
        type    : 'POST',
        url     : '_Page/Radiologi/TabelPelayananRadiologi.php',
        data    : FilterPelayanan,
        success: function(data) {
            $('#TabelPelayananRadiologi').html(data);
        }
    });
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    //Ketika 'filter_pelayanan' di click
     $('#filter_pelayanan').click(function(){
        FilterPelayanan();
    });
});