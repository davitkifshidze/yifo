/** Generate Slug */
function generateSlug(input_value) {
    let transliterated_value = input_value.replace(/[\u10D0-\u10FA]/g, function (match) {
        let transliteration_data = {
            'ა': 'a', 'ბ': 'b', 'გ': 'g', 'დ': 'd', 'ე': 'e', 'ვ': 'v', 'ზ': 'z', 'თ': 't', 'ი': 'i', 'კ': 'k', 'ლ': 'l', 'მ': 'm', 'ნ': 'n', 'ო': 'o', 'პ': 'p', 'ჟ': 'zh', 'რ': 'r', 'ს': 's', 'ტ': 't', 'უ': 'u', 'ფ': 'f', 'ქ': 'q', 'ღ': 'gh', 'ყ': 'y', 'შ': 'sh', 'ჩ': 'ch', 'ც': 'ts', 'ძ': 'dz', 'წ': 'ts', 'ჭ': 'ch', 'ხ': 'kh', 'ჯ': 'j', 'ჰ': 'h'
        };
        return transliteration_data[match];
    });
    let normalized_value = transliterated_value.normalize('NFC');
    let slug = normalized_value.replace(/[,.!?'"]/g, '').replace(/[\s]/g, '-');
    slug = slug.replace(/[^a-zA-Z0-9-_]/g, '');

    return slug.toLowerCase();
}

/** Make Slug */
function make_slug(event) {
    const input_value = event.target.value.trim();
    const language_code = event.target.getAttribute('data-lang');

    if (language_code === 'en') {
        current_language = language_code;
        slug_input.value = generateSlug(input_value);
    } else if (language_code !== 'en' && current_language !== 'en' && input_value !== '') {
        slug_input.value = generateSlug(input_value);
    }
}

/** Title convert to Slug */
let title_inputs = document.querySelectorAll("[name^='title']");
let slug_input = document.querySelector("#slug");
let current_language = '';

title_inputs.forEach(function(title_input) {
    title_input.addEventListener("input", make_slug);
});

/** Slug Edit */
const slug_edit = document.querySelector('.slug__edit');
slug_edit.addEventListener('click', function() {
    slug_input.removeAttribute('readonly');
    slug_input.style.cursor = 'text';
    slug_input.style.background = 'none';
});
slug_input.addEventListener("input", make_slug);

/**
 * Select Multiple Create Author
 * Set Dropdown with SearchBox via dropdownAdapter option
 */
const Utils = $.fn.select2.amd.require('select2/utils');
const Dropdown = $.fn.select2.amd.require('select2/dropdown');
const DropdownSearch = $.fn.select2.amd.require('select2/dropdown/search');
const CloseOnSelect = $.fn.select2.amd.require('select2/dropdown/closeOnSelect');
const AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

const dropdownAdapter = Utils.Decorate(Utils.Decorate(Utils.Decorate(Dropdown, DropdownSearch), CloseOnSelect), AttachBody);

$("#create__author__select").select2({
    dropdownAdapter: dropdownAdapter,
    minimumResultsForSearch: 0,
    placeholder: "აირჩიეთ ავტორი",
    allowClear: true,
    "language": {
        "noResults": function(){
            return "მსგავსი ავტორი არ მოიძებნა";
        }
    },
}).on('select2:opening select2:closing', function (event) {
    const searchfield = $(this).parent().find('.select2-search__field');
    searchfield.prop('disabled', true);
});

/**
 * Select Multiple Create Category
 */
$("#create__category__select").select2({
    dropdownAdapter: dropdownAdapter,
    minimumResultsForSearch: 0,
    placeholder: "აირჩიეთ კატეგორია",
    allowClear: true,
    "language": {
        "noResults": function(){
            return "მსგავსი კატეგორია არ მოიძებნა";
        }
    },
}).on('select2:opening select2:closing', function (event) {
    const searchfield = $(this).parent().find('.select2-search__field');
    searchfield.prop('disabled', true);
});

/**
 * Show Uploaded Image
 */
document.addEventListener('DOMContentLoaded', function () {
    const image_inputs = document.querySelectorAll('input[data-image-input]');
    image_inputs.forEach(function (image_input) {
        image_input.addEventListener('change', function () {
            const output_image_id = "output_image_" + image_input.getAttribute("data-locale");
            readURL(image_input, output_image_id);
        });
    });
});

function readURL(input_image, output_image_id) {
    if (input_image.files && input_image.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const output_image = document.getElementById(output_image_id);
            if (output_image) {
                output_image.src = e.target.result;

                const info_paragraph = document.getElementById("info_" + input_image.getAttribute("data-locale"));
                if (info_paragraph) {
                    info_paragraph.style.display = "none";
                }

            }
        };
        reader.readAsDataURL(input_image.files[0]);
    }
}

function open_input(input_id) {
    document.getElementById(input_id).click();
}

/**
 * Tag Input
 */
const tagInputs = document.querySelectorAll('.tag__input');
tagInputs.forEach(tag_input => {
    new Tagify(tag_input);
});

/**
 * Date Time Picker
 */
const datetimepicker = document.querySelector("#datetimepicker");
flatpickr(datetimepicker, {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    defaultDate: new Date(),
});

/**
 * Show Hide Tabs [ Meta ]
 */
const tabs = document.querySelectorAll('[data-tab]');
const tab_contents = document.querySelectorAll('[data-tab-content]');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const selected_tab = tab.dataset.tab;

        tab_contents.forEach(content => {
            const content_tab = content.dataset.tab_content;
            if (content_tab !== selected_tab) {
                content.classList.remove('show__tab');
                content.classList.add('hide__tab');
            }
        });

        const selected_tab_content = document.querySelector(`[data-tab-content="${selected_tab}"]`);
        selected_tab_content.classList.remove('hide__tab');
        selected_tab_content.classList.add('show__tab');

        tabs.forEach(tab => {
            tab.classList.remove('active__tab');
        });
        tab.classList.add('active__tab');
    });
});

/**
 * Show Appropriate Container [ Lang Tab ]
 */
const lang_tabs = document.querySelectorAll('.lang__tab');
const lang_containers = document.querySelectorAll('.translatable');
let active_lang = document.querySelector('.active__lang').getAttribute('data-lang');

/** Show the initially active language container and its corresponding tab */
let initial_container = document.querySelector(`[data-lang-container="${active_lang}"]`);
initial_container.classList.remove('hide');

lang_tabs.forEach(active_tab => {
    active_tab.addEventListener('click', () => {
        const selected_lang = active_tab.getAttribute('data-lang');

        lang_containers.forEach(container => {
            container.classList.remove('show');
            container.classList.add('hide');
        });

        const active_container = document.querySelector(`[data-lang-container="${selected_lang}"]`);
        active_container.classList.remove('hide');
        active_container.classList.add('show');

        lang_tabs.forEach(tab => {
            tab.classList.remove('active__lang');
        });
        active_tab.classList.add('active__lang');

        active_lang = selected_lang;

        const activeTab = active_container.querySelector('[data-tab]');
        activeTab.click();
    });
});
