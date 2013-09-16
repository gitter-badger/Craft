<?php
/**
 * This file is part of the Craft package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 *
 * @author Aymeric Assier <aymeric.assier@gmail.com>
 * @date 2013-09-16
 * @version 0.1
 */
namespace craft;

class Build
{

    /** @var \Closure */
    public $action;

    /** @var array */
    public $metadata = [];

}