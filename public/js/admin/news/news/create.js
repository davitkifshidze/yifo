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
const create__image = document.querySelector('.create__image')
const style = (node, styles) => Object.keys(styles).forEach((key) => (node.style[key] = styles[key]))

create__image.addEventListener('click', () => {
    const upload__container = document.querySelector('.upload__image__container')
    upload__container.classList.toggle('upload__container__extend')
    let upload__image__arrow = document.querySelector('.upload__image__arrow')
    upload__image__arrow.classList.toggle('upload__image__arrow__rotate')

    style(create__image, {
        borderRadius: '15px 15px 0 0 ',
    })


})

// Show Uploaded Image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const uploadInput = document.querySelector('#upload');
    uploadInput.addEventListener('change', function () {
        readURL(uploadInput);
    });
});

// Show Uploaded Image Name
const input = document.getElementById('upload');
const infoArea = document.getElementById('upload__label');

input.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
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
    if (window.getComputedStyle(tagInput).display !== 'none') {
        new Tagify(tagInput);
    }
});

// Date Time Picker
const datetimepicker = document.querySelector("#datetimepicker");
flatpickr(datetimepicker, {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    defaultDate: new Date(),
});


// ============================================================================ //

const lang_tabs = document.querySelectorAll('.lang__tab');
const active_lang_tab = document.querySelector('.lang__tab.active');
let active_lang = active_lang_tab.getAttribute('data-lang');


var inputs = document.querySelectorAll('input[data-lang]');
var textareas = document.querySelectorAll('textarea[data-lang]');

inputs.forEach(function(input) {
    if (input.dataset.lang !== active_lang) {
        input.style.display = 'none';
    }
});

textareas.forEach(function(textarea) {
    if (textarea.dataset.lang !== active_lang) {
        textarea.style.display = 'none';
    }
});


lang_tabs.forEach(lang_tab => {
    lang_tab.addEventListener('click', () => {

        const lang = lang_tab.getAttribute('data-lang');

        lang_tabs.forEach(tab => {
            tab.classList.remove('active');
        });

        lang_tab.classList.add('active');

        const active_lang = lang_tab.getAttribute('data-lang');

        const active_inputs = document.querySelectorAll(`input[data-lang="${active_lang}"]`);
        const active_textareas = document.querySelectorAll(`textarea[data-lang="${active_lang}"]`);
        console.log(active_inputs);
        console.log(active_textareas);


        active_inputs.forEach(function(input) {
            if (input.dataset.lang !== active_lang) {
                input.style.display = 'none';
            }
        });

        active_textareas.forEach(function(textarea) {
            if (textarea.dataset.lang !== active_lang) {
                textarea.style.display = 'none';
            }
        });


    });
});


