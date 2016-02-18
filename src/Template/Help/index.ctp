<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Magic Mirror Setup') ?></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><?= __('1. Edit the config settings to your liking') ?></li>
                    <li class="list-group-item"><?= __('2. You can choose to have the receiver automatically update since the receiver is in the cloud and everyone shares the same version') ?></li>
                    <li class="list-group-item"><?= __('3. If you are already casting to your Chromecast then you can have the Chromecast auto refresh when you save your changes') ?></li>
                    <li class="list-group-item"><?= __('4. If you choose that then your Chromecast will automatically refresh and apply your changes') ?></li>
                    <li class="list-group-item"><?= __('5. Once you save your changes, they will be stored in config.json in case you wish to modify them manually') ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Chromecast Setup') ?></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><?= __('1. Plug your Chromecast into your monitor') ?></li>
                    <li class="list-group-item"><?= __('2. Connect your Chromecast to the internet') ?></li>
                    <li class="list-group-item"><?= __('3. Navigate to your local sender installation in a chrome browser') ?></li>
                    <li class="list-group-item"><?= __('4. Change any of the config settings to better suit you') ?></li>
                    <li class="list-group-item"><?= __('5. Save the changes and then cast the page') ?></li>
                    <li class="list-group-item"><?= __('6. You should see the Magic Mirror interface on your Chromecast') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Webserver Setup for a Local Receiver') ?></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><?= __('1. You should already have an Apache and PHP server set up') ?></li>
                    <li class="list-group-item"><?= __('2. Copy the receiver directory to the root of your www directory') ?></li>
                    <li class="list-group-item"><?= __('3. Change your host computer to use one of the following static IP\'s:') ?></li>
                    <li class="list-group-item indented">192.168.1.51</li>
                    <li class="list-group-item indented">10.5.5.51</li>
                    <li class="list-group-item indented">172.16.1.51</li>
                    <li class="list-group-item"><?= __('4. In the general settings, make sure you choose the correct IP you are using') ?></li>
                    <li class="list-group-item"><?= __('5. Make sure you refresh the settings tab before trying to cast to a new receiver') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Troubleshooting') ?></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong><?= __('My changes are not being applied') ?></strong></li>
                    <li class="list-group-item indented"><?= __('Make sure PHP has permission to write to the config.json file') ?></li>

                    <li class="list-group-item"><strong><?= __('It is not casting the application, only the tab') ?></strong></li>
                    <li class="list-group-item indented"><?= __('Make sure you have selected the proper receiver IP for your local network') ?></li>
                    <li class="list-group-item indented"><?= __('Make sure you have set up the receiver correctly on the chosen IP') ?></li>
                    <li class="list-group-item indented"><?= __('Make sure you can access the local IP chosen from another computer on your network') ?></li>
                    <li class="list-group-item indented"><?= __('Try restarting your Chromecast by unplugging and plugging it back in') ?></li>

                    <li class="list-group-item"><strong><?= __('Chrome is unable to cast to my device') ?></strong></li>
                    <li class="list-group-item indented"><?= __('Make sure your Chromecast is connected to the internet and not just your local network') ?></li>
                    <li class="list-group-item indented"><?= __('There might have been a bad receiver update, this will be fixed automatically') ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>