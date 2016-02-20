var chromecast = {
    readyStatus: 'Magic Mirror is currently running',
    namespace: 'urn:x-cast:me.connor.magicmirror',
    initialized: false,
    extensions: [],
    config: []
};

chromecast.initialize = function ()
{
    /*
    cast.receiver.logger.setLevelValue(0);
    window.castReceiverManager = cast.receiver.CastReceiverManager.getInstance();
    console.log('Starting Receiver Manager');

    window.messageBus = window.castReceiverManager.getCastMessageBus(Chromecast.namespace, cast.receiver.CastMessageBus.MessageType.JSON);

    castReceiverManager.onReady = function (event)
    {

    };
*/
    $.getJSON('/api/config', function (config)
    {
        chromecast.config = config;
        chromecast.initialized = true;

        //console.log('Received Ready event: ' + JSON.stringify(event.data));
        //window.castReceiverManager.setApplicationState(Chromecast.readyStatus);

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
        if (chromecast.isEnabled(extension.categoryName))
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

chromecast.isEnabled = function (categoryName)
{
    var category = chromecast.config[categoryName];

    if (category !== undefined)
    {
        return category.enabled || false;
    }

    return false;
};

chromecast.tryGetSetting = function (categorySetting)
{
    var spl = categorySetting.split('|');

    if (spl.length == 0) return null;

    var categoryName = spl[0];
    var settingName = spl[1];

    var category = chromecast.config[categoryName];

    if (category !== undefined)
    {
        var setting = category['settings'][settingName];

        if (setting !== undefined)
        {
            var defaultValue = setting['default_value'];
            var settingValue = setting['setting_value'];

            if (settingValue !== null)
            {
                return settingValue['value'];
            } else if (defaultValue !== undefined)
            {
                return defaultValue;
            }
        }
    }

    // Show the error on the screen?

    return null;
};
