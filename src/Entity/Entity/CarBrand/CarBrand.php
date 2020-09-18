<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarBrand;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarBrand\ForCarBrand\Id;
use App\Entity\Entity\CarBrand\ForCarBrand\Model;
use App\Entity\Entity\CarBrand\ForCarBrand\Name;
use App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarBrandRepository", readOnly=false)
 * @ORM\Table(name="car_brands",
 *     indexes={
 *         @ORM\Index(columns={"name", "model"})
 *     }
 * )
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarBrand
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarBrandIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\Column(name="name", type="CarBrandNameType", nullable=false)
     */
    private Name $name;

    /**
     * @ORM\Column(name="model", type="CarBrandModelType", nullable=false)
     */
    private Model $model;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carBrand",
     *     orphanRemoval=false, cascade={"persist"}
     * )
     */
    private Collection $cars;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entity\CarFactoryComplectation\CarFactoryComplectation",
     *     mappedBy="carBrand", fetch="LAZY", orphanRemoval=false, cascade={"persist"} )
     */
    private Collection $carFactoryComplectations;
    
    public function __construct(Id $id, Name $name, Model $model)
    {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->cars = new ArrayCollection([]);
        $this->carFactoryComplectations = new ArrayCollection([]);
    }

    public function setName(Name $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        
        return $this;
    }

    public function setCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
        }

        return $this;
    }

    public function setCarFactoryComplectation(CarFactoryComplectation $carFactoryComplectation): self
    {
        if (!$this->carFactoryComplectations->contains($carFactoryComplectation)) {
            $this->carFactoryComplectations->add($carFactoryComplectation);
        }

        return $this;
    }

    public function getName(): Name
    {
        return $this->name;
    }
    
    public function getModel(): Model
    {
        return $this->model;
    }
    
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function getCarFactoryComplectations(): Collection
    {
        return $this->carFactoryComplectations;
    }
}