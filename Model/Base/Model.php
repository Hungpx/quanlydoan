<?php
namespace Model\Base;
class Model{
    /**
     * @var Logistics_ModelMapper
     */
    protected $mapper;
    
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @var int
     */
    protected $id;
    /**
     * @return the $options
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * @param string $key
     * @param null $defaultValue
     * @return null
     */
    public function getOption($key, $defaultValue = null)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $defaultValue;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }
    
    /**
     * @param array $options
     * @return mixed
     */
    public function addOptions($options)
    {
        if(is_array($options)) {
            foreach($options as $key => $value) {
                $this->options[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * @param multitype: $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set object state
     *
     * @param array $options
     * @return $this
     */
    public function exchangeArray($options)
    {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (in_array($method, get_class_methods($this))) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }
}