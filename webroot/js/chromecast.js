var Chromecast = {
    namespace: 'urn:x-cast:me.connor.magicmirror',
    appId: '5FD69FDB'
};

Chromecast.main = function ()
{
    if (!chrome.cast || !chrome.cast.isAvailable)
    {
        setTimeout(Chromecast.initializeCastApi, 1000);
    }
};

Chromecast.initializeCastApi = function ()
{
    var sessionRequest = new chrome.cast.SessionRequest(Chromecast.appId);
    var apiConfig = new chrome.cast.ApiConfig(sessionRequest, Chromecast.sessionListener, Chromecast.receiverListener);

    chrome.cast.initialize(apiConfig, Chromecast.onInitSuccess, Chromecast.onError);
};

Chromecast.onInitSuccess = function ()
{

};

Chromecast.onError = function ()
{

};

Chromecast.sessionListener = function (e)
{
    Chromecast.session = e;

    Chromecast.session.addUpdateListener(Chromecast.sessionUpdateListener);
    Chromecast.session.addMessageListener(Chromecast.namespace, Chromecast.receiverMessage);
};

Chromecast.receiverListener = function ()
{

};

Chromecast.sessionUpdateListener = function (isAlive)
{
    if (!isAlive) Chromecast.session = null;

    Chromecast.updateStatusText(isAlive);
};

Chromecast.receiverMessage = function (namespace, message)
{

};

Chromecast.updateStatusText = function (isCasting)
{
    var $status = $('#chromecast_status');

    if (isCasting)
    {
        $status.removeClass('text-warning').addClass('text-success');
    } else
    {
        $status.removeClass('text-success').addClass('text-warning');
    }

    $status.text(isCasting ? 'Casting' : 'Inactive');
};
