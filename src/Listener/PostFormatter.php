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
        $event->configurator->HTMLElements->allowElement('strong');
        $event->configurator->HTMLElements->allowElement('i');
        $event->configurator->HTMLElements->allowElement('em');
        $event->configurator->HTMLElements->allowElement('strike');
        $event->configurator->HTMLElements->allowElement('u');
        $event->configurator->HTMLElements->allowElement('blockquote');
        $event->configurator->HTMLElements->allowElement('center');
        $event->configurator->HTMLElements->allowElement('p');
        $event->configurator->HTMLElements->allowElement('a');
        $event->configurator->HTMLElements->allowAttribute('a', 'href');
        $event->configurator->HTMLElements->allowElement('code');
        $event->configurator->HTMLElements->allowAttribute('code', 'class');
        $event->configurator->HTMLElements->allowElement('pre');
        $event->configurator->HTMLElements->allowElement('img');
        $event->configurator->HTMLElements->allowAttribute('img', 'src');
        $event->configurator->HTMLElements->allowElement('br');
        $event->configurator->HTMLElements->allowElement('hr');
        $event->configurator->HTMLElements->allowElement('ol');
        $event->configurator->HTMLElements->allowElement('ul');
        $event->configurator->HTMLElements->allowElement('li');

        $event->configurator->Preg->match('/\B@(?<username>[\x{2e80}-\x{3000}\x{3021}-\x{fe4f}a-z0-9_.-]+)#(?<id>\d+)/iu', 'POSTMENTION');
        $event->configurator->Preg->match('/\B@(?<username>[\x{2e80}-\x{3000}\x{3021}-\x{fe4f}a-z0-9_.-]+)(?!#)/iu', 'USERMENTION');
    }
}
