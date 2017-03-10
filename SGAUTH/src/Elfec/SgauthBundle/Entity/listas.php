<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * listas
 *
 * @ORM\Table(name="elfec.listas")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\listasRepository")
 */
class listas
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_lista", type="integer")
     */
    private $idLista;

    /**
     * @var string
     *
     * @ORM\Column(name="lista", type="string", length=20)
     */
    private $lista;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="tam_limite", type="smallint")
     */
    private $tamLimite;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_valor", type="string", length=10)
     */
    private $tipoValor;

    /**
     * @var string
     *
     * @ORM\Column(name="mayus_minus", type="string", length=5)
     */
    private $mayusMinus;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="ordenar_por", type="string", length=30)
     */
    private $ordenarPor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_orden", type="string", length=4)
     */
    private $tipoOrden;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="listasItems", mappedBy="lista")
     */
    private $listaItems;

    public function __construct() {
        $this->listaItems = new ArrayCollection();
    }

    /**
     * Set idLista
     *
     * @param integer $idLista
     * @return listas
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
     * Set lista
     *
     * @param string $lista
     * @return listas
     */
    public function setLista($lista)
    {
        $this->lista = $lista;
    
        return $this;
    }

    /**
     * Get lista
     *
     * @return string 
     */
    public function getLista()
    {
        return $this->lista;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return listas
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tamLimite
     *
     * @param integer $tamLimite
     * @return listas
     */
    public function setTamLimite($tamLimite)
    {
        $this->tamLimite = $tamLimite;
    
        return $this;
    }

    /**
     * Get tamLimite
     *
     * @return integer 
     */
    public function getTamLimite()
    {
        return $this->tamLimite;
    }

    /**
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return listas
     */
    public function setTipoValor($tipoValor)
    {
        $this->tipoValor = $tipoValor;
    
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return string 
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * Set mayusMinus
     *
     * @param string $mayusMinus
     * @return listas
     */
    public function setMayusMinus($mayusMinus)
    {
        $this->mayusMinus = $mayusMinus;
    
        return $this;
    }

    /**
     * Get mayusMinus
     *
     * @return string 
     */
    public function getMayusMinus()
    {
        return $this->mayusMinus;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return listas
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
     * Add ListaItems
     *
     * @param \Elfec\SgauthBundle\Entity\listasItems $listaItems
     * @return Listas
     */
    public function addListaItem(\Elfec\SgauthBundle\Entity\listasItems $listaItems)
    {
        $this->listaItems[] = $listaItems;

        return $this;
    }

    /**
     * Remove ListaItems
     *
     * @param \Elfec\SgauthBundle\Entity\listasItems $listaItems
     */
    public function removeListaItem(\Elfec\SgauthBundle\Entity\listasItems $listaItems)
    {
        $this->listaItems->removeElement($listaItems);
    }

    /**
     * Get ListaItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListaItems()
    {
        return $this->listaItems;
    }

    /**
     * Set idAplic
     *
     * @param string $idAplic
     * @return listas
     */
    public function setIdAplic($idAplic)
    {
        $this->idAplic = $idAplic;
    
        return $this;
    }

    /**
     * Get idAplic
     *
     * @return string 
     */
    public function getIdAplic()
    {
        return $this->idAplic;
    }

    /**
     * Set ordenarPor
     *
     * @param string $ordenarPor
     * @return listas
     */
    public function setOrdenarPor($ordenarPor)
    {
        $this->ordenarPor = $ordenarPor;
    
        return $this;
    }

    /**
     * Get ordenarPor
     *
     * @return string 
     */
    public function getOrdenarPor()
    {
        return $this->ordenarPor;
    }

    /**
     * Set tipoOrden
     *
     * @param string $tipoOrden
     * @return listas
     */
    public function setTipoOrden($tipoOrden)
    {
        $this->tipoOrden = $tipoOrden;
    
        return $this;
    }

    /**
     * Get tipoOrden
     *
     * @return string 
     */
    public function getTipoOrden()
    {
        return $this->tipoOrden;
    }
}
