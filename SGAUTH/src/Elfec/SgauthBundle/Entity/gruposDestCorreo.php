<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * gruposDestCorreo
 *
 * @ORM\Table(name="elfec.grupos_dest_correo")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Entity\Repository\gruposDestCorreoRepository")
 */
class gruposDestCorreo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="elfec.q_grupos_dest_correo", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_grp", type="integer")
     */
    private $idGrp;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dest", type="integer")
     */
    private $idDest;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_msg_dest", type="string", length=255)
     */
    private $tipoMsgDest;


    /**
     * @var \gruposCorreos
     *
     * @ORM\ManyToOne(targetEntity="gruposCorreos" ,inversedBy="gruposDestCorreos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_grp", referencedColumnName="id_grp")
     * })
     */
    private $grupoCorreo;


    /**
     * @var \destinatariosCorreos
     *
     * @ORM\ManyToOne(targetEntity="destinatariosCorreos" , inversedBy="gruposDestCorreos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dest", referencedColumnName="id_dest")
     * })
     */
    private $destinatarioCorreo;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idGrp
     *
     * @param integer $idGrp
     * @return gruposDestCorreo
     */
    public function setIdGrp($idGrp)
    {
        $this->idGrp = $idGrp;
    
        return $this;
    }

    /**
     * Get idGrp
     *
     * @return integer 
     */
    public function getIdGrp()
    {
        return $this->idGrp;
    }

    /**
     * Set idDest
     *
     * @param integer $idDest
     * @return gruposDestCorreo
     */
    public function setIdDest($idDest)
    {
        $this->idDest = $idDest;
    
        return $this;
    }

    /**
     * Get idDest
     *
     * @return integer 
     */
    public function getIdDest()
    {
        return $this->idDest;
    }

    /**
     * Set tipoMsgDest
     *
     * @param string $tipoMsgDest
     * @return gruposDestCorreo
     */
    public function setTipoMsgDest($tipoMsgDest)
    {
        $this->tipoMsgDest = $tipoMsgDest;
    
        return $this;
    }

    /**
     * Get tipoMsgDest
     *
     * @return string 
     */
    public function getTipoMsgDest()
    {
        return $this->tipoMsgDest;
    }

    /**
     * Set grupoCorreo
     *
     * @param \Elfec\SgauthBundle\Entity\gruposCorreos $obj
     * @return gruposDestCorreo
     */
    public function setGrupoCorreo(\Elfec\SgauthBundle\Entity\gruposCorreos $obj = null)
    {
        $this->grupoCorreo = $obj;

        return $this;
    }

    /**
     * Get grupoCorreo
     *
     * @return \Elfec\SgauthBundle\Entity\gruposCorreos
     */
    public function getGrupoCorreo()
    {
        return $this->grupoCorreo;
    }

    /**
     * Set destinatarioCorreo
     *
     * @param \Elfec\SgauthBundle\Entity\destinatariosCorreos $obj
     * @return gruposDestCorreo
     */
    public function setDestinatarioCorreo(\Elfec\SgauthBundle\Entity\destinatariosCorreos $obj = null)
    {
        $this->destinatarioCorreo = $obj;

        return $this;
    }

    /**
     * Get destinatarioCorreo
     *
     * @return \Elfec\SgauthBundle\Entity\destinatariosCorreos
     */
    public function getDestinatarioCorreo()
    {
        return $this->destinatarioCorreo;
    }
}
