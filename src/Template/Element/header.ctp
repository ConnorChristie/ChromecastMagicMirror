<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=".">Magic Mirror</a>
        </div>

        <div class="navbar-collapse collapse">
            <?= $this->Navigation->menu($navigation['tabs']) ?>

            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-right">
                    <a href="/status"><strong>Status:</strong> <span id="chromecast_status" class="text-warning">Inactive</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>