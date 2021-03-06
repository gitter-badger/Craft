<?php

/**
 * This file is part of the Craft package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Craft\View\Html\Form\Field;

use Craft\View\Html\Engine;
use Craft\View\Html\Form\Field;

class Text extends Field
{

    /**
     * Render input
     * @return string
     */
    public function input()
    {
        return Engine::make(dirname(__DIR__) . '/templates/text.input', ['field' => $this]);
    }

} 