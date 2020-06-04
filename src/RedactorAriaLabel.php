<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\redactorarialabel;

use craft\base\Plugin;
use craft\redactor\events\ModifyPurifierConfigEvent;
use craft\redactor\events\RegisterPluginPathsEvent;
use craft\redactor\Field;
use yii\base\Event;

/**
 * @property ComponentsService $componentsService
 */
class RedactorAriaLabel extends Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Register resources as Redactor plugin path
        Event::on(Field::class, Field::EVENT_REGISTER_PLUGIN_PATHS, function(RegisterPluginPathsEvent $event) {
            $event->paths[] = __DIR__.'/resources';
        });

        // Allow the use of the aria-label attribute
        Event::on(Field::class, Field::EVENT_MODIFY_PURIFIER_CONFIG, function(ModifyPurifierConfigEvent $event) {
            $event->config->getHTMLDefinition(true)->addAttribute('a', 'aria-label', 'URI');
        });

        Field::registerRedactorPlugin('aria-label');
    }
}
