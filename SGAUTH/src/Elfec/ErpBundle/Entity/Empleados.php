<?php

namespace Elfec\ErpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleados
 *
 * @ORM\Table(name="erp_elfec.empleados")
 * @ORM\Entity(repositoryClass="Elfec\ErpBundle\Repository\EmpleadosRepository")
 */
class Empleados
{


    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="idempleado", type="decimal", precision=10, scale=0)
     */
    private $idempleado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fechaAlta;

    /**
     * @var string
     *
     * @ORM\Column(name="idsector", type="decimal", precision=10, scale=0)
     */
    private $idsector;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=4000)
     */
    private $observaciones;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="aud_fecha", type="datetime")
     */
    private $audFecha;

    /**
     * @var string
     *
     * @ORM\Column(name="aud_usuario", type="decimal", precision=10, scale=0)
     */
    private $audUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="aud_accion", type="decimal", precision=10, scale=0)
     */
    private $audAccion;



    /**
     * Set idempleado
     *
     * @param string $idempleado
     *
     * @return Empleados
     */
    public function setIdempleado($idempleado)
    {
        $this->idempleado = $idempleado;

        return $this;
    }

    /**
     * Get idempleado
     *
     * @return string
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Empleados
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
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Empleados
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set idsector
     *
     * @param string $idsector
     *
     * @return Empleados
     */
    public function setIdsector($idsector)
    {
        $this->idsector = $idsector;

        return $this;
    }

    /**
     * Get idsector
     *
     * @return string
     */
    public function getIdsector()
    {
        return $this->idsector;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Empleados
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set audFecha
     *
     * @param \DateTime $audFecha
     *
     * @return Empleados
     */
    public function setAudFecha($audFecha)
    {
        $this->audFecha = $audFecha;

        return $this;
    }

    /**
     * Get audFecha
     *
     * @return \DateTime
     */
    public function getAudFecha()
    {
        return $this->audFecha;
    }

    /**
     * Set audUsuario
     *
     * @param string $audUsuario
     *
     * @return Empleados
     */
    public function setAudUsuario($audUsuario)
    {
        $this->audUsuario = $audUsuario;

        return $this;
    }

    /**
     * Get audUsuario
     *
     * @return string
     */
    public function getAudUsuario()
    {
        return $this->audUsuario;
    }

    /**
     * Set audAccion
     *
     * @param string $audAccion
     *
     * @return Empleados
     */
    public function setAudAccion($audAccion)
    {
        $this->audAccion = $audAccion;

        return $this;
    }

    /**
     * Get audAccion
     *
     * @return string
     */
    public function getAudAccion()
    {
        return $this->audAccion;
    }
}

