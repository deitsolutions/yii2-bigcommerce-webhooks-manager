<?php

namespace deitsolutions\yii2bigcommercewebhooksmanager;

/**
 * Main functionality module of the site
 */
class Module extends \yii\base\Module
{
    /**
     * @var array of stores settings
     */
    public $stores = [];
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}