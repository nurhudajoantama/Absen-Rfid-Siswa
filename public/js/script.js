function getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for ( var i = 0; i < length; i++ ) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    return result;
}

function warningHapusData(element, pesan, form){
    $(element).click(function(e) {
        e.preventDefault()
        Swal.fire({
            title: 'Apakan anda yakin?',
            text: pesan,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'YA, HAPUS',
            cancelButtonText: 'Batal',
            allowEnterKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Terhapus!',
                    'Data berhasil dihapus.',
                    'success'
                )
                setTimeout(function() {
                     $(form).submit()
                },1000)
            }
        })
    })
}

function warningUbahData(element, pesan, form, redirect){
    $(element).click(function(e) {
        e.preventDefault()
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: pesan,
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            denyButtonColor: '#ffcc00',
            denyButtonText: `Don't save`
        }).then((result) => {
            if (result.isConfirmed) {
                $(form).submit()
            } else if (result.isDenied) {
                Swal.fire(
                    'Perubahan tidak disimpan',
                    'Kembali ke index',
                    'info'
                )
                setTimeout(function() {
                    location.replace(redirect)
                }, 1000);
            }
        })
    })
}

function dateRange(element,dari,sampai){
    $(element).daterangepicker({
        opens: 'right',
        autoApply: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    },
    function(start, end, label) {
        $(dari).val(start.format('YYYY-MM-DD'))
        $(sampai).val(end.format('YYYY-MM-DD'))
    })
}

function loopAjaxRfid(valFail){
    setInterval(function() {
        if ($('#idAlat').val()) {
            $('#loadGetRfid').show()
            $('#successGetRfid').hide()
            $.ajax({
                url: urlRfidSiswa,
                method: 'get',
                data: {
                    'id-alat': $('#idAlat').val(),
                },
            }).done(function(data) {
                $('#rfid').val(data.data.rfid_baru)
                $('#time-rfid').html(data.data.time_rfid_baru)
                $('#loadGetRfid').hide()
                $('#successGetRfid').show()
            }).fail(function(data) {
                $('#rfid').val(valFail)
            })
        }
    }, 1000)
}


