<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
