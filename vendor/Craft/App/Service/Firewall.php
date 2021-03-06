<?php

/**
 * This file is part of the Craft package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Craft\App\Service;

use Craft\App;
use Craft\Debug\Logger;
use Craft\Box\Auth;

/**
 * Check if user is allowed to execute
 * the requested action when @auth is specified.
 *
 * Needs Service\RequestResolver
 */
class Firewall extends App\Service
{

    /**
     * Get listening methods
     * @return array
     */
    public function register()
    {
        return ['kernel.request' => 'onKernelRequest'];
    }


    /**
     * Handle request
     * @param App\Request $request
     * @throws App\Internal\Forbidden
     */
    public function onKernelRequest(App\Request $request)
    {
        // default value
        if(!isset($request->meta['auth'])) {
            $request->meta['auth'] = 0;
        }

        // attempt
        if(!Auth::rank($request->meta['auth'])) {
            throw new App\Internal\Forbidden('User not allowed for query "' . $request->query . '"');
        }

        Logger::info('User auth is allowed');
    }

}