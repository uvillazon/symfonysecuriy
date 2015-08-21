<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.perfilesBotones
 *
 * @ORM\Table(name="elfec.perfiles_botones")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\perfilesBotonesRepository")
 */
class perfilesBotones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_perfil", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="id_boton", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idBoton;

    /**
     * @var \perfiles
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="perfiles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $perfiles;

    /**
     * @var \botones
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="botones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_boton", referencedColumnName="id_boton")
     * })
     */
    private $botones;


    /**
     * Set idPerfil
     *
     * @param string $idPerfil
     * @return perfilesBotones
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;

        return $this;
    }

    /**
     * Get idPerfil
     *
     * @return string 
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set idBoton
     *
     * @param string $idBoton
     * @return perfilesBotones
     */
    public function setIdBoton($idBoton)
    {
        $this->idBoton = $idBoton;

        return $this;
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
     * Set perfiles
     *
     * @param \Elfec\SgauthBundle\Entity\perfiles $perfiles
     * @return perfilesBotones
     */
    public function setPerfiles(\Elfec\SgauthBundle\Entity\perfiles $perfiles)
    {
        $this->perfiles = $perfiles;

        return $this;
    }

    /**
     * Get perfiles
     *
     * @return \Elfec\SgauthBundle\Entity\perfiles 
     */
    public function getPerfiles()
    {
        return $this->perfiles;
    }

    /**
     * Set botones
     *
     * @param \Elfec\SgauthBundle\Entity\botones $botones
     * @return perfilesBotones
     */
    public function setBotones(\Elfec\SgauthBundle\Entity\botones $botones)
    {
        $this->botones = $botones;

        return $this;
    }

    /**
     * Get botones
     *
     * @return \Elfec\SgauthBundle\Entity\botones 
     */
    public function getBotones()
    {
        return $this->botones;
    }
}
