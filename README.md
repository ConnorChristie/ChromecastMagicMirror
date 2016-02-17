# Chromecast Magic Mirror

[![Build Status](https://img.shields.io/travis/TheChillerCraft/ChromecastMagicMirror.svg?style=flat-square)](https://travis-ci.org/TheChillerCraft/ChromecastMagicMirror)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

This Magic Mirror settings interface uses [CakePHP](http://cakephp.org/) for the backend and simple PHP and HTML for the view that shows on the actual Magic Mirror.

This project is based off Michael's [Magic Mirror simple PHP and JS script](https://github.com/MichMich/MagicMirror).

## How to Contribute

1. Install [Composer](https://getcomposer.org/), you will need it to install all the dependencies.
2. Clone this repo `git clone https://github.com/TheChillerCraft/ChromecastMagicMirror.git ChromecastMagicMirror`
3. Download all the dependencies `composer install` in the `ChromecastMagicMirror` directory.

When creating extensions to the Chromecast Magic Mirror project, please put all your code in `plugins/PluginName`.
Then just push your `PluginName` folder to your git repo.

## Configuration

Read and edit `config/app.default.php`, you are going to have to rename this file to `config/app.php` and add your MySQL database credentials to it.

## Authors

Connor Christie
* https://github.com/TheChillerCraft

Idea from: Michael Teeuw
* https://github.com/MichMich
* http://michaelteeuw.nl/
