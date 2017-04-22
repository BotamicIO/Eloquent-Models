<?php


declare(strict_types=1);

/*
 * This file is part of Eloquent Models.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Eloquent\Models\Traits;

trait CamelCaseAttributes
{
    /**
     * @var bool
     */
    public $enforceCamelCase = true;

    /**
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($this->getSnakeKey($key), $value);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (method_exists($this, $key)) {
            return $this->getRelationshipFromMethod($key);
        }

        return parent::getAttribute($this->getSnakeKey($key));
    }

    /**
     * @return array
     */
    public function attributesToArray()
    {
        return $this->toCamelCase(parent::attributesToArray());
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributesToArray();
    }

    /**
     * @return array
     */
    public function relationsToArray()
    {
        return $this->toCamelCase(parent::relationsToArray());
    }

    /**
     * @param $attributes
     *
     * @return array
     */
    public function toCamelCase($attributes)
    {
        $convertedAttributes = [];

        foreach ($attributes as $key => $value) {
            $key = $this->getTrueKey($key);
            $convertedAttributes[$key] = $value;
        }

        return $convertedAttributes;
    }

    /**
     * @param null $key
     * @param null $default
     *
     * @return mixed
     */
    public function getOriginal($key = null, $default = null)
    {
        return array_get($this->toCamelCase($this->original), $key, $default);
    }

    /**
     * @param $attributes
     *
     * @return array
     */
    private function toSnakeCase($attributes)
    {
        $convertedAttributes = [];

        foreach ($attributes as $key => $value) {
            $convertedAttributes[$this->getSnakeKey($key)] = $value;
        }

        return $convertedAttributes;
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function getTrueKey($key)
    {
        // If the key is a pivot key, leave it alone - this is required internal behaviour
        // of Eloquent for dealing with many:many relationships.
        if ($this->isCamelCase() && strpos($key, 'pivot_') === false) {
            $key = camel_case($key);
        }

        return $key;
    }

    /**
     * @return bool
     */
    public function isCamelCase()
    {
        return $this->enforceCamelCase or (isset($this->parent) && method_exists($this->parent, 'isCamelCase') && $this->parent->isCamelCase());
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function getSnakeKey($key)
    {
        return snake_case($key);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __isset($key)
    {
        $key = snake_case($key);

        return parent::__isset($key);
    }
}
