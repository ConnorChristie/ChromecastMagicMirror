var time = {
    name: 'Time',
    categoryName: 'magic_mirror',

    dateLocation : '.date',
    timeLocation : '.time',

    timeFormatSetting: 'magic_mirror|time_format',

    updateInterval : 1000,
    timeFormatValue: 12,

    initialized: false
};

time.initialize = function ()
{
    this.timeFormatValue = chromecast.tryGetSetting(this.timeFormatSetting) || this.timeFormatValue;

    if (this.timeFormatValue == 12)
    {
        this._timeFormat = 'h';
        this._includeA = ' a';
    } else
    {
        this._timeFormat = 'HH';
        this._includeA = '';
    }

    this.update();
    this.initialized = true;

    this.intervalId = setInterval(this.update.bind(this), 1000);
};

time.update = function()
{
    var _now = moment(),
        _date = _now.format('dddd, LL'),
        _time = _now.format(this._timeFormat + ':mm[<span class="sec">]ss' + this._includeA + '[</span>]');

    var $date = $(this.dateLocation);
    var $time = $(this.timeLocation);

    if (!this.initialized)
    {
        $date.updateWithText(_date, 1000);
        $time.updateWithText(_time, 1000);
    } else
    {
        $date.html(_date);
        $time.html(_time);
    }
};

time.shutdown = function ()
{
    clearInterval(this.intervalId);
};

chromecast.addExtension(time);
