<?php
/**
 * @copyright Copyright (c) 2020 Almeyda LLC
 *
 * The full copyright and license information is stored in the LICENSE file distributed with this source code.
 */

namespace deitsolutions\yii2bigcommercewebhooksmanager\models;

use yii;
use yii\base\Model;
use yii\base\InvalidConfigException;
use Bigcommerce\Api\Client as Bigcommerce;
use deitsolutions\yii2bigcommercewebhooksmanager\interfaces\StoreInterface;

/**
 * Store model
 * Class Store
 * @package almeyda\yii2bigcommercewebhooksmanager\models
 */
class Store extends Model implements StoreInterface
{
    /**
     * local config id for store
     * @var
     */
    public $storeId;

    /**
     * @var array Store adapter configuration
     */
    public static $adapterType = 'BigCommerce';

    /**
     * Method configures store adapter according the config passed
     * @param $storeConfigs
     * @param \almeyda\yii2bigcommercewebhooksmanager\interfaces\store $storeId
     * @return bool|object
     * @throws InvalidConfigException
     */
    public static function configure($storeConfigs, $storeId)
    {
        $storeConfig = $storeConfigs[$storeId];
        if (is_array($storeConfig)) {
            if (isset($storeConfig['adapter'])) {
                $storeAdapter = $storeConfig['adapter'];
                if (isset($storeAdapter['type'])) {
                    self::$adapterType = $storeAdapter['type'];
                    unset($storeAdapter['type']);
                }
            } else {
                throw new InvalidConfigException('Store adapter configuration not defined');
            }
        } else {
            throw new InvalidConfigException('Store configuration should be an array');
        }

        $storeAdapter['class'] = __NAMESPACE__ . '\adapters\\' . self::$adapterType . '\Store';
        try {
            $store = \Yii::createObject($storeAdapter);
            if ($store) {
                unset($storeConfig['adapter']);
                \Yii::configure($store, $storeConfig);
                $store->storeId = $storeId;
            }
        } catch (\Exception $exception) {
            \Yii::error($exception->getMessage(), 'yii2bigcommercewebhooksmanager');
            $store = false;
        }
        return $store;
    }

    /**
     * BigCommerce webhooks sync handler
     * @return mixed
     */
    public function sync()
    {
        $hooks = Bigcommerce::listWebhooks();

        $allFields = function () {
            if (isset($this->fields->fields)) {
                $resource = $this->fields->fields;
            } else {
                $resource = is_object($this->fields) ? clone $this->fields : $this->fields;
            }
            return $resource;
        };

        foreach ($this->webhooks as $webhook) {
            $hookExists = false;
            foreach ($hooks as $hook) {
                $getAllFields = $allFields->bindTo($hook, $hook);
                $bcObjectArray = $getAllFields();
                if ($webhook['scope'] == $bcObjectArray->scope) {
                    $hookExists = true;
                    break;
                }
            }

            if (!$hookExists) {
                $result = Bigcommerce::createWebhook($webhook);
            }
        }
    }

    /**
     * BigCommerce webhooks requests handler
     * @param $method
     * @param $params
     * @return mixed
     */
    public function hook($method, $params)
    {
        if ($params && is_string($params)) {
            $params = json_decode($params);
        }
        switch ($method) {
            case 'get':
                $result = Bigcommerce::getWebhook($params->id);
                break;
            case 'create':
                $result = Bigcommerce::createWebhook($params);
                break;
            case 'update':
                $result = Bigcommerce::updateWebhook($params->id, $params);
                break;
            case 'delete':
                $result = Bigcommerce::deleteWebhook($params->id);
                break;
            default:
                $result = Bigcommerce::listWebhooks();
        }
        return $result;
    }
}
