<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * areas
 *
 * @ORM\Table(name="elfec.areas")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\areasRepository")
 */
class areas
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id_area", type="decimal")
     */
    private $idArea;

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
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="id_padre", type="decimal")
     */
    private $idPadre;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_area", type="string", length=255)
     */
    private $nomArea;



    /**
     * Set idArea
     *
     * @param string $idArea
     * @return areas
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
     * Set loginUsr
     *
     * @param string $loginUsr
     * @return areas
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
     * @return areas
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
     * Set estado
     *
     * @param string $estado
     * @return areas
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
     * Set idPadre
     *
     * @param string $idPadre
     * @return areas
     */
    public function setIdPadre($idPadre)
    {
        $this->idPadre = $idPadre;

        return $this;
    }

    /**
     * Get idPadre
     *
     * @return string
     */
    public function getIdPadre()
    {
        return $this->idPadre;
    }

    /**
     * Set nomArea
     *
     * @param string $nomArea
     * @return areas
     */
    public function setNomArea($nomArea)
    {
        $this->nomArea = $nomArea;

        return $this;
    }

    /**
     * Get nomArea
     *
     * @return string
     */
    public function getNomArea()
    {
        return $this->nomArea;
    }
}
