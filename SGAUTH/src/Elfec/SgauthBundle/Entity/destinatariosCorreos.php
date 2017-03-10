<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * destinatariosCorreos
 *
 * @ORM\Table(name="elfec.destinatarios_correos")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\destinatariosCorreosRepository")
 */
class destinatariosCorreos
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id_dest", type="integer")
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.q_destinatarios_correos", allocationSize=1, initialValue=1)
     */
    private $idDest;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=50)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime")
     */
    private $fechaReg;

    /**
     * @var string
     *
     * @ORM\Column(name="login_usr", type="string", length=15)
     */
    private $loginUsr;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="gruposDestCorreo", mappedBy="destinatarioCorreo")
     */
    private $gruposDestCorreos;

    public function __construct() {
        $this->gruposDestCorreos = new ArrayCollection();
    }




    /**
     * Set idDest
     *
     * @param integer $idDest
     * @return destinatariosCorreos
     */
    public function setIdDest($idDest)
    {
        $this->idDest = $idDest;
    
        return $this;
    }

    /**
     * Get idDest
     *
     * @return integer 
     */
    public function getIdDest()
    {
        return $this->idDest;
    }

    /**
     * Set id_aplic
     *
     * @param string $idAplic
     * @return destinatariosCorreos
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
     * Set correo
     *
     * @param string $correo
     * @return destinatariosCorreos
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    
        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return destinatariosCorreos
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
     * Set apellido
     *
     * @param string $apellido
     * @return destinatariosCorreos
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return destinatariosCorreos
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
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     * @return destinatariosCorreos
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
     * Set loginUsr
     *
     * @param string $loginUsr
     * @return destinatariosCorreos
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
}
