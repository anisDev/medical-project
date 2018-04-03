<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicamentRepository")
 */
class Medicament
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
    private $nom;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $posologie;

     /**
      * @ORM\Column(type="text", nullable=true)
      */
     private $contreIndication;

    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return mixed
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * @param mixed $nom
	 *
	 * @return $this
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPosologie()
	{
		return $this->posologie;
	}

	/**
	 * @param mixed $posologie
	 *
	 * @return $this
	 */
	public function setPosologie($posologie)
	{
		$this->posologie = $posologie;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContreIndication()
	{
		return $this->contreIndication;
	}

	/**
	 * @param mixed ContreIndication
	 *
	 * @return $this
	 */
	public function setContreIndication($ContreIndication)
	{
		$this->contreIndication = $ContreIndication;

		return $this;
	}


}
