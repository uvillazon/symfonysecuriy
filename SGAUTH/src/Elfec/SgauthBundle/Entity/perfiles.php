<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.perfiles
 *
 * @ORM\Table(name="elfec.perfiles", indexes={@ORM\Index(name="IDX_28A007AAC6839A04", columns={"id_aplic"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\perfilesRepository")
 */
class perfiles
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
     * @return perfiles
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
     * @return perfiles
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
     * @return perfiles
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
     * @return perfiles
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
     * @return perfiles
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
}
