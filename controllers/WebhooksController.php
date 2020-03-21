<?php
/**
 * @copyright Copyright (c) 2020 Almeyda LLC
 *
 * The full copyright and license information is stored in the LICENSE file distributed with this source code.
 */

namespace deitsolutions\yii2bigcommercewebhooksmanager\controllers;

use yii\base\InvalidConfigException;
use yii\console\Controller;
use deitsolutions\yii2bigcommercewebhooksmanager\models\Store;

/**
 * Controller for working with Bigcommerce store
 *
 * Class WebhooksController
 * @package deitsolutions\yii2bigcommercewebhooksmanager\controllers
 */
class WebhooksController extends Controller
{
    /**
     * @var string unique store id
     */
    public $storeId;

    /**
     * Gets command line options
     *
     * @param $actionID
     * @return array
     */
    public function options($actionID)
    {
        return ['storeId'];
    }

    /**
     * Creates hook
     */
    public function actionSync()
    {
        try {
            $store = Store::configure($this->module->stores, $this->storeId);
            $result = $store->sync();
        } catch (InvalidConfigException $exception) {
            \Yii::error('Configuration for hook failed', 'yii2bigcommercewebhooksmanager');
        }
    }

}
