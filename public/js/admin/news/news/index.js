// Select Multiple Category
// More info https://demo.mobiscroll.com/select/multiple-select
mobiscroll.setOptions({
    locale: mobiscroll.localeEn,
    theme: 'ios',
    themeVariant: 'light'
});
mobiscroll.select('#post__category__select', {
    inputElement: document.getElementById('post__category__input')
});

// Date Picker
$(document).ready(function(){
    $(function() {
        $('input[name="date_range"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
});
