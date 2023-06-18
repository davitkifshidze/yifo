// Modal Close
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
}

const modal = document.getElementById("modal");
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// Clear Modal Input
function clearModal(){
    const form = modal.querySelector('form');
    const formInputs = form.querySelectorAll('input:not(.modal__btn):not([name="_token"]), textarea');
    formInputs.forEach(input => input.value = '');
}

// Category Generate Slug Function
function generateSlug(inputValue) {
    let transliteratedValue = inputValue.replace(/[\u10D0-\u10FA]/g, function(match) {
        let transliterationTable = {
            'ა': 'a', 'ბ': 'b', 'გ': 'g', 'დ': 'd', 'ე': 'e', 'ვ': 'v', 'ზ': 'z', 'თ': 't', 'ი': 'i', 'კ': 'k', 'ლ': 'l', 'მ': 'm', 'ნ': 'n', 'ო': 'o', 'პ': 'p', 'ჟ': 'zh', 'რ': 'r', 'ს': 's', 'ტ': 't', 'უ': 'u', 'ფ': 'f', 'ქ': 'q', 'ღ': 'gh', 'ყ': 'y', 'შ': 'sh', 'ჩ': 'ch', 'ც': 'ts', 'ძ': 'dz', 'წ': 'ts', 'ჭ': 'ch', 'ხ': 'kh', 'ჯ': 'j', 'ჰ': 'h'
        };
        return transliterationTable[match];
    });
    let normalizedValue = transliteratedValue.normalize('NFC');
    let slug = normalizedValue.replace(/[,.!?'"]/g, '').replace(/[\s]/g, '-');
    slug = slug.replace(/[^a-zA-Z0-9-_]/g, '');

    return slug.toLowerCase();
}

// Category name convert to Slug
const name_en = document.getElementById('name_en');
const name_ka = document.getElementById('name_ka');
let titleField = name_ka;
let initialValue = name_ka.value;

if (name_en.value.trim() !== '') {
    titleField = name_en;
    initialValue = name_en.value;
}

let slugField = document.querySelector("#slug");
slugField.value = generateSlug(initialValue);

name_en.addEventListener("input", function() {
    if (name_en.value.trim() === '') {
        slugField.value = generateSlug(name_ka.value);
    } else {
        slugField.value = generateSlug(name_en.value);
        titleField = name_en;
        initialValue = name_en.value;
    }
});

name_ka.addEventListener("input", function() {
    if (titleField === name_ka && name_en.value.trim() === '') {
        slugField.value = generateSlug(name_ka.value);
        initialValue = name_ka.value;
    }
});


// Modal Lang Switcher
const defaultTab = document.querySelector('.lang__tab.active');
const lang = defaultTab.getAttribute('data-lang-selector');

const inputs = document.querySelectorAll('[data-lang]');
inputs.forEach(input => {
    if (input.getAttribute('data-lang') !== lang) {
        input.style.display = 'none';
    }
});


// Show Appropriate Input [lang]
const langTabs = document.querySelectorAll('.lang__tab');
langTabs.forEach(tab => {
    tab.addEventListener('click', () => {

        const activeTab = document.querySelector('.lang__tab.active');

        if (activeTab) {
            activeTab.classList.remove('active');
        }
        tab.classList.add('active');

        const lang = tab.getAttribute('data-lang-selector');
        inputs.forEach(input => {
            if (input.getAttribute('data-lang') === lang) {
                input.style.display = 'block';
            } else {
                input.style.display = 'none';
            }
        });

    });
});

// Create Category Ajax Request
function createCategory() {
    $('#category_create_form').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'კატეგორია წარმატებით დაემატა'
                    }).then(function() {
                        closeModal('modal');
                        $('#category_create_form input:not([type="submit"], textarea)').not('[name="_token"]').val('');
                    });
                }
            },
            error: function(response) {
                $('.input__error').remove();
                $.each(response.responseJSON.errors, function(field, errors) {
                    const input = $('[name="' + field + '"]');
                    $.each(errors, function(index, error) {
                        input.after('<div class="input__error">' + error + '</div>');
                    });
                });
            }
        });
    });
}


// Edit Category Ajax Request
function editCategory(category_id) {
    $('#category_edit_form').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'კატეგორია წარმატებით განახლდა'
                    }).then(function() {
                        closeModal('modal');
                    });
                }
            },
            error: function(response) {
                $('.input__error').remove();
                $.each(response.responseJSON.errors, function(field, errors) {
                    const input = $('[name="' + field + '"]');
                    $.each(errors, function(index, error) {
                        input.after('<div class="input__error">' + error + '</div>');
                    });
                });
            }
        });
    });
}
