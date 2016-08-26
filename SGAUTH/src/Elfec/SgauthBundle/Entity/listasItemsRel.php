<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * listasItemsRel
 *
 * @ORM\Table(name="elfec.listas_items_rel")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\listasItemsRelRepository")
 */
class listasItemsRel
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_rel", type="integer")
     */
    private $idRel;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_padre", type="integer")
     */
    private $idPadre;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_hijo", type="integer")
     */
    private $idHijo;

    /**
     * @var \listasItems
     *
     * @ORM\ManyToOne(targetEntity="listasItems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_padre", referencedColumnName="id_item")
     * })
     */
    private $padre;

    /**
     * @var \listasItems
     *
     * @ORM\ManyToOne(targetEntity="listasItems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hijo", referencedColumnName="id_item")
     * })
     */
    private $hijo;

    /**
     * Set idRel
     *
     * @param integer $idRel
     * @return listasItemsRel
     */
    public function setIdRel($idRel)
    {
        $this->idRel = $idRel;

        return $this;
    }

    /**
     * Get idRel
     *
     * @return integer
     */
    public function getIdRel()
    {
        return $this->idRel;
    }

    /**
     * Set idPadre
     *
     * @param integer $idPadre
     * @return listasItemsRel
     */
    public function setIdPadre($idPadre)
    {
        $this->idPadre = $idPadre;

        return $this;
    }

    /**
     * Get idPadre
     *
     * @return integer
     */
    public function getIdPadre()
    {
        return $this->idPadre;
    }

    /**
     * Set idHijo
     *
     * @param integer $idHijo
     * @return listasItemsRel
     */
    public function setIdHijo($idHijo)
    {
        $this->idHijo = $idHijo;

        return $this;
    }

    /**
     * Get idHijo
     *
     * @return integer
     */
    public function getIdHijo()
    {
        return $this->idHijo;
    }

    /**
     * Set padre
     *
     * @param \Elfec\SgauthBundle\Entity\listasItems $padre
     * @return listasItemsRel
     */
    public function setPadre(\Elfec\SgauthBundle\Entity\listasItems $padre = null)
    {
        $this->padre = $padre;
    
        return $this;
    }

    /**
     * Get padre
     *
     * @return \Elfec\SgauthBundle\Entity\listasItems 
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set hijo
     *
     * @param \Elfec\SgauthBundle\Entity\listasItems $hijo
     * @return listasItemsRel
     */
    public function setHijo(\Elfec\SgauthBundle\Entity\listasItems $hijo = null)
    {
        $this->hijo = $hijo;
    
        return $this;
    }

    /**
     * Get hijo
     *
     * @return \Elfec\SgauthBundle\Entity\listasItems 
     */
    public function getHijo()
    {
        return $this->hijo;
    }
}
