"use strict";

class Config
{
    constructor(configJson)
    {
        this.config = configJson;
    }

    /**
     * Gets the category for the specified extension and category name
     *
     * @param extensionName The name of the extension
     * @param categoryName The name of the category
     * @returns {*} The category object
     */
    getCategory(extensionName, categoryName)
    {
        var extension = this.config[extensionName];

        if (extension != undefined)
        {
            var category = extension['categories'][categoryName];

            if (category != undefined)
            {
                return category;
            }
        }

        return null;
    }

    /**
     * Tries to get the setting for the specified extension, category and setting name
     *
     * @param extensionName The name of the extension
     * @param categoryName The name of the category
     * @param settingName The name of the setting
     * @returns {*} The setting object
     */
    tryGetSetting(extensionName, categoryName, settingName)
    {
        var category = this.getCategory(extensionName, categoryName);

        if (category != null)
        {
            var setting = category['settings'][settingName];

            if (setting != undefined)
            {
                var defaultValue = setting['default_value'];
                var settingValue = setting['setting_value'];

                if (settingValue != null)
                {
                    return settingValue;
                } else if (defaultValue !== undefined)
                {
                    return defaultValue;
                }
            }
        }

        // Show the error on the screen?

        return null;
    }

    /**
     * Checks if the category is enabled
     *
     * @param extensionName The name of the extension
     * @param categoryName The name of the category
     * @returns {bool} If the category is enabled or not
     */
    isCategoryEnabled(extensionName, categoryName)
    {
        var category = this.getCategory(extensionName, categoryName);

        if (category != null)
        {
            return category.enabled || false;
        }

        return false;
    }
}
