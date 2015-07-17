<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.menuOpciones
 *
 * @ORM\Table(name="elfec.menu_opciones", indexes={@ORM\Index(name="IDX_FF25B574C6839A04", columns={"id_aplic"}), @ORM\Index(name="IDX_FF25B5743DE02BDB", columns={"id_padre"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\menuOpcionesRepository")
 */
class menuOpciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_opc", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.menu_opciones_id_opc_seq", allocationSize=1, initialValue=1)
     */
    private $idOpc;

    /**
     * @var string
     *
     * @ORM\Column(name="opcion", type="string", length=50, nullable=false)
     */
    private $opcion;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=100, nullable=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="tooltip", type="string", length=250, nullable=true)
     */
    private $tooltip;

    /**
     * @var string
     *
     * @ORM\Column(name="icono", type="string", length=50, nullable=true)
     */
    private $icono;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo", type="string", length=50, nullable=true)
     */
    private $estilo;

    /**
     * @var string
     *
     * @ORM\Column(name="orden", type="decimal", precision=2, scale=0, nullable=false)
     */
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=false)
     */
    private $estado;

    /**
     * @var \aplicaciones
     *
     * @ORM\ManyToOne(targetEntity="aplicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aplic", referencedColumnName="id_aplic")
     * })
     */
    private $idAplic;

    /**
     * @var \menuOpciones
     *
     * @ORM\ManyToOne(targetEntity="menuOpciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_padre", referencedColumnName="id_opc")
     * })
     */
    private $idPadre;



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
     * Set opcion
     *
     * @param string $opcion
     * @return menuOpciones
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return string 
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return menuOpciones
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set tooltip
     *
     * @param string $tooltip
     * @return menuOpciones
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
     * Set icono
     *
     * @param string $icono
     * @return menuOpciones
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
     * Set estilo
     *
     * @param string $estilo
     * @return menuOpciones
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
     * Set orden
     *
     * @param string $orden
     * @return menuOpciones
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
     * @return menuOpciones
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
     * Set idAplic
     *
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $idAplic
     * @return menuOpciones
     */
    public function setIdAplic(\Elfec\SgauthBundle\Entity\aplicaciones $idAplic = null)
    {
        $this->idAplic = $idAplic;

        return $this;
    }

    /**
     * Get idAplic
     *
     * @return \Elfec\SgauthBundle\Entity\aplicaciones 
     */
    public function getIdAplic()
    {
        return $this->idAplic;
    }

    /**
     * Set idPadre
     *
     * @param \Elfec\SgauthBundle\Entity\menuOpciones $idPadre
     * @return menuOpciones
     */
    public function setIdPadre(\Elfec\SgauthBundle\Entity\menuOpciones $idPadre = null)
    {
        $this->idPadre = $idPadre;

        return $this;
    }

    /**
     * Get idPadre
     *
     * @return \Elfec\SgauthBundle\Entity\menuOpciones 
     */
    public function getIdPadre()
    {
        return $this->idPadre;
    }
}
