<?php
namespace allswap\cryptovalidator;

use Craft;
use craft\base\Plugin as BasePlugin;
use allswap\cryptovalidator\twigextensions\CryptoTwigExtension;
use yii\base\Event;

/**
 * Crypto Address Validator Plugin for Craft CMS
 *
 * @author    AllSwap Protocol <https://allswap.io>
 * @copyright Copyright (c) 2026 AllSwap Protocol
 * @license   MIT
 */
class Plugin extends BasePlugin
{
    public static Plugin $plugin;

    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = false;
    public bool $hasCpSection = false;

    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // Register Twig Extension for templates
        Craft::$app->view->registerTwigExtension(new CryptoTwigExtension());

        Craft::info(
            Craft::t('crypto-address-validator', '{name} plugin loaded', ['name' => $this->name]),
            __METHOD__
        );
    }
}
