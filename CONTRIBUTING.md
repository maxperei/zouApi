## Database deployment

`php app/console doctrine:schema:update --dump-sql`

`php app/console doctrine:schema:update --force`

## Data Fixtures

`php app/console doctrine:fixtures:load --append`

## Schema

#### Use the command-line tool

Generate crud from our entities e.g. `doctrine:generate:crud --entity=AppBundle:Entity`

Generate forms from our entities e.g. `doctrine:generate:form AppBundle:Entity`

You'll see that doctrine create a new associated controller as well as a new form-type

At the level of the app resources you'll have each views too 

#### In case of ENUM

If the entity have enum column e.g. `@ORM\Column(name="col", type="string", columnDefinition="ENUM('str', 'str', 'str')", nullable=true)`

#### Routing example

Then create a new routing for each http methods according to entity e.g.

```
get_entity:
    path:  /entities/{id}
    defaults: { _controller: AppBundle:Entity:get, _format: ~ }
    requirements:
        _method: GET
        id: "\d+"

get_entities:
    path:  /entities
    defaults: { _controller: AppBundle:Entity:all, _format: ~ }
    requirements:
        _method: GET

post_entity:
    path:  /entities
    defaults: { _controller: AppBundle:Entity:post, _format: ~ }
    requirements:
        _method: POST

put_entity:
    path:  /entities/{id}
    defaults: { _controller: AppBundle:Entity:put, _format: ~ }
    requirements:
        _method: PUT
        id: "\d+"

delete_entity:
    path:  /entities/{id}
    defaults: { _controller: AppBundle:Entity:delete, _format: ~ }
    requirements:
        _method: DELETE
        id: "\d+"
```

Don't forget to make a link with the bundle routing e.g.

```
app_api_entity:
    type: rest
    prefix: /
    resource: "@AppBundle/Resources/config/routing/entity.yml"
``` 

#### Component

Well, then open the associated controller to extend FOSRest Class

Imports should be like :

```
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Entity;
use AppBundle\Form\EntityType;

class AdviceController extends FOSRestController {}
```

#### Hints

For the next to come, duplicate the content of an existing entity :

- Grab the search and replace tool (cmd+r)
- Replace all the capitalized `Entity`
- Then, replace all the vars `$entity`, don't forget to prefix your query by `$` !
- Be careful of : `return $this->routeRedirectView('get_entity', $routeOptions, Response::HTTP_CREATED);` (line 105)

#### FormTypes

Finally replace all annotations in the associated EntityForm

And, the right entity name (lowercase as well)

In case of dates, you've got to import a special class from Symfony Core, further doc can be found here : [http://symfony.com/doc/2.8/reference/forms/types/date.html](http://symfony.com/doc/2.8/reference/forms/types/date.html)

___

At least this config seems to work :
```
$builder
    ->add('date', DateType::class,
        array(
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd'
        )
```

Don't ever forget this ! `'csrf_protection' => false` (for `$resolver` defaults)

___

Then, restart again...