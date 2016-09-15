# Silverstripe X-Framer
Set X-frame headers based on user

# Installation

## Composer

Add the following to your composer.json file

```json
{  
    "require": {  
        "Cyber-Duck/Silverstripe-X-Framer": "1.0.*"
    }
}
```

## Extension

In your config.yml file add the IP addresses you wish to exclude from X-Frame Headers

```yml
Xframer:
  ips:
    - 000.000.000.000
    - 000.000.000.001
```

## Controller

Next add the Xframer::init() function to your Page Controller init function

```php
class Page_Controller extends ContentController {

    public function init()
    {
        parent::init();

        Xframer::init();
    }
}
```

Run dev/build and flush to initialise the module