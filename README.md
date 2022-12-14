# DOM Downloader

This TYPO3 extension extends the tt_content element `HTML` for the functionality of loading and postprocessing remote content.

![Example Image](https://bitbucket.org/blueways/bw_cache_uri/raw/master/Documentation/Images/example1.jpg)

## Features

* Load and save remote content from URL
* Filter saved DOM with [CSS selectors](https://symfony.com/doc/current/components/css_selector.html)
* Manipulate the content with custom post-processors (e.g. stripe tags, add wrap,..)
* Options for processors via TypoScript
* Scheduler task to refresh content

## Install

1. Install via composer

```bash
composer require blueways/bw-cache-uri
```

2. Include TypoScript template


## Usage

Just create a new HTML-Content Element and add any URL in the parsing options. After saving, the remote content is fetched, processed and saved.

## Scheduler

The DOM Downloader task will refresh the bodytext of all tt_content elements that have a parsing uri set.

## Post Processor

After receiving the remote content, custom post processors can be applied to transform the content, e.g. to wrap or remove text.
To register a new processor, add the following TypoScript:

```
plugin.tx_bwcacheuri.settings.postProcessors {
    Vendor\YourExt\Processor\MyFancyProcessor {
        label = Name in select box
        options {
            custom_setting = 2,4
            allowed_tags = <div>
        }
    }
}
``` 

Your processor class must implement the **PostProcessorInterface**:

```PHP
<?php
namespace Vendor\YourExt\Processor;

class MyFancyProcessor implements \Blueways\BwCacheUri\Processor\PostProcessorInterface
{
    public function process($dom, $options)
    {
        return strip_tags($dom, $options['allowed_tags']);
    }
}
```


## DDEV cron job

See [ddev-contrib](https://github.com/drud/ddev-contrib/tree/master/recipes/cronjob) to see how to make the scheduler run locally.

## Examples

### Use Filter to get current weather

![Weather example](https://bitbucket.org/blueways/bw_cache_uri/raw/master/Documentation/Images/example1.png)

### Get current Time

![Time example](https://bitbucket.org/blueways/bw_cache_uri/raw/master/Documentation/Images/example2.png)
