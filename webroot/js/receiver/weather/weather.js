var Weather = {
    temperatureLocation : '.temp',
    windSunLocation : '.windsun',
    forecastLocation : '.forecast',
    locationLocation : '.location',

    languageSetting: 'Magic Mirror Settings|Language',
    languageValue: 'en',

    zipCodeSetting: 'Weather Settings|Zip Code',
    unitsSetting: 'Weather Settings|Units',
    appIdSetting: 'Weather Settings|Open Weather Map API Key',

    params: {
        zip: 0, units: 'imperial', APPID: ''
    },

    apiBase: 'http://api.openweathermap.org/data',
    apiVersion : '2.5',
    weatherEndpoint: 'weather',
    forecastEndpoint: 'forecast/daily',

    updateInterval: 6000,
    fadeInterval: 1000,

    iconTable:
    {
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
    }
};

Weather.initialize = function ()
{
    this.languageValue = Chromecast.tryGetSetting(this.languageSetting) || this.languageValue;

    this.params.zip = Chromecast.tryGetSetting(this.zipCodeSetting) || this.params.zip;
    this.params.units = Chromecast.tryGetSetting(this.unitsSetting) || this.params.units;
    this.params.APPID = Chromecast.tryGetSetting(this.appIdSetting) || this.params.APPID;

    if (Time.timeFormatValue == 12)
    {
        this._timeFormat = 'h'
    } else
    {
        this._timeFormat = 'HH';
    }

    this.intervalId = setInterval(function ()
    {
        Weather.updateCurrentWeather();
        Weather.updateWeatherForecast();
    }, this.updateInterval);
};

Weather.updateCurrentWeather = function ()
{
    $.getJSON(this.apiBase + '/' + this.apiVersion + '/' + this.weatherEndpoint, this.params, function (data)
    {
        var _temperature = this.roundValue(data.main.temp),
            _wind = this.roundValue(data.wind.speed),
            _iconClass = this.iconTable[data.weather[0].icon];

        var _icon = '<span class="icon ' + _iconClass + ' dimmed wi"></span>';
        var _newTempHtml = _icon + '' + _temperature + '&deg;';

        $(this.temperatureLocation).updateWithText(_newTempHtml, this.fadeInterval);

        $(this.locationLocation).css('opacity', 0.38);
        $(this.locationLocation).updateWithText(data.name, this.fadeInterval);

        var _now = moment(),
            _sunrise = moment(data.sys.sunrise * 1000),
            _sunset = moment(data.sys.sunset * 1000);

        var _newWindHtml = '<span class="wi wi-strong-wind xdimmed"></span> ' + this.ms2Beaufort(_wind),
            _newSunHtml = '<span class="wi wi-sunrise xdimmed"></span> ' + _sunrise.format(this._timeFormat + ':mm [<span class="ampm">]a[</span>]');

        if (_sunrise < _now && _sunset > _now)
        {
            _newSunHtml = '<span class="wi wi-sunset xdimmed"></span> ' + _sunset.format(this._timeFormat + ':mm [<span class="ampm">]a[</span>]');
        }

        $(this.windSunLocation).updateWithText(_newWindHtml + ' ' + _newSunHtml, this.fadeInterval);
    }.bind(this));
};

Weather.updateWeatherForecast = function()
{
    $.getJSON(this.apiBase + '/' + this.apiVersion + '/' + this.forecastEndpoint, this.params, function (data)
    {
        var _opacity = 1, _forecastHtml = '';

        _forecastHtml += '<table class="forecast-table">';

        _forecastHtml += '<thead>';

        _forecastHtml += '<td class="day" style="color: white;">Day</td>';
        _forecastHtml += '<td class="icon-small"></td>';
        _forecastHtml += '<td class="temp-max">High</td>';
        _forecastHtml += '<td class="temp-min">Low</td>';

        _forecastHtml += '</thead>';

        for (var i = 0, count = data.list.length; i < count; i++)
        {
            var _forecast = data.list[i];

            _forecastHtml += '<tr style="opacity:' + _opacity + '">';

            var day = i == 0 ? 'Today' : moment(_forecast.dt, 'X').format('ddd');

            _forecastHtml += '<td class="day">' + day + '</td>';
            _forecastHtml += '<td class="icon-small ' + this.iconTable[_forecast.weather[0].icon] + '"></td>';
            _forecastHtml += '<td class="temp-max">' + this.roundValue(_forecast.temp.max) + '&deg;</td>';
            _forecastHtml += '<td class="temp-min">' + this.roundValue(_forecast.temp.min) + '&deg;</td>';

            _forecastHtml += '</tr>';

            _opacity -= 0.155;
        }

        _forecastHtml += '</table>';

        $(this.forecastLocation).updateWithText(_forecastHtml, this.fadeInterval);
    }.bind(this));
};

Weather.roundValue = function(temperature)
{
    return parseFloat(temperature).toFixed(0);
};

Weather.ms2Beaufort = function(ms)
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
};

Weather.shutdown = function ()
{
    clearInterval(this.intervalId);
};

Chromecast.addExtension(Weather);