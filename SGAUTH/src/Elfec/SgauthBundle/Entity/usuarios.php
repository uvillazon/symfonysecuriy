<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * Elfec.usuarios
 *
 * @ORM\Table(name="elfec.usuarios")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\usuariosRepository")
 */
class usuarios
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_usuario", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.usuarios_id_usuario_seq", allocationSize=1, initialValue=1)
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=20, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=70, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=250, nullable=true)
     */
    private $clave;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_alta", type="date", nullable=true)
     */
    private $fchAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_baja", type="date", nullable=true)
     */
    private $fchBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="id_area", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idArea;

    /**
     * @var string
     *
     * @ORM\Column(name="cert_base64", type="text")
     * @Exclude
     */
    private $certBase64;

    /**
     * @var string
     *
     * @ORM\Column(name="cert_pwd_base64", type="text")
     * @Exclude
     */
    private $certPwdBase64;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_cert_caducidad", type="datetime", nullable=true)
     */
    private $fchCertCaducidad;

    /**
     * @var \areas
     *
     * @ORM\ManyToOne(targetEntity="areas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area", referencedColumnName="id_area")
     * })
     */
    private $area;

    public $tieneCertificado;

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
     * Set login
     *
     * @param string $login
     * @return usuarios
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return usuarios
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
     * Set clave
     *
     * @param string $clave
     * @return usuarios
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fchAlta
     *
     * @param \DateTime $fchAlta
     * @return usuarios
     */
    public function setFchAlta($fchAlta)
    {
        $this->fchAlta = $fchAlta;

        return $this;
    }

    /**
     * Get fchAlta
     *
     * @return \DateTime
     */
    public function getFchAlta()
    {
        return $this->fchAlta;
    }

    /**
     * Set fchBaja
     *
     * @param \DateTime $fchBaja
     * @return usuarios
     */
    public function setFchBaja($fchBaja)
    {
        $this->fchBaja = $fchBaja;

        return $this;
    }

    /**
     * Get fchBaja
     *
     * @return \DateTime
     */
    public function getFchBaja()
    {
        return $this->fchBaja;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return usuarios
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
     * Set idArea
     *
     * @param string $idArea
     * @return usuarios
     */
    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    
        return $this;
    }

    /**
     * Get idArea
     *
     * @return string 
     */
    public function getIdArea()
    {
        return $this->idArea;
    }

    /**
     * Set area
     *
     * @param \Elfec\SgauthBundle\Entity\areas $area
     * @return usuarios
     */
    public function setArea(\Elfec\SgauthBundle\Entity\areas $area = null)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return \Elfec\SgauthBundle\Entity\areas 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set certBase64
     *
     * @param string $certBase64
     *
     * @return usuarios
     */
    public function setCertBase64($certBase64)
    {
        $this->certBase64 = $certBase64;

        return $this;
    }

    /**
     * Get certBase64
     *
     * @return string
     */
    public function getCertBase64()
    {
        return $this->certBase64;
    }

    /**
     * Set certPwdBase64
     *
     * @param string $certPwdBase64
     *
     * @return usuarios
     */
    public function setCertPwdBase64($certPwdBase64)
    {
        $this->certPwdBase64 = $certPwdBase64;

        return $this;
    }

    /**
     * Get certPwdBase64
     *
     * @return string
     */
    public function getCertPwdBase64()
    {
        return $this->certPwdBase64;
    }

    /**
     * Set fchCertCaducidad
     *
     * @param \DateTime $fchCertCaducidad
     *
     * @return usuarios
     */
    public function setFchCertCaducidad($fchCertCaducidad)
    {
        $this->fchCertCaducidad = $fchCertCaducidad;

        return $this;
    }

    /**
     * Get fchCertCaducidad
     *
     * @return \DateTime
     */
    public function getFchCertCaducidad()
    {
        return $this->fchCertCaducidad;
    }
}
