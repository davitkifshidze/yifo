$(document).on('click', '.delete__link', function () {
    const category_id = $(this).data('id');
    const row = $(this).closest('tr');
    const rows = $('.table__body tr');

    // Use SweetAlert for confirmation
    Swal.fire({
        title: delete_category,
        text: confirm_category_delete,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--green-btn)',
        cancelButtonColor: 'var(--delete)',
        confirmButtonText: 'დიახ',
        cancelButtonText: 'არა'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: 'DELETE',
                url: 'category/' + category_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    row.fadeOut('slow', function () {
                        $(this).remove();
                        rows.removeClass('blur');
                    });

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'კატეგორია წარმატებით წაიშალა'
                    });

                    setTimeout(function (){
                        location.reload()
                    }, 1000);

                },
                error: function (response) {
                    $('#delete_message').html(response.responseJSON.error);
                }
            });
        }
    });
});

