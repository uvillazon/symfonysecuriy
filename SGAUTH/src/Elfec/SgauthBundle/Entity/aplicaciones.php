<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.aplicaciones
 *
 * @ORM\Table(name="elfec.aplicaciones")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\aplicacionesRepository")
 */
class aplicaciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     */
    private $idAplic;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=20, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=70, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=250, nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_alta", type="datetime", nullable=true)
     */
    private $fchAlta = 'now()';

    /**
     * @var string
     *
     * @ORM\Column(name="bd_princ", type="string", length=50, nullable=true)
     */
    private $bdPrinc;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=false)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="bd_port", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $bdPort;

    /**
     * @var string
     *
     * @ORM\Column(name="bd_host", type="string", length=25, nullable=false)
     */
    private $bdHost;

    /**
     * @var string
     *
     * @ORM\Column(name="bd_drive", type="string", length=20, nullable=false)
     */
    private $bdDrive;

    /**
     * @var string
     *
     * @ORM\Column(name="app_host", type="string", length=350, nullable=false)
     */
    private $appHost;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string",  nullable=false)
     */
    private $secretKey;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo_valido_token", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $tiempoValidoToken;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_sesiones_permitidas", type="integer")
     */
    private $cantSesionesPermitidas;


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
     * Set codigo
     *
     * @param string $codigo
     * @return aplicaciones
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
     * Set nombre
     *
     * @param string $nombre
     * @return aplicaciones
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
     * @return aplicaciones
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
     * Set fchAlta
     *
     * @param \DateTime $fchAlta
     * @return aplicaciones
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
     * Set bdPrinc
     *
     * @param string $bdPrinc
     * @return aplicaciones
     */
    public function setBdPrinc($bdPrinc)
    {
        $this->bdPrinc = $bdPrinc;

        return $this;
    }

    /**
     * Get bdPrinc
     *
     * @return string
     */
    public function getBdPrinc()
    {
        return $this->bdPrinc;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return aplicaciones
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
     * Set bdPort
     *
     * @param string $bdPort
     * @return aplicaciones
     */
    public function setBdPort($bdPort)
    {
        $this->bdPort = $bdPort;

        return $this;
    }

    /**
     * Get bdPort
     *
     * @return string
     */
    public function getBdPort()
    {
        return $this->bdPort;
    }

    /**
     * Set bdHost
     *
     * @param string $bdHost
     * @return aplicaciones
     */
    public function setBdHost($bdHost)
    {
        $this->bdHost = $bdHost;

        return $this;
    }

    /**
     * Get bdHost
     *
     * @return string
     */
    public function getBdHost()
    {
        return $this->bdHost;
    }

    /**
     * Set bdDrive
     *
     * @param string $bdDrive
     * @return aplicaciones
     */
    public function setBdDrive($bdDrive)
    {
        $this->bdDrive = $bdDrive;

        return $this;
    }

    /**
     * Get bdDrive
     *
     * @return string
     */
    public function getBdDrive()
    {
        return $this->bdDrive;
    }

    /**
     * Set appHost
     *
     * @param string $appHost
     * @return aplicaciones
     */
    public function setAppHost($appHost)
    {
        $this->appHost = $appHost;

        return $this;
    }

    /**
     * Get appHost
     *
     * @return string
     */
    public function getAppHost()
    {
        return $this->appHost;
    }

    /**
     * Set secretKey
     *
     * @param string $appHost
     * @return aplicaciones
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Get secretKey
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Set idAplic
     *
     * @param string $idAplic
     * @return aplicaciones
     */
    public function setIdAplic($idAplic)
    {
        $this->idAplic = $idAplic;

        return $this;
    }

    /**
     * Set tiempoValidoToken
     *
     * @param string $tiempoValidoToken
     * @return aplicaciones
     */
    public function setTiempoValidoToken($tiempoValidoToken)
    {
        $this->tiempoValidoToken = $tiempoValidoToken;

        return $this;
    }

    /**
     * Get tiempoValidoToken
     *
     * @return string
     */
    public function getTiempoValidoToken()
    {
        return $this->tiempoValidoToken;
    }

    /**
     * Set cantSesionesPermitidas
     *
     * @param integer $cantSesionesPermitidas
     *
     * @return aplicaciones
     */
    public function setCantSesionesPermitidas($cantSesionesPermitidas)
    {
        $this->cantSesionesPermitidas = $cantSesionesPermitidas;

        return $this;
    }

    /**
     * Get cantSesionesPermitidas
     *
     * @return integer
     */
    public function getCantSesionesPermitidas()
    {
        return $this->cantSesionesPermitidas;
    }
}
