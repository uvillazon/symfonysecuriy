<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.appUsr
 *
 * @ORM\Table(name="elfec.app_usr", indexes={@ORM\Index(name="IDX_93317539FCF8192D", columns={"id_usuario"}), @ORM\Index(name="IDX_93317539C6839A04", columns={"id_aplic"}), @ORM\Index(name="IDX_93317539B052C3AA", columns={"id_perfil"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\appUsrRepository")
 */
class appUsr
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_alta", type="date", nullable=true)
     */
    private $fchAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fch_baja", type="date", nullable=true)
     */
    private $fchBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10, nullable=false)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="id_usuario", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aplic", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $aplicacion;

    /**
     * @var \usuarios
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     * })
     */
    private $idUsuario;

    /**
     * @var \aplicaciones
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="aplicaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_aplic", referencedColumnName="id_aplic")
     * })
     */
    private $idAplic;

    /**
     * @var \perfiles
     *
     * @ORM\ManyToOne(targetEntity="perfiles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="id_perfil", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $perfil;



    /**
     * Set fchAlta
     *
     * @param \DateTime $fchAlta
     * @return appUsr
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
     * @return appUsr
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
     * @return appUsr
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
     * Set idUsuario
     *
     * @param \Elfec\SgauthBundle\Entity\usuarios $idUsuario
     * @return appUsr
     */
    public function setIdUsuario(\Elfec\SgauthBundle\Entity\usuarios $idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Elfec\SgauthBundle\Entity\usuarios 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set idAplic
     *
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $idAplic
     * @return appUsr
     */
    public function setIdAplic(\Elfec\SgauthBundle\Entity\aplicaciones $idAplic)
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
     * Set idPerfil
     *
     * @param \Elfec\SgauthBundle\Entity\perfiles $idPerfil
     * @return appUsr
     */
    public function setIdPerfil(\Elfec\SgauthBundle\Entity\perfiles $idPerfil = null)
    {
        $this->idPerfil = $idPerfil;

        return $this;
    }

    /**
     * Get idPerfil
     *
     * @return \Elfec\SgauthBundle\Entity\perfiles 
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }


    /**
     * Get usuario id
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    /**
     * Get aplicacion id
     *
     * @return string
     */
    public function getAplicacion()
    {
        return $this->aplicacion;
    }

    /**
     * Get perfil
     *
     * @return string
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}
