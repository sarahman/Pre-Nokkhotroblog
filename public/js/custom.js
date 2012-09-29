/**
 * User: aabid048@gmail.com
 * Date: 2011-10-02
 * Time: 2:40 PM
 * File: Custom Javascript File
 */

$(function() {

    $('#cancel-button').live('click', function() {
        $('#close-form').trigger('click');
    });

    $('a.delete').live('click', function() {

        if (!confirm("Do you want to delete permanently from the system?")) {
            return false;
        }

        $.getJSON($(this).attr('href'), function(data) {

            if (data.status) {
                window.location = '';
            } else {
                alert('Something went wrong while deleting data.');
            }

        });

        return false;
    });

    $('div.alert-message').delay(2500).slideUp();

    $('div.alert-message a.close').live('click', function() {
        $(this).parent().slideUp(function() {$(this).remove();});return false;
    });



});