// Select Multiple Create Author

//Set Dropdown with SearchBox via dropdownAdapter option
var Utils = $.fn.select2.amd.require('select2/utils');
var Dropdown = $.fn.select2.amd.require('select2/dropdown');
var DropdownSearch = $.fn.select2.amd.require('select2/dropdown/search');
var CloseOnSelect = $.fn.select2.amd.require('select2/dropdown/closeOnSelect');
var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

var dropdownAdapter = Utils.Decorate(Utils.Decorate(Utils.Decorate(Dropdown, DropdownSearch), CloseOnSelect), AttachBody);

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

// Select Multiple Create Category

$("#create__category__select").select2({
    dropdownAdapter: dropdownAdapter,
    minimumResultsForSearch: 0,
    placeholder: "აირჩიეთ ავტორი",
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


// Create Post image

// create__image.addEventListener('click', () => {
//     // const upload__container = document.querySelector('.upload__image__container')
//     const upload__container = document.querySelectorAll('[data-image-container]');
//
//     upload__container.classList.toggle('upload__container__extend')
//     let upload__image__arrow = document.querySelector('.upload__image__arrow')
//     upload__image__arrow.classList.toggle('upload__image__arrow__rotate')
//
//     style(create__image, {
//         borderRadius: '15px 15px 0 0 ',
//     })
// })

const news_images = document.querySelectorAll('[data-image-tab]');

const style = (node, styles) => {
    Object.keys(styles).forEach((key) => (node.style[key] = styles[key]));
};

news_images.forEach((news_image) => {
    news_image.addEventListener('click', () => {
        const appropriate_image_tab = news_image.getAttribute('data-image-tab');
        const appropriate_image_container = document.querySelector(`[data-image-container="${appropriate_image_tab}"]`);
        const arrow = news_image.querySelector('.upload__image__arrow');
        appropriate_image_container.classList.toggle('upload__container__extend');
        arrow.classList.toggle('upload__image__arrow__rotate');

        style(news_image, {
            borderRadius: '15px 15px 0 0',
        });
    });
});

// Show Uploaded Image
function readURL(input, imageResultId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var imageResult = document.getElementById(imageResultId);
            if (imageResult) {
                imageResult.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const uploadInputs = document.querySelectorAll('input[type="file"]');

    uploadInputs.forEach(function (uploadInput) {
        const imageResultId = uploadInput.getAttribute('data-image-result');
        uploadInput.addEventListener('change', function () {
            readURL(uploadInput, imageResultId);
        });
    });
});

// Show Uploaded Image Name
const inputs = document.querySelectorAll('input[type="file"]');

inputs.forEach(function (input) {
    input.addEventListener('change', showFileName);
});

function showFileName(event) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    var infoArea = input.closest('.upload__image__container').querySelector('.choose__img');
    infoArea.textContent = 'File name: ' + fileName;
}




// Generate Slug Function
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

// Title convert to Slug
let titleField = document.querySelector("#title");
let slugField = document.querySelector("#slug");

// titleField.addEventListener("keyup", function() {
//     let inputValue = titleField.value;
//     let slug = generateSlug(inputValue);
//     slugField.value = slug
// });

// Tag Input
const tagInputs = document.querySelectorAll('.tag__input');
tagInputs.forEach(tagInput => {
    new Tagify(tagInput);
});

// Date Time Picker
const datetimepicker = document.querySelector("#datetimepicker");
flatpickr(datetimepicker, {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    defaultDate: new Date(),
});

// Show Hide Tabs [ Meta ]
const tabs = document.querySelectorAll('[data-tab]');
const tab_contents = document.querySelectorAll('[data-tab-content]');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const selectedTab = tab.dataset.tab;

        tab_contents.forEach(content => {
            const contentTab = content.dataset.tabContent;
            if (contentTab !== selectedTab) {
                content.classList.remove('show__tab');
                content.classList.add('hide__tab');
            }
        });

        const selectedTabContent = document.querySelector(`[data-tab-content="${selectedTab}"]`);
        selectedTabContent.classList.remove('hide__tab');
        selectedTabContent.classList.add('show__tab');

        tabs.forEach(tab => {
            tab.classList.remove('active__tab');
        });
        tab.classList.add('active__tab');
    });
});

// Show Appropriate Container [ Lang Tab ]
const lang_tabs = document.querySelectorAll('.lang__tab');
const lang_containers = document.querySelectorAll('.translatable');
let activeLang = document.querySelector('.active__lang').getAttribute('data-lang');

// Show the initially active language container and its corresponding tab
let initial_container = document.querySelector(`[data-lang-container="${activeLang}"]`);
initial_container.classList.remove('hide');

lang_tabs.forEach(active_tab => {
    active_tab.addEventListener('click', () => {
        const selectedLang = active_tab.getAttribute('data-lang');

        lang_containers.forEach(container => {
            container.classList.remove('show');
            container.classList.add('hide');
        });

        const active_container = document.querySelector(`[data-lang-container="${selectedLang}"]`);
        active_container.classList.remove('hide');
        active_container.classList.add('show');

        lang_tabs.forEach(tab => {
            tab.classList.remove('active__lang');
        });
        active_tab.classList.add('active__lang');

        activeLang = selectedLang;

        const activeTab = active_container.querySelector('[data-tab]');
        activeTab.click();
    });
});
