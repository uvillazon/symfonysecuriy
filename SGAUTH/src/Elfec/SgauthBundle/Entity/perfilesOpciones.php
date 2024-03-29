<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elfec.perfilesOpciones
 *
 * @ORM\Table(name="elfec.perfiles_opciones", indexes={@ORM\Index(name="IDX_93927BB8B052C3AA", columns={"id_perfil"}), @ORM\Index(name="IDX_93927BB8D9EAF441", columns={"id_opc"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\perfilesOpcionesRepository")
 */
class perfilesOpciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_prf_opc", type="decimal", precision=10, scale=0, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.perfiles_opciones_id_prf_opc_seq", allocationSize=1, initialValue=1)
     */
    private $idPrfOpc;


    /**
     * @var string
     *
     * @ORM\Column(name="id_perfil", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $perfil;

    /**
     * @var string
     *
     * @ORM\Column(name="id_opc", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $opcion;


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
     * @var \menuOpciones
     *
     * @ORM\ManyToOne(targetEntity="menuOpciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_opc", referencedColumnName="id_opc")
     * })
     */
    private $idOpc;



    /**
     * Get idPrfOpc
     *
     * @return string 
     */
    public function getIdPrfOpc()
    {
        return $this->idPrfOpc;
    }

    /**
     * Set idPerfil
     *
     * @param \Elfec\SgauthBundle\Entity\perfiles $idPerfil
     * @return perfilesOpciones
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
     * Set idOpc
     *
     * @param \Elfec\SgauthBundle\Entity\menuOpciones $idOpc
     * @return perfilesOpciones
     */
    public function setIdOpc(\Elfec\SgauthBundle\Entity\menuOpciones $idOpc = null)
    {
        $this->idOpc = $idOpc;

        return $this;
    }

    /**
     * Get idOpc
     *
     * @return \Elfec\SgauthBundle\Entity\menuOpciones 
     */
    public function getIdOpc()
    {
        return $this->idOpc;
    }
}
