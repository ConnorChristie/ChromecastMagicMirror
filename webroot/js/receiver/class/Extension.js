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
        return chromecast.tryGetSetting(this.extension, this.category, settingName);
    }
}