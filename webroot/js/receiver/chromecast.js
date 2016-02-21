var chromecast = {
    readyStatus: 'Magic Mirror is currently running',
    namespace: 'urn:x-cast:me.connor.magicmirror',
    initialized: false,
    extensions: [],
    config: []
};

chromecast.initialize = function ()
{
    cast.receiver.logger.setLevelValue(0);
    window.castReceiverManager = cast.receiver.CastReceiverManager.getInstance();
    console.log('Starting Receiver Manager');

    window.messageBus = window.castReceiverManager.getCastMessageBus(chromecast.namespace, cast.receiver.CastMessageBus.MessageType.JSON);

    castReceiverManager.onReady = function (event)
    {

    };

    $.getJSON('/api/config', function (config)
    {
        chromecast.config = config;
        chromecast.initialized = true;

        console.log('Received Ready event: ' + JSON.stringify(event.data));
        window.castReceiverManager.setApplicationState(chromecast.readyStatus);

        chromecast.initializeExtensions();
    });

    castReceiverManager.start({
        statusText: 'Application is starting'
    });
};

chromecast.initializeExtensions = function ()
{
    chromecast.extensions.forEach(function (extension)
    {
        if (chromecast.isEnabled(extension.extension, extension.category))
        {
            try
            {
                extension.initialize();
            } catch (error)
            {
                console.error('The extension \'' + extension.name + '\' threw an error while trying to initialize: ');
                console.error(' -- ' + error);
            }
        }
    });
};

chromecast.addExtension = function (extension)
{
    chromecast.extensions.push(extension);
};

chromecast.isEnabled = function (extensionName, categoryName)
{
    var category = chromecast.getCategory(extensionName, categoryName);

    if (category != null)
    {
        return category.enabled || false;
    }

    return false;
};

chromecast.getCategory = function (extensionName, categoryName)
{
    var extension = chromecast.config[extensionName];

    if (extension != undefined)
    {
        var category = extension['categories'][categoryName];

        if (category != undefined)
        {
            return category;
        }
    }

    return null;
};

chromecast.tryGetSetting = function (extensionName, categoryName, settingName)
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
};
