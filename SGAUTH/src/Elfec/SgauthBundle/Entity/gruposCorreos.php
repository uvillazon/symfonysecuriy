<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * gruposCorreos
 *
 * @ORM\Table(name="elfec.grupos_correos")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\gruposCorreosRepository")
 */
class gruposCorreos
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_grp", type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.q_grupos_correos", allocationSize=1, initialValue=1)
     */
    private $idGrp;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idAplic;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="gruposDestCorreo", mappedBy="grupoCorreo" )
     */
    private $gruposDestCorreos;

    public function __construct() {
        $this->gruposDestCorreos = new ArrayCollection();
    }



    /**
     * Set idGrp
     *
     * @param integer $idGrp
     * @return gruposCorreos
     */
    public function setIdGrp($idGrp)
    {
        $this->idGrp = $idGrp;
    
        return $this;
    }

    /**
     * Get idGrp
     *
     * @return integer 
     */
    public function getIdGrp()
    {
        return $this->idGrp;
    }

    /**
     * Set id_aplic
     *
     * @param string $idAplic
     * @return gruposCorreos
     */
    public function setIdAplic($idAplic)
    {
        $this->idAplic = $idAplic;

        return $this;
    }

    /**
     * Get id_aplic
     *
     * @return string
     */
    public function getIdAplic()
    {
        return $this->idAplic;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return gruposCorreos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return gruposCorreos
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
}
