<?php

namespace Craft\View\Form;

use Craft\View\Engine;
use Craft\View\Template;

abstract class Field implements Element
{

    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $value;

    /** @var string */
    public $label;

    /** @var string */
    public $placeholder;

    /** @var string */
    public $helper;

    /** @var string */
    public $parent;

    /**
     * Set unique field id
     * & setup field data
     */
    public function __construct($name, $value = null, array $other = [])
    {
        $this->id = $name . '_' . uniqid();
        $this->name = $name;
        $this->value = $value;

        $other = $other + [
            'label'         => null,
            'helper'        => null,
            'placeholder'   => null,
            'parent'        => null
        ];

        $this->label = $other['label'];
        $this->helper = $other['helper'];
        $this->placeholder = $other['placeholder'];
    }


    /**
     * Get inner name
     * @return string
     */
    public function name()
    {
        return $this->parent ? $this->parent . '[' . $this->name . ']' : $this->name;
    }


    /**
     * Render label only
     * @return mixed
     */
    public function label()
    {
        return $this->render('field.label');
    }


    /**
     * Render input only
     * @return string
     */
    abstract public function input();


    /**
     * Render helper only
     * @return string
     */
    public function helper()
    {
        return $this->render('field.helper');
    }


    /**
     * Render label, input and helper
     * @return string
     */
    public function html()
    {
        return $this->render('field');
    }


    /**
     * Render template
     * @param $template
     * @return string
     */
    protected function render($template)
    {
        $engine = new Engine(__DIR__ . '/templates/', 'php');
        return Template::forge($engine, $template, ['field' => $this]);
    }

} 