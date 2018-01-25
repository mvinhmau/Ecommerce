<?php
namespace EcommerceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task
{


    protected $name;
    protected $priceMin;

    /**
    *@Assert\GreaterThanOrEqual(0)
    */
    protected $priceMax;
    protected $description;
    protected $category;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPriceMin()
    {
        return $this->priceMin;
    }

    public function setPriceMin($priceMin)
    {
        $this->priceMin = $priceMin;
    }

    public function getPriceMax()
    {
        return $this->priceMax;
    }

    public function setPriceMax($priceMax)
    {
        $this->priceMax = $priceMax;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
}
