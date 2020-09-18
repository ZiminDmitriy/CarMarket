<?php
declare(strict_types=1);

namespace App\Entity\Entity\CarExternalParameters;

use App\Entity\Entity\Car\Car;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\BodyForm;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\Color;
use App\Entity\Entity\CarExternalParameters\ForCarExternalParameters\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarExternalParametersRepository", readOnly=false)
 * @ORM\Table(name="car_external_parameters")
 * @ORM\ChangeTrackingPolicy(value="DEFERRED_IMPLICIT")
 */
class CarExternalParameters
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="CarExternalParametersIdType", nullable=false)
     */
    private Id $id;

    /**
     * @ORM\Column(name="body_form", type="CarExternalParametersBodyFormType", nullable=false)
     */
    private BodyForm $bodyForm;

    /**
     * @ORM\Column(name="color", type="CarExternalParametersColorType", nullable=false)
     */
    private Color $color;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entity\Car\Car", mappedBy="carExternalParameters",
     *     fetch="LAZY", orphanRemoval=true, cascade={"persist"})
     */
    private Car $car;

    public function __construct(Car $car, Id $id, BodyForm $bodyForm, Color $color)
    {
        $this->car = $car;
        $this->id = $id;
        $this->bodyForm = $bodyForm;
        $this->color = $color;
    }

    public function setBodyForm(BodyForm $bodyForm): self
    {
        $this->bodyForm = $bodyForm;

        return $this;
    }

    public function setColor(Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getBodyForm(): BodyForm
    {
        return $this->bodyForm;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}