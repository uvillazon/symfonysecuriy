<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * recuperacionCnt
 *
 * @ORM\Table(name="elfec.recuperacion_cnt")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\recuperacionCntRepository")
 */
class recuperacionCnt
{


    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal")
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=20)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_exp", type="datetime")
     */
    private $fechaExp;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_solic", type="string", length=50)
     */
    private $ipSolic;

    /**
     * @var string
     *
     * @ORM\Column(name="cliente_solic", type="string", length=1000)
     */
    private $clienteSolic;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;


    /**
     * Set codigo
     *
     * @param string $codigo
     * @return recuperacionCnt
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set idAplic
     *
     * @param string $idAplic
     * @return recuperacionCnt
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
     * Set usuario
     *
     * @param string $usuario
     * @return recuperacionCnt
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return recuperacionCnt
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
     * Set fechaExp
     *
     * @param \DateTime $fechaExp
     * @return recuperacionCnt
     */
    public function setFechaExp($fechaExp)
    {
        $this->fechaExp = $fechaExp;
    
        return $this;
    }

    /**
     * Get fechaExp
     *
     * @return \DateTime 
     */
    public function getFechaExp()
    {
        return $this->fechaExp;
    }

    /**
     * Set ipSolic
     *
     * @param string $ipSolic
     * @return recuperacionCnt
     */
    public function setIpSolic($ipSolic)
    {
        $this->ipSolic = $ipSolic;
    
        return $this;
    }

    /**
     * Get ipSolic
     *
     * @return string 
     */
    public function getIpSolic()
    {
        return $this->ipSolic;
    }

    /**
     * Set clienteSolic
     *
     * @param string $clienteSolic
     * @return recuperacionCnt
     */
    public function setClienteSolic($clienteSolic)
    {
        $this->clienteSolic = $clienteSolic;
    
        return $this;
    }

    /**
     * Get clienteSolic
     *
     * @return string 
     */
    public function getClienteSolic()
    {
        return $this->clienteSolic;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return recuperacionCnt
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
