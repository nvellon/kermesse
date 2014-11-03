<?php

namespace Kermesse\KermesseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesLines
 *
 * @ORM\Table(name="sales_lines", indexes={@ORM\Index(name="fk_sales_lines_products1_idx", columns={"products_id"}), @ORM\Index(name="fk_sales_lines_sales1", columns={"sales_id"})})
 * @ORM\Entity
 */
class SalesLines
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="price_unit", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $priceUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="price_total", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $priceTotal;

    /**
     * @var \Kermesse\KermesseBundle\Entity\Products
     *
     * @ORM\OneToOne(targetEntity="Kermesse\KermesseBundle\Entity\Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="products_id", referencedColumnName="id")
     * })
     */
    private $products;

    /**
     * @var \Kermesse\KermesseBundle\Entity\Sales
     *
     * @ORM\ManyToOne(targetEntity="Kermesse\KermesseBundle\Entity\Sales", inversedBy="salesLines")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sales_id", referencedColumnName="id")
     * })
     */
    private $sales;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return SalesLines
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return SalesLines
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set priceUnit
     *
     * @param string $priceUnit
     * @return SalesLines
     */
    public function setPriceUnit($priceUnit)
    {
        $this->priceUnit = $priceUnit;

        return $this;
    }

    /**
     * Get priceUnit
     *
     * @return string
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * Set priceTotal
     *
     * @param string $priceTotal
     * @return SalesLines
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * Get priceTotal
     *
     * @return string
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }

    /**
     * Set products
     *
     * @param \Kermesse\KermesseBundle\Entity\Products $products
     * @return SalesLines
     */
    public function setProducts(\Kermesse\KermesseBundle\Entity\Products $products = null)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \Kermesse\KermesseBundle\Entity\Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set sales
     *
     * @param \Kermesse\KermesseBundle\Entity\Sales $sales
     * @return SalesLines
     */
    public function setSales(\Kermesse\KermesseBundle\Entity\Sales $sales = null)
    {
        $this->sales = $sales;

        return $this;
    }

    /**
     * Get sales
     *
     * @return \Kermesse\KermesseBundle\Entity\Sales
     */
    public function getSales()
    {
        return $this->sales;
    }
}
