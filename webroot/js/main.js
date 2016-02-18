$('.category-switch input[type="radio"]').change(function()
{
    var button = $(this).parent().parent().find('.btn');

    button.removeClass('btn-success');
    button.removeClass('btn-warning');

    if (this.value == 1)
    {
        button.addClass('btn-success');
    } else
    {
        button.addClass('btn-warning');
    }
});
