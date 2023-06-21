$(document).on('click', '.delete__link', function() {
    const author_id = $(this).data('id');
    const row = $(this).closest('tr');
    const rows = $('.table__body tr');

    $.ajax({
        type: 'DELETE',
        url: 'author/' + author_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            row.fadeOut('slow', function() {
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
                title: 'ავტორი წარმატებით წაიშალა'
            })

        },
        error: function(response) {
            $('#delete_message').html(response.responseJSON.error);
        }
    });
});

