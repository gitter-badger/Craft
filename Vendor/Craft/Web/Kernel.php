<?php
/**
 * This file is part of the Craft package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Craft\Web;

/**
 * Class Kernel
 * @package Craft\Web
 *
 * Basic handler : execute action and return data in response
 */
class Kernel implements Handler
{

    /**
     * Run on request
     * @param Request $request
     * @throws \BadMethodCallException
     * @return Response
     */
    public function handle(Request $request)
    {
        // not a valid callable
        if(!is_callable($request->action)) {
            throw new \BadMethodCallException('Request::action must be a valid callable.');
        }

        // run
        $data = call_user_func_array($request->action, $request->args);

        // create response
        $response = new Response();
        $response->request = $request;
        $response->data = $data;

        return $response;
    }

}

