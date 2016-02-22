$('[data-tooltip="tooltip"]').tooltip();

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

Chromecast.main();

$('#settings_form').submit(function ()
{
    var data = $(this).serializeArray();
    data.push({name: 'save_config'});

    $.ajax({
        url: '/settings/update',
        type: 'POST',
        data: $.param(data),
        success: function ()
        {
            reloadFlash();
            scrollToTop();
        }
    });

    return false;
});

function reloadFlash()
{
    $('.flash').load('/flash');
}

function scrollToTop()
{
    $('html, body').animate({scrollTop : 0}, 200);
}
