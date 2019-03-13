<?php
namespace AZBosakov\ParamString;

/**
 * Template string with sprintf-style placeholders.
 * 
 * @author Aleksandar Z. Bosakov <aleksandar.z.bosakov@gmail.com>
 * @license MIT
 * 
 * @implements ParamStringInterface
 */
class Printf implements ParamStringInterface
{
    /** @var string $template The template string passed to the constructor */
    private $template = '';
    /** @var array $params The placeholder values */
    private $params = [];
    /** @var array $paramNames The names of the parameters, corresponding to each '%' placeholder */
    private $paramNames = [];
    /** @var string $toString_cache Create the string only once */
    private $toString_cache = null;
    
    /**
     * @param string $template The sprintf template
     * @param array[string] $paramNames The names of the parameters, corresponding to each '%' placeholder
     */
    public function __construct(string $template, string ...$paramNames)
    {
        $this->template = $template;
        $this->paramNames = $paramNames;
        $this->params = array_fill_keys($paramNames, null);
        $args = [];
        foreach ($this->paramNames as $pn) {
            $args[] = $this->params[$pn];
        }
        $this->toString_cache = sprintf($this->template, ...$args);
        if ($this->toString_cache === false) {
            throw new \InvalidArgumentException('Insufficient arguments for the template');
        }
    }
    
    public function getParam(string $name)
    {
        return $this->params[$name] ?? null;
    }
    
    public function withParam(string $name, $value) : ParamStringInterface
    {
        $tl = clone $this;
        if (! array_key_exists($name, $this->params)) {
            trigger_error("Invalid param: $name");
            return $this;
        }
        $tl->params[$name] = $value;
        $tl->toString_cache = null;
        return $tl;
    }
    
    public function withParams(array $params) : ParamStringInterface
    {
        $tl = clone $this;
        foreach ($params as $p => $v) {
            if (array_key_exists($p, $tl->params)) {
                $tl->params[$p] = $v;
            } else {
                trigger_error("Invalid param: $p");
            }
        }
        $tl->toString_cache = null;
        return $tl;
    }
    
    public function getParams() : array
    {
        return $this->params;
    }
    
    public function getTemplate() : string
    {
        return $this->template;
    }
    
    public function __toString() : string
    {
        $args = [];
        if ($this->toString_cache === null) {
            foreach ($this->paramNames as $pn) {
                $args[] = $this->params[$pn];
            }
            $this->toString_cache = sprintf($this->template, ...$args);
            if ($this->toString_cache === false) {
                throw new \InvalidArgumentException('Insufficient arguments for template or non convertible to string ones');
            }
        }
        return $this->toString_cache;
    }
}
