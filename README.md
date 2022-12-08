## Hydrator

Simple hydration mechanism.
Use the PHP trait to not block inheritance on your classes.

## ChangeLog

* 0.1.0
  * initial version
* 0.2.0
  * add support of properties of all parent classes
* 0.3.0
  * add null properties filter
* 0.4.0
  * add boolean getter "is" support
* 0.5.0
  * change required php version to php 8.1
  * use Attribute rather than php doc for annotation
  * fix getter and setter detection from parent class
                  
#### Installation : 

composer require tobinfree/hydrator

#### Usage:

Add trait in your class :
```
use ToBinFree\Hydrator\Hydrator;

Class User 
{
    use Hydrator;

    private int $id;

    private string $name;

    private string $email;
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
    
    private int $id

    #[DataProperty]
    private string $name;

    #[DataProperty]
    private string $email;
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

By default, null values properties are included. You can filter null properties with ```withNullValue``` option :    
```
    $user->hydrate($array, true, false);
    var_dump($user->toArray(true, false));
```


#### License

This bundle is under the MIT license. See the complete license in the bundle.
