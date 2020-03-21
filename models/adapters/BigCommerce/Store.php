<?php

namespace deitsolutions\yii2bigcommercewebhooksmanager\models\adapters\BigCommerce;

use Bigcommerce\Api\v3\Client as BigCommerce;
use Bigcommerce\Api\Client as BigCommerceV2;

/**
 * BigCommerce Store model
 * Class Store
 * @package almeyda\yii2sync\models\adapters\BigCommerce
 */
class Store extends \deitsolutions\yii2bigcommercewebhooksmanager\models\Store
{
    /**
     * @var array authentication data
     */
    public $auth;

    /**
     * @var array authentication data
     */
    public $webhooks;
    
    /**
     * @var array authentication data
     */
    public $apiSettings = [];

    /**
     * BigCommerce store initialization
     *
     * @return bool
     */
    public function init()
    {
        try {
            BigCommerce::configure($this->auth);
            BigCommerce::failOnError();

            BigCommerceV2::configure($this->auth);
            BigCommerceV2::failOnError();

            \Yii::info('Sync started', 'bigcommerceSync');
            $result = true;
        } catch (\Exception $ex) {
            \Yii::error('BigCommerce initialization error', 'bigcommerceSync');
            $result = false;
        }
        return $result;
    }
}
