Var directory
=============


This bundle allow you to change the standard way to store cache and log files putting files in a `var` directory at the root of the project :

```
+- app
+- src
+- var
|  +- cache
|  |  +- dev
|  |  +- prod
|  |  +- test
|  +- logs
|  +- sessions
+- vendor
```

It's easy to adopt this architecture. Just make your AppKernel extends the `Flub\BigBangBundle\HttpKernel\Kernel`.

```php
# app/AppKernel.php

// ...

use Flub\BigBangBundle\HttpKernel\Kernel as KernelWithVarDirectory;

class AppKernel extends KernelWithVarDirectory
{
// ...
```