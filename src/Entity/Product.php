<?php
namespace NotifyMe\Factory;
/**
 * @Entity
 * @Table(name="product")
 **/

class Product
{
    /**
	 * @var int
	 *
	 * @Id @Column(type="integer", length=255) @GeneratedValue
	 **/
	protected $id;

    /**
	 * @var string
	 *
	 * @Column(type="string", length=255, nullable=false, name="name") @GeneratedValue
	 **/
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}