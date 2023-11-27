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

/** Name convert to Slug */
let name_inputs = document.querySelectorAll("[name^='name']");
let slug_input = document.querySelector("#slug");
let current_language = '';

name_inputs.forEach(function(name_input) {
    name_input.addEventListener("input", make_slug);
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
 * Show Uploaded Image
 */
document.addEventListener('DOMContentLoaded', function () {
    const upload_input = document.querySelector('#upload');
    upload_input.addEventListener('change', function () {
        readURL(upload_input);
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {

            $('#imageResult').attr('src', e.target.result);

            const info_image = document.getElementById("info");
            if (info_image) {
                info_image.style.display = "none";
            }

        };
        reader.readAsDataURL(input.files[0]);
    }
}

function open_input(input_id) {
    document.getElementById(input_id).click();
}

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

