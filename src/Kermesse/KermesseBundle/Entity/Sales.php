<?php

namespace Kermesse\KermesseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sales
 *
 * @ORM\Table(name="sales", indexes={@ORM\Index(name="fk_ventas_eventos1_idx", columns={"event_id"})})
 * @ORM\Entity
 */
class Sales
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
     * @var string
     *
     * @ORM\Column(name="price_total", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $priceTotal;

    /**
     * @var \Kermesse\KermesseBundle\Entity\Events
     *
     * @ORM\OneToOne(targetEntity="Kermesse\KermesseBundle\Entity\Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * })
     */
    private $event;

    /**
     * @var \Kermesse\KermesseBundle\Entity\SalesLines
     *
     * @ORM\OneToMany(targetEntity="Kermesse\KermesseBundle\Entity\SalesLines", mappedBy="sales", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="sales_id")
     * })
     */
    private $salesLines;

    public function __construct()
    {
        $this->salesLines = new ArrayCollection();
    }

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
     * @return Sales
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
     * Set priceTotal
     *
     * @param string $priceTotal
     * @return Sales
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
     * Set event
     *
     * @param \Kermesse\KermesseBundle\Entity\Events $event
     * @return Sales
     */
    public function setEvent(\Kermesse\KermesseBundle\Entity\Events $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Kermesse\KermesseBundle\Entity\Events
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Get sale lines
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSalesLines()
    {
        return $this->salesLines;
    }
}
