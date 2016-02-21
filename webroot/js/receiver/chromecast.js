"use strict";

class Chromecast {
    static initVars()
    {
        Chromecast.namespace = 'urn:x-cast:me.connor.magicmirror';
        Chromecast.configUrl = '/api/config';

        Chromecast.startingStatus = 'Magic Mirror is starting up';
        Chromecast.loadingConfig = 'Magic Mirror is loading the config';
        Chromecast.readyStatus = 'Magic Mirror is currently running';
    }

    constructor()
    {
        Chromecast.initVars();

        this.initialized = false;
        this.extensions = [];
    }

    /**
     * Initializes the chromecast
     */
    initialize()
    {
        cast.receiver.logger.setLevelValue(0);

        window.castReceiverManager = cast.receiver.CastReceiverManager.getInstance();
        window.messageBus = window.castReceiverManager.getCastMessageBus(Chromecast.namespace, cast.receiver.CastMessageBus.MessageType.JSON);

        this.onReady();

        messageBus.onMessage = this.onMessage.bind(this);
        castReceiverManager.onReady = this.onReady.bind(this);

        castReceiverManager.start({
            statusText: Chromecast.startingStatus
        });
    }

    /**
     * The Chromecast calls this when it is ready
     *
     * @param event The ready event
     */
    onReady(event)
    {
        this.loadConfig();
    }

    loadConfig()
    {
        if (this.initialized) return;

        window.castReceiverManager.setApplicationState(Chromecast.loadingConfig);

        $.getJSON(Chromecast.configUrl, function (config)
        {
            this.config = new Config(config);
            this.initialized = true;

            this.initializeExtensions();

            window.castReceiverManager.setApplicationState(Chromecast.readyStatus);
        }.bind(this));
    }

    /**
     * This checks if the extensions are enabled and initializes them if they are
     */
    initializeExtensions()
    {
        this.extensions.forEach(function (extension)
        {
            if (!extension.initialized && this.getConfig().isCategoryEnabled(extension.extension, extension.category))
            {
                try
                {
                    extension.initialize();
                } catch (error)
                {
                    console.error('The extension \'' + extension.name + '\' threw an error while initializing: ');
                    console.error(' -- ' + error);
                }
            }
        }.bind(this));
    }

    onMessage(event)
    {
        var data = event.data;

        if (data.reload)
        {
            this.shutdownExtensions(true);
        }
    }

    /**
     * Shutdowns all the extensions very nicely
     *
     * @param restart If the extensions should be restarted or not
     */
    shutdownExtensions(restart)
    {
        var shutdownTasks = [];

        this.extensions.forEach(function (extension)
        {
            shutdownTasks.push(extension.shutdown());
        });

        $.when.apply($, shutdownTasks).then(function ()
        {
            this.initialized = false;

            if (restart) this.loadConfig();
        }.bind(this));
    }

    /**
     * Adds an extension
     *
     * @param extension The extension
     */
    addExtension(extension)
    {
        this.extensions.push(extension);
    }

    /**
     * Gets the config
     *
     * @returns {Config} The config
     */
    getConfig()
    {
        return this.config;
    }
}

window.chromecast = new Chromecast();
