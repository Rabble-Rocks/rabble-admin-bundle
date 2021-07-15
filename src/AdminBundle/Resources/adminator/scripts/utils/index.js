import * as $ from 'jquery';

export default (function () {
    $(document).on('click', '[data-confirm]', function (e) {
        if (!confirm($(this).data('confirm'))) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
    $(document).on('click', 'a[data-reload-datatable]', function (e) {
        e.preventDefault();
        let datatable = $('.rabble-datatable-' + $(this).data('reload-datatable')).DataTable();
        $.ajax({
            'url': $(this).attr('href'),
            'success': function () {
                datatable.draw();
            }
        });
    });
});
