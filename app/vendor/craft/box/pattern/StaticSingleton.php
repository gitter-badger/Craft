<?php

namespace craft\box\pattern;

use craft\box\error\NotImplementedException;

trait StaticSingleton
{

    /**
     * Get singleton instance
     * @throws NotImplementedException
     * @return mixed;
     */
    protected static function instance()
    {
        static $instance;
        if(!$instance) {

            // not implemented
            if(!method_exists(get_called_class(), 'createInstance')) {
                throw new NotImplementedException('You must implement createInstance() method.');
            }

            $instance = static::createInstance();
        }

        return $instance;
    }

} 