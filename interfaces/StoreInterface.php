<?php

namespace deitsolutions\yii2bigcommercewebhooksmanager\interfaces;

/**
 * Common methods for store
 *
 * @package deitsolutions\yii2bigcommercewebhooksmanager\interfaces;
 */
interface StoreInterface
{
    /**
     * Configures store according the application config
     *
     * @param array $storeConfig array of store configuration values
     * @param $storeId store id in config
     * @return bool
     */
    public static function configure($storeConfigs, $storeId);

}
