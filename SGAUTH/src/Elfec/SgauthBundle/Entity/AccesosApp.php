<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * AccesosApp
 *
 * @ORM\Table(name="elfec.accesos_app")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Repository\AccesosAppRepository")
 */
class AccesosApp
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_usuario", type="decimal", precision=10, scale=0)
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0)
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="id_perfil", type="decimal", precision=10, scale=0)
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="origen", type="string", length=255)
     */
    private $origen;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente", type="string", length=255)
     */
    private $cliente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime")
     */
    private $fechaReg;

    /**
     * @var \perfiles
     * @Exclude
     * @ORM\ManyToOne(targetEntity="perfiles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $perfiles;

    /**
     * @var \usuarios
     * @Exclude
     * @ORM\ManyToOne(targetEntity="usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $usuarios;

    /**
     * @var \aplicaciones
     * @Exclude
     * @ORM\ManyToOne(targetEntity="aplicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aplic", referencedColumnName="id_aplic")
     * })
     */
    private $aplicaciones;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUsuario
     *
     * @param string $idUsuario
     *
     * @return AccesosApp
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return string
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set idAplic
     *
     * @param string $idAplic
     *
     * @return AccesosApp
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
     * Set ip
     *
     * @param string $ip
     *
     * @return AccesosApp
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     *
     * @return AccesosApp
     */
    public function setFechaReg($fechaReg)
    {
        $this->fechaReg = $fechaReg;

        return $this;
    }

    /**
     * Get fechaReg
     *
     * @return \DateTime
     */
    public function getFechaReg()
    {
        return $this->fechaReg;
    }

    /**
     * Set origen
     *
     * @param string $origen
     *
     * @return AccesosApp
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     *
     * @return AccesosApp
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set idPerfil
     *
     * @param string $idPerfil
     *
     * @return AccesosApp
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;

        return $this;
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
     * Set perfiles
     *
     * @param \Elfec\SgauthBundle\Entity\perfiles $perfiles
     *
     * @return AccesosApp
     */
    public function setPerfiles(\Elfec\SgauthBundle\Entity\perfiles $perfiles = null)
    {
        $this->perfiles = $perfiles;

        return $this;
    }

    /**
     * Get perfiles
     *
     * @return \Elfec\SgauthBundle\Entity\perfiles
     */
    public function getPerfiles()
    {
        return $this->perfiles;
    }

    /**
     * Set usuarios
     *
     * @param \Elfec\SgauthBundle\Entity\usuarios $usuarios
     *
     * @return AccesosApp
     */
    public function setUsuarios(\Elfec\SgauthBundle\Entity\usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \Elfec\SgauthBundle\Entity\usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set aplicaciones
     *
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $aplicaciones
     *
     * @return AccesosApp
     */
    public function setAplicaciones(\Elfec\SgauthBundle\Entity\aplicaciones $aplicaciones = null)
    {
        $this->aplicaciones = $aplicaciones;

        return $this;
    }

    /**
     * Get aplicaciones
     *
     * @return \Elfec\SgauthBundle\Entity\aplicaciones
     */
    public function getAplicaciones()
    {
        return $this->aplicaciones;
    }
}
