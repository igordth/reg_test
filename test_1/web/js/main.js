
$(function () {
    $(document).on('click', '#signup-type_id input', function () {
        var type = $(this).val();
        if (type == 1) {
            $('.field-signup-company_name').show();
        }
        else {
            $('.field-signup-company_name').hide().val('');
        }
    });
});