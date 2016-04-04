<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * usuarioRecuperacion
 *
 * @ORM\Table(name="elfec.usuario_recuperacion")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\usuarioRecuperacionRepository")
 */
class usuarioRecuperacion
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id_usuario", type="decimal")
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal")
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=255)
     */
    private $clave;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_alta", type="date")
     */
    private $fchAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_baja", type="date")
     */
    private $fchBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;



    /**
     * Set idUsuario
     *
     * @param string $idUsuario
     * @return usuarioRecuperacion
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
     * @return usuarioRecuperacion
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
     * Set login
     *
     * @param string $login
     * @return usuarioRecuperacion
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
     * Set clave
     *
     * @param string $clave
     * @return usuarioRecuperacion
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
     * Set fchAlta
     *
     * @param \DateTime $fchAlta
     * @return usuarioRecuperacion
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
     * @return usuarioRecuperacion
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
     * @return usuarioRecuperacion
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
