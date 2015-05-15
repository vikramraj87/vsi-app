var categories;
$(document).ready(function() {
    $('#add-slide').on('click', function(event) {
        event.preventDefault();
        var template = $('#virtual-slide-template').html();
        $('#slides').append(template);
    });

    $('#slides').on('click', 'a.remove-slide',  function(event) {
        event.preventDefault();
        $(this).parents('fieldset').first().remove();
    });
});