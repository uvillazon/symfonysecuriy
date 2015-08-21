<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.perfiles
 *
 * @ORM\Table(name="elfec.perfiles", indexes={@ORM\Index(name="IDX_28A007AAC6839A04", columns={"id_aplic"})})
 * @ORM\Entity
 */
class perfil
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_perfil", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.perfiles_id_perfil_seq", allocationSize=1, initialValue=1)
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=40, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="rol_bd", type="string", length=30, nullable=true)
     */
    private $rolBd;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=false)
     */
    private $estado;

    /**
     * @var \aplicaciones
     *
     * @ORM\ManyToOne(targetEntity="aplicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aplic", referencedColumnName="id_aplic")
     * })
     */
    private $idAplic;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="botones", inversedBy="idPerfil")
     * @ORM\JoinTable(name="elfec.perfiles_botones",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_boton", referencedColumnName="id_boton")
     *   }
     * )
     */
    private $idBoton;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idBoton = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idPerfil
     *
     * @return string 
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return perfil
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return perfil
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
     * Set rolBd
     *
     * @param string $rolBd
     * @return perfil
     */
    public function setRolBd($rolBd)
    {
        $this->rolBd = $rolBd;

        return $this;
    }

    /**
     * Get rolBd
     *
     * @return string 
     */
    public function getRolBd()
    {
        return $this->rolBd;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return perfil
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
     * Set idAplic
     *
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $idAplic
     * @return perfil
     */
    public function setIdAplic(\Elfec\SgauthBundle\Entity\aplicaciones $idAplic = null)
    {
        $this->idAplic = $idAplic;

        return $this;
    }

    /**
     * Get idAplic
     *
     * @return \Elfec\SgauthBundle\Entity\aplicaciones 
     */
    public function getIdAplic()
    {
        return $this->idAplic;
    }

    /**
     * Add idBoton
     *
     * @param \Elfec\SgauthBundle\Entity\botones $idBoton
     * @return perfil
     */
    public function addIdBoton(\Elfec\SgauthBundle\Entity\botones $idBoton)
    {
        $this->idBoton[] = $idBoton;

        return $this;
    }

    /**
     * Remove idBoton
     *
     * @param \Elfec\SgauthBundle\Entity\botones $idBoton
     */
    public function removeIdBoton(\Elfec\SgauthBundle\Entity\botones $idBoton)
    {
        $this->idBoton->removeElement($idBoton);
    }

    /**
     * Get idBoton
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdBoton()
    {
        return $this->idBoton;
    }
}