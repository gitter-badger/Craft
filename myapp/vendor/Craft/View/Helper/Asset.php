<?php

namespace Craft\View\Helper;

use Craft\View\Helper;

class Asset implements Helper
{

    /** @var string */
    protected $base;


    /**
     * Setup base url
     * @param string $base
     */
    public function __construct($base = '/')
    {
        $this->base = rtrim($base, '/') . '/';
    }


    /**
     * Register helper functions
     * @return mixed
     */
    public function register()
    {
        return [
            'asset' => [$this, 'asset'],
            'css'   => [$this, 'css'],
            'js'    => [$this, 'js'],
        ];
    }


    /**
     * Get full file path
     * @param $filename
     * @return string
     */
    public function asset($filename)
    {
        return $this->base . ltrim($filename, '/');
    }


    /**
     * Css tag
     * @param $filename
     * @return string
     */
    public function css($filename)
    {
        $css = [];
        foreach(func_get_args() as $file) {
            $file = ltrim($file, '/') . '.css';
            $css[] = '<link type="text/css" href="' . $this->asset($file) . '" rel="stylesheet" />';
        }
        return implode("\n", $css);
    }


    /**
     * Js tag
     * @param $filename
     * @return string
     */
    public function js($filename)
    {
        $js = [];
        foreach(func_get_args() as $file) {
            $file = ltrim($file, '/') . '.js';
            $js[] = '<script type="text/javascript" src="' . $this->asset($file) . '"></script>';
        }
        return implode("\n", $js);
    }

}