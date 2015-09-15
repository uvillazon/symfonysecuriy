<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.botones
 *
 * @ORM\Table(name="elfec.botones", indexes={@ORM\Index(name="IDX_2E1E485B3DE02BDB", columns={"id_padre"}), @ORM\Index(name="IDX_2E1E485BD9EAF441", columns={"id_opc"})})
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\botonesRepository")
 */
class botones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_boton", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.botones_id_boton_seq", allocationSize=1, initialValue=1)
     */
    private $idBoton;

    /**
     * @var string
     *
     * @ORM\Column(name="boton", type="string", length=100, nullable=false)
     */
    private $boton;

    /**
     * @var string
     *
     * @ORM\Column(name="tooltip", type="string", length=350, nullable=true)
     */
    private $tooltip;

    /**
     * @var string
     *
     * @ORM\Column(name="id_item", type="string", length=100, nullable=false)
     */
    private $idItem;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo", type="string", length=100, nullable=true)
     */
    private $estilo;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=100, nullable=true)
     */
    private $accion;

    /**
     * @var string
     *
     * @ORM\Column(name="icono", type="string", length=250, nullable=true)
     */
    private $icono;

    /**
     * @var string
     *
     * @ORM\Column(name="orden", type="decimal", precision=2, scale=0, nullable=true)
     */
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=false)
     */
    private $estado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=false)
     */
    private $disabled;

    /**
     * @var \botones
     *
     * @ORM\ManyToOne(targetEntity="botones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_padre", referencedColumnName="id_boton")
     * })
     */
    private $padre;

    /**
     * @var \menuOpciones
     *
     * @ORM\ManyToOne(targetEntity="menuOpciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_opc", referencedColumnName="id_opc")
     * })
     */
    private $menuOpciones;

    /**
     * @var string
     *
     * @ORM\Column(name="id_padre", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idPadre;

    /**
     * @var string
     *
     * @ORM\Column(name="id_opc", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $idOpc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="perfiles", mappedBy="botones")
     */
    private $idPerfil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPerfil = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get idBoton
     *
     * @return string
     */
    public function getIdBoton()
    {
        return $this->idBoton;
    }

    /**
     * Set boton
     *
     * @param string $boton
     * @return botones
     */
    public function setBoton($boton)
    {
        $this->boton = $boton;

        return $this;
    }

    /**
     * Get boton
     *
     * @return string
     */
    public function getBoton()
    {
        return $this->boton;
    }

    /**
     * Set tooltip
     *
     * @param string $tooltip
     * @return botones
     */
    public function setTooltip($tooltip)
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    /**
     * Get tooltip
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Set idItem
     *
     * @param string $idItem
     * @return botones
     */
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get idItem
     *
     * @return string
     */
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * Set estilo
     *
     * @param string $estilo
     * @return botones
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;

        return $this;
    }

    /**
     * Get estilo
     *
     * @return string
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     * Set accion
     *
     * @param string $accion
     * @return botones
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set icono
     *
     * @param string $icono
     * @return botones
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;

        return $this;
    }

    /**
     * Get icono
     *
     * @return string
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * Set orden
     *
     * @param string $orden
     * @return botones
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return string
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return botones
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
     * @return botones
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
     * Set idOpc
     *
     * @param string $idOpc
     * @return botones
     */
    public function setIdOpc($idOpc)
    {
        $this->idOpc = $idOpc;

        return $this;
    }

    /**
     * Get idOpc
     *
     * @return string
     */
    public function getIdOpc()
    {
        return $this->idOpc;
    }

    /**
     * Set padre
     *
     * @param \Elfec\SgauthBundle\Entity\botones $padre
     * @return botones
     */
    public function setPadre(\Elfec\SgauthBundle\Entity\botones $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \Elfec\SgauthBundle\Entity\botones
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set menuOpciones
     *
     * @param \Elfec\SgauthBundle\Entity\menuOpciones $menuOpciones
     * @return botones
     */
    public function setMenuOpciones(\Elfec\SgauthBundle\Entity\menuOpciones $menuOpciones = null)
    {
        $this->menuOpciones = $menuOpciones;

        return $this;
    }

    /**
     * Get menuOpciones
     *
     * @return \Elfec\SgauthBundle\Entity\menuOpciones
     */
    public function getMenuOpciones()
    {
        return $this->menuOpciones;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     * @return botones
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }
}
