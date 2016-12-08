# Installation

## Composer

Add the following to your composer.json file

```json
{  
    "require": {  
        "cyber-duck/silverstripe-x-framer": "1.0.*"
    }
}
```

Run composer and then visit /dev/build?flush=all to rebuild the database and flush the cache.

## YML Configuration

Add any IPs your wish to exclude from X-Frame headers to the YML config array

```yml
Xframer:
  ips:
    - 000.000.000.000
    - 000.000.000.001
``` 

## Controller

Call the Xframer init method on your Page Controller or similar

```php
class Page_Controller extends ContentController
{
    public function init()
    {
    	parent::init();

        Xframer::init();
    }
}
```