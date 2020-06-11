<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\redactorarialabel;

use Craft;
use craft\base\Plugin;
use craft\redactor\events\ModifyPurifierConfigEvent;
use craft\redactor\events\RegisterPluginPathsEvent;
use craft\redactor\Field;
use yii\base\Event;

class RedactorAriaLabel extends Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            // Register resources as Redactor plugin path
            Event::on(Field::class, Field::EVENT_REGISTER_PLUGIN_PATHS, function(RegisterPluginPathsEvent $event) {
                $event->paths[] = __DIR__.'/resources';
            });

            // Allow the use of the aria-label attribute with HTML Purifier
            Event::on(Field::class, Field::EVENT_MODIFY_PURIFIER_CONFIG, function(ModifyPurifierConfigEvent $event) {
                $event->config->getHTMLDefinition(true)->addAttribute('a', 'aria-label', 'Text');
            });

            Field::registerRedactorPlugin('aria-label');
        }
    }
}
