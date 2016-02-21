"use strict";

class WeatherExtension extends Extension
{
    static initVars()
    {
        WeatherExtension.temperatureLocation = '.temp';
        WeatherExtension.windSunLocation = '.windsun';
        WeatherExtension.forecastLocation = '.forecast';
        WeatherExtension.locationLocation = '.location';

        WeatherExtension.zipCodeSetting = 'zip_code';
        WeatherExtension.unitsSetting = 'units';
        WeatherExtension.appIdSetting = 'api_key';

        WeatherExtension.params = {
            zip: 0, units: 'imperial', APPID: '', lang: 'en'
        };

        WeatherExtension.apiBase = 'http://api.openweathermap.org/data';
        WeatherExtension.apiVersion = '2.5';
        WeatherExtension.weatherEndpoint = 'weather';
        WeatherExtension.forecastEndpoint = 'forecast/daily';

        WeatherExtension.updateInterval = 30000;
        WeatherExtension.fadeInterval = 1000;

        WeatherExtension.iconTable = {
            '01d': 'wi-day-sunny',
            '02d': 'wi-day-cloudy',
            '03d': 'wi-cloudy',
            '04d': 'wi-cloudy-windy',
            '09d': 'wi-showers',
            '10d': 'wi-rain',
            '11d': 'wi-thunderstorm',
            '13d': 'wi-snow',
            '50d': 'wi-fog',
            '01n': 'wi-night-clear',
            '02n': 'wi-night-cloudy',
            '03n': 'wi-night-cloudy',
            '04n': 'wi-night-cloudy',
            '09n': 'wi-night-showers',
            '10n': 'wi-night-rain',
            '11n': 'wi-night-thunderstorm',
            '13n': 'wi-night-snow',
            '50n': 'wi-night-alt-cloudy-windy'
        };
    }

    constructor()
    {
        super('Weather', 'settings', 'weather');

        WeatherExtension.initVars();
    }

    /**
     * Initializes the current parameters and such from the config
     */
    initialize()
    {
        this.params = {};

        this.params.zip = this.getSetting(WeatherExtension.zipCodeSetting) || WeatherExtension.params.zip;
        this.params.units = this.getSetting(WeatherExtension.unitsSetting) || WeatherExtension.params.units;
        this.params.APPID = this.getSetting(WeatherExtension.appIdSetting) || WeatherExtension.params.APPID;
        this.params.lang = chromecast.getConfig().tryGetSetting('settings', 'general', 'language') || WeatherExtension.params.lang;

        var timeFormatValue = chromecast.getConfig().tryGetSetting('settings', 'general', 'time_format') || 12;

        if (timeFormatValue == 12)
        {
            this._timeFormat = 'h'
        } else
        {
            this._timeFormat = 'HH';
        }

        this.update();

        this.intervalId = setInterval(this.update.bind(this), WeatherExtension.updateInterval);
    }

    /**
     * Updates the current weather and forecast on the mirror
     */
    update()
    {
        this.updateCurrentWeather();

        // They don't like getting two API calls at nearly the same time
        setTimeout(this.updateWeatherForecast.bind(this), 500);
    }

    /**
     * Updates the current weather on the mirror
     */
    updateCurrentWeather()
    {
        var url = WeatherExtension.apiBase + '/' + WeatherExtension.apiVersion + '/' + WeatherExtension.weatherEndpoint;

        $.getJSON(url, this.params, function (data)
        {
            var _temperature = this.roundValue(data.main.temp),
                _wind = this.roundValue(data.wind.speed),
                _iconClass = WeatherExtension.iconTable[data.weather[0].icon];

            var _icon = '<span class="icon ' + _iconClass + ' dimmed wi"></span>';
            var _newTempHtml = _icon + '' + _temperature + '&deg;';

            $(WeatherExtension.temperatureLocation)
                .updateWithText(_newTempHtml, WeatherExtension.fadeInterval);

            $(WeatherExtension.locationLocation)
                .css('opacity', 0.38)
                .updateWithText(data.name, WeatherExtension.fadeInterval);

            var _now = moment(),
                _sunrise = moment(data.sys.sunrise * 1000),
                _sunset = moment(data.sys.sunset * 1000);

            var _newWindHtml = '<span class="wi wi-strong-wind xdimmed"></span> ' + this.ms2Beaufort(_wind),
                _newSunHtml = '<span class="wi wi-sunrise xdimmed"></span> ' + _sunrise.format(this._timeFormat + ':mm [<span class="ampm">]a[</span>]');

            if (_sunrise < _now && _sunset > _now)
            {
                _newSunHtml = '<span class="wi wi-sunset xdimmed"></span> ' + _sunset.format(this._timeFormat + ':mm [<span class="ampm">]a[</span>]');
            }

            $(WeatherExtension.windSunLocation)
                .updateWithText(_newWindHtml + ' ' + _newSunHtml, WeatherExtension.fadeInterval);
        }.bind(this));
    }

    /**
     * Updates the current weather forecast on the mirror
     */
    updateWeatherForecast()
    {
        var url = WeatherExtension.apiBase + '/' + WeatherExtension.apiVersion + '/' + WeatherExtension.forecastEndpoint;

        $.getJSON(url, this.params, function (data)
        {
            var _opacity = 1, _forecastHtml = '';

            _forecastHtml += '<table class="forecast-table">';

            _forecastHtml += '<thead>';

            _forecastHtml += '<td class="day" style="color: white;">Day</td>';
            _forecastHtml += '<td class="icon-small"></td>';
            _forecastHtml += '<td class="temp-max">High</td>';
            _forecastHtml += '<td class="temp-min">Low</td>';

            _forecastHtml += '</thead>';

            for (var i = 0; i < data.list.length; i++)
            {
                var _forecast = data.list[i];

                _forecastHtml += '<tr style="opacity:' + _opacity + '">';

                var day = i == 0 ? 'Today' : moment(_forecast.dt, 'X').format('ddd');

                _forecastHtml += '<td class="day">' + day + '</td>';
                _forecastHtml += '<td class="icon-small ' + WeatherExtension.iconTable[_forecast.weather[0].icon] + '"></td>';
                _forecastHtml += '<td class="temp-max">' + this.roundValue(_forecast.temp.max) + '&deg;</td>';
                _forecastHtml += '<td class="temp-min">' + this.roundValue(_forecast.temp.min) + '&deg;</td>';

                _forecastHtml += '</tr>';

                _opacity -= 0.155;
            }

            _forecastHtml += '</table>';

            $(WeatherExtension.forecastLocation)
                .updateWithText(_forecastHtml, WeatherExtension.fadeInterval);
        }.bind(this));
    }

    /**
     * Clears the current running interval
     */
    shutdown()
    {
        clearInterval(this.intervalId);

        this.initialized = false;

        return this.waitToComplete([
            $(WeatherExtension.temperatureLocation).updateWithText('', WeatherExtension.fadeInterval),
            $(WeatherExtension.windSunLocation).updateWithText('', WeatherExtension.fadeInterval),
            $(WeatherExtension.forecastLocation).updateWithText('', WeatherExtension.fadeInterval),
            $(WeatherExtension.locationLocation).updateWithText('', WeatherExtension.fadeInterval)
        ]);
    }

    /**
     * Rounds the temperature value to have no decimals
     *
     * @param temperature The temperature as a string
     * @returns {string} The rounded temperature value
     */
    roundValue(temperature)
    {
        return parseFloat(temperature).toFixed(0);
    }

    /**
     * Converts an unknown unit into beaufort units
     *
     * @param ms Unknown
     * @returns {int} The beaufort value
     */
    ms2Beaufort(ms)
    {
        var kmh = ms * 60 * 60 / 1000;
        var speeds = [ 1, 5, 11, 19, 28, 38, 49, 61, 74, 88, 102, 117, 1000 ];

        for (var beaufort in speeds)
        {
            var speed = speeds[beaufort];

            if (speed > kmh)
            {
                return beaufort;
            }
        }

        return 12;
    }
}

chromecast.addExtension(new WeatherExtension());
