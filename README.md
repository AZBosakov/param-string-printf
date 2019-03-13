# Class description

Template string with printf-style placeholders.

When using sprintf(), the template parameters are passed as arguments. This class is sort of "delayed sprintf" - instead of variables, parameter names are passed to the constructor. There must be enough parameter names for all placeholders.

# Example

```
use AZBosakov\ParamString\Printf;
...
$pf = new Printf('The answer is %d, the question is %s, the answer again is %d', 'ans', 'q', 'ans');
$pf = $pf->withParams(['ans'=>42, 'q'=>'"6 x 9 = ?"']);

"$pf" == "The answer is 42, the question is "6 x 9 = ?", the answer again is 42";
```


# Methods

##  public function __construct(string $template, string ...$paramNames)
There must be enough params for all placeholders.

## public function getTemplate() : string (ParamStringInterface)
Get the template string passed to the constructor

## public function withParam(string $name, $value) : self (ParamStringInterface)
Clone the object and set the named param value.

## public function getParam(string $name) (ParamStringInterface)
Get a parameter by name

## public function withParams(array $params) : self (ParamStringInterface)
Clone the object and set multiple params at once.

## public function getParams() : array (ParamStringInterface)
Get a snapshot of the parameters

## public function __toString() : string (ParamStringInterface)

