<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * usuariosAreas
 *
 * @ORM\Table(name="elfec.usuarios_areas")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\usuariosAreasRepository")
 */
class usuariosAreas
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id_usr_area", type="decimal")
     */
    private $idUsrArea;

    /**
     * @var string
     *
     * @ORM\Column(name="login_usr", type="string", length=255)
     */
    private $loginUsr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime")
     */
    private $fechaReg;

    /**
     * @var string
     *
     * @ORM\Column(name="id_usuario", type="decimal")
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="id_area", type="decimal")
     */
    private $idArea;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal")
     */
    private $idAplic;

    /**
     * @var \areas
     *
     * @ORM\ManyToOne(targetEntity="areas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area", referencedColumnName="id_area")
     * })
     */
    private $area;

    /**
     * @var \usuarios
     *
     * @ORM\ManyToOne(targetEntity="usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $usuario;


    /**
     * Set idUsrArea
     *
     * @param string $idUsrArea
     * @return usuariosAreas
     */
    public function setIdUsrArea($idUsrArea)
    {
        $this->idUsrArea = $idUsrArea;

        return $this;
    }

    /**
     * Get idUsrArea
     *
     * @return string
     */
    public function getIdUsrArea()
    {
        return $this->idUsrArea;
    }

    /**
     * Set loginUsr
     *
     * @param string $loginUsr
     * @return usuariosAreas
     */
    public function setLoginUsr($loginUsr)
    {
        $this->loginUsr = $loginUsr;

        return $this;
    }

    /**
     * Get loginUsr
     *
     * @return string
     */
    public function getLoginUsr()
    {
        return $this->loginUsr;
    }

    /**
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     * @return usuariosAreas
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
     * Set idUsuario
     *
     * @param string $idUsuario
     * @return usuariosAreas
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
     * Set idArea
     *
     * @param string $idArea
     * @return usuariosAreas
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
     * Set idAplic
     *
     * @param string $idAplic
     * @return usuariosAreas
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
     * Set area
     *
     * @param \Elfec\SgauthBundle\Entity\areas $area
     * @return usuariosAreas
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
     * Set usuario
     *
     * @param \Elfec\SgauthBundle\Entity\usuarios $usuario
     * @return usuariosAreas
     */
    public function setUsuario(\Elfec\SgauthBundle\Entity\usuarios $usuario = null)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Elfec\SgauthBundle\Entity\usuarios 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
