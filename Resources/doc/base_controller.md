Base controller
===============

This bundle provide a base controller with many shortcuts to speedup the development and make your controllers smaller (and clearer). Just extend `Flub\BigBangBundle\Controller\Controller` to use these shortcuts.

```php
use Flub\BigBangBundle\Controller\Controller as BaseController;

class FooController extends BaseController

// ...
```

This class also extends the base controller provided by the `Symfony\Bundle\FrameworkBundle`.

Shortcuts
---------

### Security
* `getSecurity()` : return the `security.context` service
* `isGranted()` : proxy method for `isGranted` method of the `security.context`

### ORM
* `getEntityManager()` : return the default entity manager
* `getRepository($entity)` : return the doctrine repository of `$entity`. `$entity` can be the FQCN, the entity short notation or an entity object.
* `persist($entity, $flush = false)` : equivalent to `$this->getEntityManager()->persist($entity)`
* `remove($entity, $flush = false)` : equivalent to `$this->getEntityManager()->remove($entity)`
* `flush($entity = null)` : equivalent to `$this->getEntityManager()->flush()`
* `findOr404($entity, $criterias = array())` :
    * `$this->findOr404('AcmeLibraryBundle:Book', 2);`
    * `$this->findOr404('AcmeLibraryBundle:Book', array('author' => 'john'))`;
    * `$this->findOr404($bookRepository, 2);`
    * `$this->findOr404($bookRepository, array('author' => 'john'));`


### Misc
* `redirectToRoute($route, $parameters = array(), $status = 302)` : combinaison of `generateUrl` and `redirectTo` methods of `Symfony\Bundle\FrameworkBundle\Controller\Controller`.
