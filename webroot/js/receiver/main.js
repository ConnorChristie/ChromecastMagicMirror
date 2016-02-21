"use strict";

jQuery.fn.updateWithText = function(text, speed)
{
    var deferred = $.Deferred();
    var dummy = $('<div/>').html(text);

    if ($(this).html() != dummy.html())
    {
        $(this).fadeOut(speed / 2, function()
        {
            $(this).html(text);
            $(this).fadeIn(speed / 2, deferred.resolve);
        });
    }

    return deferred.promise();
};

chromecast.initialize();
