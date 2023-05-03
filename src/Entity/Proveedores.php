<?php

namespace App\Entity;

use App\Repository\ProveedoresRepository;
use Doctrine\ORM\Mapping as ORM;

/** 
 * ORM\Entity
 * @ORM\Entity(repositoryClass=ProveedoresRepository::class)
 */

class Proveedores
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $correoElectronico;

    /**
     * @ORM\Column(type="varchar", length=20, nullable=true)
     */

    private $telefonoContacto; // Consultado en wikipedia, llega a 20 caracteres

    const TIPO_HOTEL = 'hotel';
    const TIPO_PISTA = 'pista';
    const TIPO_COMPLEMENTO = 'complemento';

    /**
     * @ORM\Column(type="string", length=255) 
     */


    private $tipoProveedor;

    /**
     * @ORM\Column(type="boolean)
     */

    private $activo;

    /**
     * @ORM\Column(type="datetime")
     */

    private $fechaCreacion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaActualizacion;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCorreoElectronico(): ?string
    {
        return $this->correoElectronico;
    }

    public function setCorreoElectronico(string $correoElectronico): self
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    public function getTelefonoContacto(): ?string
    {
        return $this->telefonoContacto;
    }

    public function setTelefonoContacto(?string $telefonoContacto): self
    {
        $this->telefonoContacto = $telefonoContacto;

        return $this;
    }

    public function getTipoProveedor(): ?string
    {
        return $this->tipoProveedor;
    }

    public function setTipoProveedor(string $tipoProveedor): self
    {
        $this->tipoProveedor = $tipoProveedor;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion(\DateTimeInterface $fechaActualizacion): self
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }



}
