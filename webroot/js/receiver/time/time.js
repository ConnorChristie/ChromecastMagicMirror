var Time = {
    dateLocation : '.date',
    timeLocation : '.time',

    timeFormatSetting: 'Magic Mirror Settings|Time Format',

    updateInterval : 1000,
    timeFormatValue: 12
};

Time.initialize = function ()
{
    this.timeFormatValue = Chromecast.tryGetSetting(this.timeFormatSetting) || this.timeFormatValue;

    if (this.timeFormatValue == 12)
    {
        this._timeFormat = 'h';
        this._includeA = ' a';
    } else
    {
        this._timeFormat = 'HH';
        this._includeA = '';
    }

    this.intervalId = setInterval(function()
    {
        Time.updateTime();
    }, 1000);
};

Time.updateTime = function()
{
    var _now = moment(),
        _date = _now.format('dddd, LL'),
        _time = _now.format(this._timeFormat + ':mm[<span class="sec">]ss' + this._includeA + '[</span>]');

    $(this.dateLocation).html(_date);
    $(this.timeLocation).html(_time);
};

Time.shutdown = function ()
{
    clearInterval(this.intervalId);
};

Chromecast.addExtension(Time);
