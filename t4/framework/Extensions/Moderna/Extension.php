<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.11.15
 * Time: 9:57
 */

namespace T4\Extensions\Moderna;


class Extension
    extends \T4\Core\Extension
{
    public function init()
    {
        $assets = $this->app->assets;
        $assets->publish($this->assetsPath . '/lib');
        $assets->publishCssFile($this->assetsPath.'/lib/css/fancybox/jquery.fancybox.css');
        //$assets->publishCssFile($this->assetsPath.'/lib/css/jcarousel.css.');
        $assets->publishCssFile($this->assetsPath.'/lib/css/flexslider.css');
        $assets->publishCssFile($this->assetsPath.'/lib/css/style.css');
        $assets->publishCssFile($this->assetsPath.'/lib/skins/default.css');
        $assets->publishCssFile($this->assetsPath.'/lib/css/jcarousel/owl.carousel.css');
        $assets->publishCssFile($this->assetsPath.'/lib/css/jcarousel/owl.transitions.css');
        $assets->publishCssFile($this->assetsPath.'/lib/css/jcarousel/owl.theme.css');

        $assets->publishJsFile($this->assetsPath . '/lib/js/jquery.easing.1.3.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/jquery.fancybox.pack.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/jquery.fancybox-media.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/google-code-prettify/prettify.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/portfolio/jquery.quicksand.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/portfolio/setting.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/jquery.flexslider.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/animate.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/custom.js');
        $assets->publishJsFile($this->assetsPath . '/lib/js/jcarousel/owl.carousel.min.js');

        }
}