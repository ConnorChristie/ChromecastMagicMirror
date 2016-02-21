"use strict";

class TimeExtension extends Extension
{
    static initVars()
    {
        TimeExtension.dateLocation = '.date';
        TimeExtension.timeLocation = '.time';

        TimeExtension.timeFormatSetting = 'time_format';

        TimeExtension.timeFormatValue = 12;

        TimeExtension.updateInterval = 1000;
        TimeExtension.fadeInterval = 1000;
    }

    constructor()
    {
        super('Time', 'settings', 'general');

        TimeExtension.initVars();
    }

    /**
     * Initializes the current time format and such from the config
     */
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

        this.intervalId = setInterval(this.update.bind(this), TimeExtension.updateInterval);
    }

    /**
     * Updates the current time on the mirror
     */
    update()
    {
        var _now = moment(),
            _date = _now.format('dddd, LL'),
            _time = _now.format(this._timeFormat + ':mm[<span class="sec">]ss' + this._includeA + '[</span>]');

        var $date = $(TimeExtension.dateLocation);
        var $time = $(TimeExtension.timeLocation);

        if (!this.initialized)
        {
            $date.updateWithText(_date, TimeExtension.fadeInterval);
            $time.updateWithText(_time, TimeExtension.fadeInterval);
        } else
        {
            $date.html(_date);
            $time.html(_time);
        }
    }

    /**
     * Clears the running interval and removes any text on the mirror
     */
    shutdown()
    {
        clearInterval(this.intervalId);

        this.initialized = false;

        return this.waitToComplete([
            $(TimeExtension.dateLocation).updateWithText('', TimeExtension.fadeInterval),
            $(TimeExtension.timeLocation).updateWithText('', TimeExtension.fadeInterval)
        ]);
    }
}

chromecast.addExtension(new TimeExtension());
