var categories;
$(document).ready(function() {
    $('#add-slide').on('click', function(event) {
        event.preventDefault();
        var template = $('#virtual-slide-template').html();
        $('#slides').append(template);
        event.preventDefault();
    });
    $('#slides').on('click', 'a.remove-slide',  function(event) {
        $(this).parents('fieldset').first().remove();
        event.preventDefault();
    });

    $('#categories-table').on('click', '.category-remove', function(event) {
        //event.preventDefault();
        var id = $(this).data('id');
        // Display a modal diaglog confirmation
    });

    //$.getJSON('/categories', function(json) {
    //    categories = json;
    //
    //    // Create a select element with the parent categories
    //    var sel = $('<select>')
    //        .appendTo('#categories');
    //    sel.append($('<option>').attr('value', 0));
    //    $.each(categories[0], function() {
    //        var option = $('<option>')
    //            .attr('value', this.id)
    //            .text(this.category);
    //        sel.append(option);
    //    });
    //
    //
    //
    //});
    //
    //$('#categories').on('change', 'select', function(event) {
    //    alert($(this).attr('value'));
    //});
});