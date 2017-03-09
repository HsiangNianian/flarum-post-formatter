<?php

namespace Cosname\Listener;

use Flarum\Event\ConfigureFormatter;
use Illuminate\Contracts\Events\Dispatcher;

class PostFormatter
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureFormatter::class, [$this, 'addHTMLBBCodeFormatter']);
    }

    /**
     * @param ConfigureFormatter $event
     */
    public function addHTMLBBCodeFormatter(ConfigureFormatter $event)
    {
        // Unload the Escaper plugin
        if($event->configurator->plugins->exists('Escaper'))
            $event->configurator->plugins->delete('Escaper');

        $event->configurator->rootRules->enableAutoLineBreaks();

        $event->configurator->BBCodes->addFromRepository('B');
        $event->configurator->BBCodes->addFromRepository('I');
        $event->configurator->BBCodes->addFromRepository('CODE');
        $event->configurator->BBCodes->addFromRepository('IMG');
        $event->configurator->BBCodes->addFromRepository('URL');
        $event->configurator->BBCodes->addFromRepository('*');
        $event->configurator->BBCodes->addFromRepository('OL');
        $event->configurator->BBCodes->addFromRepository('UL');
        $event->configurator->BBCodes->add('LI');

        $event->configurator->HTMLElements->allowElement('b');
        $event->configurator->HTMLElements->allowElement('i');
        $event->configurator->HTMLElements->allowElement('strong');
        $event->configurator->HTMLElements->allowElement('p');
        $event->configurator->HTMLElements->allowElement('a');
        $event->configurator->HTMLElements->allowElement('code');
        $event->configurator->HTMLElements->allowAttribute('code', 'class');
        $event->configurator->HTMLElements->allowElement('pre');
        $event->configurator->HTMLElements->allowElement('img');
        $event->configurator->HTMLElements->allowElement('br');
        $event->configurator->HTMLElements->allowElement('ol');
        $event->configurator->HTMLElements->allowElement('ul');
        $event->configurator->HTMLElements->allowElement('li');
    }
}
