<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * listaItems
 *
 * @ORM\Table(name="elfec.listas_items")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\listasItemsRepository")
 */
class listasItems
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_item", type="integer")
     */
    private $idItem;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_lista", type="integer")
     */
    private $idLista;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=100)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="orden", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $orden;

    /**
     * @var \listas
     *
     * @ORM\ManyToOne(targetEntity="listas" , inversedBy="listaItems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_lista", referencedColumnName="id_lista")
     * })
     */
    private $lista;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="listasItemsRel", mappedBy="padre")
     */
    private $hijos;




    /**
     * Set idItem
     *
     * @param integer $idItem
     * @return listaItems
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;
    
        return $this;
    }

    /**
     * Get idItem
     *
     * @return integer 
     */
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * Set idLista
     *
     * @param integer $idLista
     * @return listaItems
     */
    public function setIdLista($idLista)
    {
        $this->idLista = $idLista;
    
        return $this;
    }

    /**
     * Get idLista
     *
     * @return integer 
     */
    public function getIdLista()
    {
        return $this->idLista;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return listaItems
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return listaItems
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return listaItems
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set lista
     *
     * @param \Elfec\SgauthBundle\Entity\listas $lista
     * @return listasItems
     */
    public function setLista(\Elfec\SgauthBundle\Entity\listas $lista = null)
    {
        $this->lista = $lista;

        return $this;
    }

    /**
     * Get lista
     *
     * @return \Elfec\SgauthBundle\Entity\listas
     */
    public function getLista()
    {
        return $this->lista;
    }

    /**
     * Set orden
     *
     * @param string $orden
     * @return listasItems
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return string 
     */
    public function getOrden()
    {
        return $this->orden;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add hijos
     *
     * @param \Elfec\SgauthBundle\Entity\listasItemsRel $hijos
     * @return listasItems
     */
    public function addHijo(\Elfec\SgauthBundle\Entity\listasItemsRel $hijos)
    {
        $this->hijos[] = $hijos;
    
        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \Elfec\SgauthBundle\Entity\listasItemsRel $hijos
     */
    public function removeHijo(\Elfec\SgauthBundle\Entity\listasItemsRel $hijos)
    {
        $this->hijos->removeElement($hijos);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHijos()
    {
        return $this->hijos;
    }
}
