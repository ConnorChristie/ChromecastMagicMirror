var Chromecast = {
    readyStatus: 'Magic Mirror is currently running',
    namespace: 'urn:x-cast:me.connor.magicmirror',
    initialized: false,
    extensions: [],
    config: []
};

Chromecast.initialize = function ()
{
    cast.receiver.logger.setLevelValue(0);
    window.castReceiverManager = cast.receiver.CastReceiverManager.getInstance();
    console.log('Starting Receiver Manager');

    window.messageBus = window.castReceiverManager.getCastMessageBus(Chromecast.namespace, cast.receiver.CastMessageBus.MessageType.JSON);

    castReceiverManager.onReady = function (event)
    {

    };

    $.getJSON('/api/config', function (config)
    {
        Chromecast.config = config;
        Chromecast.initialized = true;

        //console.log('Received Ready event: ' + JSON.stringify(event.data));
        //window.castReceiverManager.setApplicationState(Chromecast.readyStatus);

        Chromecast.initializeExtensions();
    });

    castReceiverManager.start({
        statusText: 'Application is starting'
    });
};

Chromecast.initializeExtensions = function ()
{
    Chromecast.extensions.forEach(function (extension)
    {
        extension.initialize();
    });
};

Chromecast.addExtension = function (extension)
{
    Chromecast.extensions.push(extension);
};

Chromecast.tryGetSetting = function (categorySetting)
{
    var spl = categorySetting.split('|');

    if (spl.length == 0) return null;

    var categoryName = spl[0];
    var settingName = spl[1];

    var category = Chromecast.config[categoryName];

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
