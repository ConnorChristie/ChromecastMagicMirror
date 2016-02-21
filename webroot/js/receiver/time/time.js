"use strict";

class TimeExtension extends Extension
{
    static initVars()
    {
        TimeExtension.dateLocation = '.date';
        TimeExtension.timeLocation = '.time';

        TimeExtension.timeFormatSetting = 'time_format';

        TimeExtension.updateInterval = 1000;
        TimeExtension.timeFormatValue = 12;
    }

    constructor()
    {
        super('Time', 'settings', 'general');

        TimeExtension.initVars();
    }

    initialize()
    {
        TimeExtension.timeFormatValue = this.getSetting(TimeExtension.timeFormatSetting) || TimeExtension.timeFormatValue;

        if (TimeExtension.timeFormatValue == 12)
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
    }

    update()
    {
        var _now = moment(),
            _date = _now.format('dddd, LL'),
            _time = _now.format(this._timeFormat + ':mm[<span class="sec">]ss' + this._includeA + '[</span>]');

        var $date = $(TimeExtension.dateLocation);
        var $time = $(TimeExtension.timeLocation);

        if (!this.initialized)
        {
            $date.updateWithText(_date, 1000);
            $time.updateWithText(_time, 1000);
        } else
        {
            $date.html(_date);
            $time.html(_time);
        }
    }

    shutdown()
    {
        clearInterval(this.intervalId);
    }
}

chromecast.addExtension(new TimeExtension());
