// Create / Edit Author Modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "flex";
}
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Both Modal
const edit__author = document.getElementById("edit__author");
const create__author = document.getElementById("create__author");

window.onclick = function(event) {
    if (event.target === edit__author) {
        edit__author.style.display = "none";
    }
    if (event.target === create__author) {
        create__author.style.display = "none";
    }
}

// Author Generate Slug Function
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

// Author name convert to Slug
let titleField = document.querySelector("#name");
let slugField = document.querySelector("#slug");

titleField.addEventListener("keyup", function() {
    let inputValue = titleField.value;
    let slug = generateSlug(inputValue);
    slugField.value = slug
});
