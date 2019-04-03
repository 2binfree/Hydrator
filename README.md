## Hydrator

Simple hydration mechanism.
Use the PHP trait to not block inheritance on your classes.

## ChangeLog

1.0.0 : initial version
1.0.1 : add support of properties of all parent classes
 
#### Installation : 

composer require tobinfree/hydrator

#### Usage:

Add trait in your class :
```
use ToBinFree\Hydrator\Hydrator;

Class User 
{
    use Hydrator;

    /**
    * @var int
    */
    private $id;

    /**
    * @var string
    */
    private $name;

    /**
    * @var string
    */
    private $email;
    ...
}
  
```  
Hydrator search all accessors and mutators methods from class properties.
If the methods are not found, the property will be used directly.

You can block the direct use of properties and force the use of the methods with:

```
    $user = new User();
    $user->setMutatorOnly(true); // for set method usage only
    $user->setAccessorOnly(true); // for get method usage only
```

Now, you can generate an array from your object :

```
    var_dump($user->toArray());
```
You can specify witch properties will be generated using annotation @DataProperty :
```
use ToBinFree\Hydrator\Hydrator;

Class User 
{
    use Hydrator;
    
    /**
    * @var int
    */
    private $id

    /**
    * @var string
    * @DataProperty
    */
    private $name;

    /**
    * @var string
    * @DataProperty
    */
    private $email;
    ...
}
```
```
    var_dump($user->toArray(true));
```

And you can hydrate your object with an array :

```
    $user->hydrate([
        "name" => "Eric",
        "email" => "eric@email.com"
    ]);
    
```
#### License

This bundle is under the MIT license. See the complete license in the bundle.
