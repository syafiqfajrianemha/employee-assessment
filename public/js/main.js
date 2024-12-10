// flash message
const flashData = $("#flash-data").data('flashdata');

if (flashData) {
    Swal.fire({
        icon: 'success',
        title: flashData,
        showConfirmButton: true,
    });
}

// button delete
$('.form-delete').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
        if (result.value) {
            return $(this).submit();
        }
    })
});

// button approved
$('.form-approved').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Setujui Program?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setujui'
    }).then((result) => {
        if (result.value) {
            return $(this).submit();
        }
    })
});

// button rejected
$('.form-rejected button[type="submit"]').on('click', function (e) {
    e.preventDefault();

    const form = $(this).closest('form');

    Swal.fire({
        title: 'Tolak Program?',
        icon: 'warning',
        input: "textarea",
        inputPlaceholder: "Masukkan alasan penolakan...",
        inputValidator: (value) => {
            if (!value) {
                return "Catatan penolakan wajib diisi!";
            }
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tolak'
    }).then((result) => {
        if (result.isConfirmed) {
            form.find('.rejected-note').val(result.value);
            form.submit();
        }
    })
});
