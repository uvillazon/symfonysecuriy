<?php

namespace Elfec\SgauthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sessiones
 *
 * @ORM\Table(name="elfec.sessiones")
 * @ORM\Entity(repositoryClass="Elfec\SgauthBundle\Repository\SessionesRepository")
 */
class Sessiones
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=255)
     */
    private $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_id", type="decimal", precision=10, scale=0)
     */
    private $usuarioId;

    /**
     * @var string
     *
     * @ORM\Column(name="perfil_id", type="decimal", precision=10, scale=0)
     */
    private $perfilId;

    /**
     * @var string
     *
     * @ORM\Column(name="aplic_id", type="decimal", precision=10, scale=0)
     */
    private $aplicId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime")
     */
    private $fechaReg;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     *
     * @return Sessiones
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set usuarioId
     *
     * @param string $usuarioId
     *
     * @return Sessiones
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return string
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set perfilId
     *
     * @param string $perfilId
     *
     * @return Sessiones
     */
    public function setPerfilId($perfilId)
    {
        $this->perfilId = $perfilId;

        return $this;
    }

    /**
     * Get perfilId
     *
     * @return string
     */
    public function getPerfilId()
    {
        return $this->perfilId;
    }

    /**
     * Set aplicId
     *
     * @param string $aplicId
     *
     * @return Sessiones
     */
    public function setAplicId($aplicId)
    {
        $this->aplicId = $aplicId;

        return $this;
    }

    /**
     * Get aplicId
     *
     * @return string
     */
    public function getAplicId()
    {
        return $this->aplicId;
    }

    /**
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     *
     * @return Sessiones
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
}

