"use strict";

class Extension
{
    constructor(name, extension, category)
    {
        this.name = name;

        this.extension = extension;
        this.category = category;
    }

    getSetting(settingName)
    {
        return chromecast.getConfig().tryGetSetting(this.extension, this.category, settingName);
    }

    waitToComplete(tasks)
    {
        var deferred = $.Deferred();

        $.when.apply($, tasks).then(function () {
            deferred.resolve();
        });

        return deferred.promise();
    }
}