<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistEdicionDatos
 *
 * @ORM\Table(name="hist_edicion_datos")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\histEdicionDatosRepository")
 */
class histEdicionDatos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_hist", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="hist_edicion_datos_id_hist_seq", allocationSize=1, initialValue=1)
     */
    private $idHist;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dato", type="bigint", nullable=false)
     */
    private $idDato;

    /**
     * @var string
     *
     * @ORM\Column(name="tabla", type="string", length=50, nullable=false)
     */
    private $tabla;

    /**
     * @var string
     *
     * @ORM\Column(name="campo", type="string", length=50, nullable=true)
     */
    private $campo;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_antiguo", type="string", length=255, nullable=true)
     */
    private $valorAntiguo;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_nuevo", type="string", length=255, nullable=false)
     */
    private $valorNuevo;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="string", length=50, nullable=true)
     */
    private $motivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime", nullable=false)
     */
    private $fechaReg;

    /**
     * @var string
     *
     * @ORM\Column(name="login_usr", type="string", length=20, nullable=true)
     */
    private $loginUsr;



    /**
     * Get idHist
     *
     * @return integer 
     */
    public function getIdHist()
    {
        return $this->idHist;
    }

    /**
     * Set idDato
     *
     * @param integer $idDato
     * @return HistEdicionDatos
     */
    public function setIdDato($idDato)
    {
        $this->idDato = $idDato;

        return $this;
    }

    /**
     * Get idDato
     *
     * @return integer 
     */
    public function getIdDato()
    {
        return $this->idDato;
    }

    /**
     * Set tabla
     *
     * @param string $tabla
     * @return HistEdicionDatos
     */
    public function setTabla($tabla)
    {
        $this->tabla = $tabla;

        return $this;
    }

    /**
     * Get tabla
     *
     * @return string 
     */
    public function getTabla()
    {
        return $this->tabla;
    }

    /**
     * Set campo
     *
     * @param string $campo
     * @return HistEdicionDatos
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;

        return $this;
    }

    /**
     * Get campo
     *
     * @return string 
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * Set valorAntiguo
     *
     * @param string $valorAntiguo
     * @return HistEdicionDatos
     */
    public function setValorAntiguo($valorAntiguo)
    {
        $this->valorAntiguo = $valorAntiguo;

        return $this;
    }

    /**
     * Get valorAntiguo
     *
     * @return string 
     */
    public function getValorAntiguo()
    {
        return $this->valorAntiguo;
    }

    /**
     * Set valorNuevo
     *
     * @param string $valorNuevo
     * @return HistEdicionDatos
     */
    public function setValorNuevo($valorNuevo)
    {
        $this->valorNuevo = $valorNuevo;

        return $this;
    }

    /**
     * Get valorNuevo
     *
     * @return string 
     */
    public function getValorNuevo()
    {
        return $this->valorNuevo;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return HistEdicionDatos
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     * @return HistEdicionDatos
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
     * @return HistEdicionDatos
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
