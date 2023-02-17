<?php

use Flarum\Extend;
use s9e\TextFormatter\Configurator;

return [
    (new Extend\Formatter)
        ->configure(function (Configurator $config) {
            
            // Unload the Escaper plugin
            if ($config->plugins->exists('Escaper'))
                $config->plugins->delete('Escaper');

            $config->rootRules->enableAutoLineBreaks();

            // Allowed BBCode tags
            $config->BBCodes->addFromRepository('B');
            $config->BBCodes->addFromRepository('I');
            $config->BBCodes->addFromRepository('CODE');
            $config->BBCodes->addFromRepository('IMG');
            $config->BBCodes->addFromRepository('URL');
            $config->BBCodes->addFromRepository('*');
            $config->BBCodes->addFromRepository('OL');
            $config->BBCodes->addFromRepository('UL');
            $config->BBCodes->add('LI');
        
            // Allowed HTML tags
            $config->HTMLElements->allowElement('details');
            $config->HTMLElements->allowAttribute('details', 'summary');
            $config->HTMLElements->allowElement('b');
            $config->HTMLElements->allowElement('strong');
            $config->HTMLElements->allowElement('i');
            $config->HTMLElements->allowElement('em');
            $config->HTMLElements->allowElement('strike');
            $config->HTMLElements->allowElement('u');
            $config->HTMLElements->allowElement('blockquote');
            $config->HTMLElements->allowElement('center');
            $config->HTMLElements->allowElement('p');
            $config->HTMLElements->allowElement('a');
            $config->HTMLElements->allowAttribute('a', 'href');
            $config->HTMLElements->allowElement('code');
            $config->HTMLElements->allowAttribute('code', 'class');
            $config->HTMLElements->allowElement('pre');
            $config->HTMLElements->allowElement('img');
            $config->HTMLElements->allowAttribute('img', 'src');
            $config->HTMLElements->allowAttribute('img', 'width');
            $config->HTMLElements->allowElement('br');
            $config->HTMLElements->allowElement('hr');
            $config->HTMLElements->allowElement('ol');
            $config->HTMLElements->allowElement('ul');
            $config->HTMLElements->allowElement('li');

            // Patterns for @
            $config->Preg->match('/\B@(?<username>[\x{2e80}-\x{3000}\x{3021}-\x{fe4f}a-z0-9_.-]+)#(?<id>\d+)/iu', 'POSTMENTION');
            $config->Preg->match('/\B@(?<username>[\x{2e80}-\x{3000}\x{3021}-\x{fe4f}a-z0-9_.-]+)(?!#)/iu', 'USERMENTION');

            // Change highlight.js links
            if ($config->tags->exists('CODE')) {
                $code_tag_template = $config->tags->get('CODE')->getTemplate();
                $content = $code_tag_template->__toString();
                $content = preg_replace('#//cdnjs.+highlight\.js.+default\.min\.css#', '//cdn.bootcss.com/highlight.js/9.12.0/styles/github.min.css', $content);
                $content = preg_replace('#//cdnjs.+highlight\.min\.js#', '//uploads.cosx.org/static/hljs/highlight.pack.js', $content);
                $code_tag_template->setContent($content);
                $code_tag_template->isNormalized(TRUE);
            }
        })
];
