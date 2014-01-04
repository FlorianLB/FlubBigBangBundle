Installation
============

Step 1 : Install with Composer
---------------------

Require [`flub/bigbang-bundle`](https://packagist.org/packages/flub/bigbang-bundle)
into your `composer.json` file:

``` json
{
    "require": {
        "flub/bigbang-bundle": "0.1.0"
    }
}
```

Then run

``` bash
composer.phar update flub/bigbang-bundle
```

Step 2 : Register the bundle
--------------------------

Register the bundle in `app/AppKernel.php` :

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Flub\BigBangBundle\FlubBigBangBundle(),
    );
}
```

Step 3 : Enjoy ;)
-----------------