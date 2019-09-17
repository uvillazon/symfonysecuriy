<?php

namespace Elfec\ErpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedores
 *
 * @ORM\Table(name="erp_elfec.proveedores")
 * @ORM\Entity(repositoryClass="Elfec\ErpBundle\Repository\ProveedoresRepository")
 */
class Proveedores
{


    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="idproveedor", type="decimal", precision=10, scale=0)
     */
    private $idproveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fechaAlta;

    /**
     * @var string
     *
     * @ORM\Column(name="idstatus", type="decimal", precision=10, scale=0)
     */
    private $idstatus;

    /**
     * @var string
     *
     * @ORM\Column(name="idtipo_prov", type="decimal", precision=10, scale=0)
     */
    private $idtipoProv;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="calle_nro", type="decimal", precision=10, scale=0)
     */
    private $calleNro;

    /**
     * @var string
     *
     * @ORM\Column(name="depto", type="string", length=255)
     */
    private $depto;

    /**
     * @var string
     *
     * @ORM\Column(name="piso", type="string", length=255)
     */
    private $piso;

    /**
     * @var string
     *
     * @ORM\Column(name="idcodpostal", type="string", length=255)
     */
    private $idcodpostal;

    /**
     * @var string
     *
     * @ORM\Column(name="idlocalidad", type="decimal", precision=10, scale=0)
     */
    private $idlocalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="idprovincia", type="decimal", precision=10, scale=0)
     */
    private $idprovincia;

    /**
     * @var string
     *
     * @ORM\Column(name="idpais", type="decimal", precision=10, scale=0)
     */
    private $idpais;

    /**
     * @var string
     *
     * @ORM\Column(name="entre_calles", type="string", length=255)
     */
    private $entreCalles;

    /**
     * @var string
     *
     * @ORM\Column(name="cheques_orden", type="string", length=255)
     */
    private $chequesOrden;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="idtipoiva", type="decimal", precision=10, scale=0)
     */
    private $idtipoiva;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_cuit", type="decimal", precision=10, scale=0)
     */
    private $nroCuit;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_ingbrutos", type="decimal", precision=10, scale=0)
     */
    private $nroIngbrutos;

    /**
     * @var string
     *
     * @ORM\Column(name="idcateg_ganancias", type="decimal", precision=10, scale=0)
     */
    private $idcategGanancias;

    /**
     * @var string
     *
     * @ORM\Column(name="retener_ganancias", type="decimal", precision=10, scale=0)
     */
    private $retenerGanancias;

    /**
     * @var string
     *
     * @ORM\Column(name="retener_iva", type="decimal", precision=10, scale=0)
     */
    private $retenerIva;

    /**
     * @var string
     *
     * @ORM\Column(name="idcateg_iva", type="decimal", precision=10, scale=0)
     */
    private $idcategIva;

    /**
     * @var string
     *
     * @ORM\Column(name="retener_ingbrut", type="decimal", precision=10, scale=0)
     */
    private $retenerIngbrut;

    /**
     * @var string
     *
     * @ORM\Column(name="idcateg_ingbrut", type="decimal", precision=10, scale=0)
     */
    private $idcategIngbrut;

    /**
     * @var string
     *
     * @ORM\Column(name="idtipo_prov_categ", type="decimal", precision=10, scale=0)
     */
    private $idtipoProvCateg;

    /**
     * @var string
     *
     * @ORM\Column(name="es_nohabitual", type="decimal", precision=10, scale=0)
     */
    private $esNohabitual;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_fantasia", type="string", length=255)
     */
    private $nombreFantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="nroid_tributaria", type="decimal", precision=10, scale=0)
     */
    private $nroidTributaria;


    /**
     * Set idproveedor
     *
     * @param string $idproveedor
     *
     * @return Proveedores
     */
    public function setIdproveedor($idproveedor)
    {
        $this->idproveedor = $idproveedor;

        return $this;
    }

    /**
     * Get idproveedor
     *
     * @return string
     */
    public function getIdproveedor()
    {
        return $this->idproveedor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Proveedores
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Proveedores
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
     * Set idstatus
     *
     * @param string $idstatus
     *
     * @return Proveedores
     */
    public function setIdstatus($idstatus)
    {
        $this->idstatus = $idstatus;

        return $this;
    }

    /**
     * Get idstatus
     *
     * @return string
     */
    public function getIdstatus()
    {
        return $this->idstatus;
    }

    /**
     * Set idtipoProv
     *
     * @param string $idtipoProv
     *
     * @return Proveedores
     */
    public function setIdtipoProv($idtipoProv)
    {
        $this->idtipoProv = $idtipoProv;

        return $this;
    }

    /**
     * Get idtipoProv
     *
     * @return string
     */
    public function getIdtipoProv()
    {
        return $this->idtipoProv;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Proveedores
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set calleNro
     *
     * @param string $calleNro
     *
     * @return Proveedores
     */
    public function setCalleNro($calleNro)
    {
        $this->calleNro = $calleNro;

        return $this;
    }

    /**
     * Get calleNro
     *
     * @return string
     */
    public function getCalleNro()
    {
        return $this->calleNro;
    }

    /**
     * Set depto
     *
     * @param string $depto
     *
     * @return Proveedores
     */
    public function setDepto($depto)
    {
        $this->depto = $depto;

        return $this;
    }

    /**
     * Get depto
     *
     * @return string
     */
    public function getDepto()
    {
        return $this->depto;
    }

    /**
     * Set piso
     *
     * @param string $piso
     *
     * @return Proveedores
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return string
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set idcodpostal
     *
     * @param string $idcodpostal
     *
     * @return Proveedores
     */
    public function setIdcodpostal($idcodpostal)
    {
        $this->idcodpostal = $idcodpostal;

        return $this;
    }

    /**
     * Get idcodpostal
     *
     * @return string
     */
    public function getIdcodpostal()
    {
        return $this->idcodpostal;
    }

    /**
     * Set idlocalidad
     *
     * @param string $idlocalidad
     *
     * @return Proveedores
     */
    public function setIdlocalidad($idlocalidad)
    {
        $this->idlocalidad = $idlocalidad;

        return $this;
    }

    /**
     * Get idlocalidad
     *
     * @return string
     */
    public function getIdlocalidad()
    {
        return $this->idlocalidad;
    }

    /**
     * Set idprovincia
     *
     * @param string $idprovincia
     *
     * @return Proveedores
     */
    public function setIdprovincia($idprovincia)
    {
        $this->idprovincia = $idprovincia;

        return $this;
    }

    /**
     * Get idprovincia
     *
     * @return string
     */
    public function getIdprovincia()
    {
        return $this->idprovincia;
    }

    /**
     * Set idpais
     *
     * @param string $idpais
     *
     * @return Proveedores
     */
    public function setIdpais($idpais)
    {
        $this->idpais = $idpais;

        return $this;
    }

    /**
     * Get idpais
     *
     * @return string
     */
    public function getIdpais()
    {
        return $this->idpais;
    }

    /**
     * Set entreCalles
     *
     * @param string $entreCalles
     *
     * @return Proveedores
     */
    public function setEntreCalles($entreCalles)
    {
        $this->entreCalles = $entreCalles;

        return $this;
    }

    /**
     * Get entreCalles
     *
     * @return string
     */
    public function getEntreCalles()
    {
        return $this->entreCalles;
    }

    /**
     * Set chequesOrden
     *
     * @param string $chequesOrden
     *
     * @return Proveedores
     */
    public function setChequesOrden($chequesOrden)
    {
        $this->chequesOrden = $chequesOrden;

        return $this;
    }

    /**
     * Get chequesOrden
     *
     * @return string
     */
    public function getChequesOrden()
    {
        return $this->chequesOrden;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Proveedores
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set idtipoiva
     *
     * @param string $idtipoiva
     *
     * @return Proveedores
     */
    public function setIdtipoiva($idtipoiva)
    {
        $this->idtipoiva = $idtipoiva;

        return $this;
    }

    /**
     * Get idtipoiva
     *
     * @return string
     */
    public function getIdtipoiva()
    {
        return $this->idtipoiva;
    }

    /**
     * Set nroCuit
     *
     * @param string $nroCuit
     *
     * @return Proveedores
     */
    public function setNroCuit($nroCuit)
    {
        $this->nroCuit = $nroCuit;

        return $this;
    }

    /**
     * Get nroCuit
     *
     * @return string
     */
    public function getNroCuit()
    {
        return $this->nroCuit;
    }

    /**
     * Set nroIngbrutos
     *
     * @param string $nroIngbrutos
     *
     * @return Proveedores
     */
    public function setNroIngbrutos($nroIngbrutos)
    {
        $this->nroIngbrutos = $nroIngbrutos;

        return $this;
    }

    /**
     * Get nroIngbrutos
     *
     * @return string
     */
    public function getNroIngbrutos()
    {
        return $this->nroIngbrutos;
    }

    /**
     * Set idcategGanancias
     *
     * @param string $idcategGanancias
     *
     * @return Proveedores
     */
    public function setIdcategGanancias($idcategGanancias)
    {
        $this->idcategGanancias = $idcategGanancias;

        return $this;
    }

    /**
     * Get idcategGanancias
     *
     * @return string
     */
    public function getIdcategGanancias()
    {
        return $this->idcategGanancias;
    }

    /**
     * Set retenerGanancias
     *
     * @param string $retenerGanancias
     *
     * @return Proveedores
     */
    public function setRetenerGanancias($retenerGanancias)
    {
        $this->retenerGanancias = $retenerGanancias;

        return $this;
    }

    /**
     * Get retenerGanancias
     *
     * @return string
     */
    public function getRetenerGanancias()
    {
        return $this->retenerGanancias;
    }

    /**
     * Set retenerIva
     *
     * @param string $retenerIva
     *
     * @return Proveedores
     */
    public function setRetenerIva($retenerIva)
    {
        $this->retenerIva = $retenerIva;

        return $this;
    }

    /**
     * Get retenerIva
     *
     * @return string
     */
    public function getRetenerIva()
    {
        return $this->retenerIva;
    }

    /**
     * Set idcategIva
     *
     * @param string $idcategIva
     *
     * @return Proveedores
     */
    public function setIdcategIva($idcategIva)
    {
        $this->idcategIva = $idcategIva;

        return $this;
    }

    /**
     * Get idcategIva
     *
     * @return string
     */
    public function getIdcategIva()
    {
        return $this->idcategIva;
    }

    /**
     * Set retenerIngbrut
     *
     * @param string $retenerIngbrut
     *
     * @return Proveedores
     */
    public function setRetenerIngbrut($retenerIngbrut)
    {
        $this->retenerIngbrut = $retenerIngbrut;

        return $this;
    }

    /**
     * Get retenerIngbrut
     *
     * @return string
     */
    public function getRetenerIngbrut()
    {
        return $this->retenerIngbrut;
    }

    /**
     * Set idcategIngbrut
     *
     * @param string $idcategIngbrut
     *
     * @return Proveedores
     */
    public function setIdcategIngbrut($idcategIngbrut)
    {
        $this->idcategIngbrut = $idcategIngbrut;

        return $this;
    }

    /**
     * Get idcategIngbrut
     *
     * @return string
     */
    public function getIdcategIngbrut()
    {
        return $this->idcategIngbrut;
    }

    /**
     * Set idtipoProvCateg
     *
     * @param string $idtipoProvCateg
     *
     * @return Proveedores
     */
    public function setIdtipoProvCateg($idtipoProvCateg)
    {
        $this->idtipoProvCateg = $idtipoProvCateg;

        return $this;
    }

    /**
     * Get idtipoProvCateg
     *
     * @return string
     */
    public function getIdtipoProvCateg()
    {
        return $this->idtipoProvCateg;
    }

    /**
     * Set esNohabitual
     *
     * @param string $esNohabitual
     *
     * @return Proveedores
     */
    public function setEsNohabitual($esNohabitual)
    {
        $this->esNohabitual = $esNohabitual;

        return $this;
    }

    /**
     * Get esNohabitual
     *
     * @return string
     */
    public function getEsNohabitual()
    {
        return $this->esNohabitual;
    }

    /**
     * Set nombreFantasia
     *
     * @param string $nombreFantasia
     *
     * @return Proveedores
     */
    public function setNombreFantasia($nombreFantasia)
    {
        $this->nombreFantasia = $nombreFantasia;

        return $this;
    }

    /**
     * Get nombreFantasia
     *
     * @return string
     */
    public function getNombreFantasia()
    {
        return $this->nombreFantasia;
    }

    /**
     * Set nroidTributaria
     *
     * @param string $nroidTributaria
     *
     * @return Proveedores
     */
    public function setNroidTributaria($nroidTributaria)
    {
        $this->nroidTributaria = $nroidTributaria;

        return $this;
    }

    /**
     * Get nroidTributaria
     *
     * @return string
     */
    public function getNroidTributaria()
    {
        return $this->nroidTributaria;
    }
}
