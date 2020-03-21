Search functionality
=================

This extension manages Bigcommerce webhooks

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require deitsolutions/yii2-bigcommerce-webhooks-manager "*"
```

or add

```
"deitsolutions/yii2-bigcommerce-webhooks-manager": "*"
```

to the required section of your `composer.json` file.

## Configuration

Once the extension is installed, modify your application configuration to include:

```php
return [
	'modules' => [
	    ...
            'yii2bigcommercewebhooksmanager' => [
                'stores' => [
                    'storeId' => [
                        'adapter' => [
                            'type' => 'BigCommerce',
                            'auth' => [
                                'client_id' => client_id,
                                'store_hash' => store_hash,
                                'auth_token' => auth_token,
                                'sslForCurl' => true,
                                'webhookHash' => webhookHash,
                            ],
                            'webhooks' => [
                                'categories' => [
                                    'scope' => 'store/category/*',
                                    'headers' => [
                                        'X-Custom-Auth-Header' => ''
                                    ],
                                    'destination' => http://example.com/webhook/category,
                                    'is_active' => true,
                                ],
                                'products' => [
                                    'scope' => 'store/product/*',
                                    'headers' => [
                                        'X-Custom-Auth-Header' => ''
                                    ],
                                    'destination' => http://example.com/webhook/product,
                                    'is_active' => true,
                                ],
                                ...
                            ],
                        ],
                    ],
                    ...
                ],
            ],
	    ...
	],
	...
];
```

## License

See the bundled [LICENSE.md](LICENSE.md) for details.