<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @ORM\Column(name="full_name", type="string", length=255)
	 */
    private $fullName;

	/**
	 * @ORM\Column(type="string")
	 */
	private $sexe;

     /**
      * @ORM\Column(type="date", nullable=true)
      */
     private $dateNaissance;

	/**
	 * @ORM\Column(name="mobile", type="string", length=255)
	 */
	private $mobile;

	/**
	 * @ORM\Column(name="email", type="string", length=255, unique=true)
	 */
	private $email;

    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return mixed
	 */
	public function getFullName()
	{
		return $this->fullName;
	}

	/**
	 * @param mixed $fullName
	 *
	 * @return $this
	 */
	public function setFullName($fullName)
	{
		$this->fullName = $fullName;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSexe()
	{
		return $this->sexe;
	}

	/**
	 * @param mixed $sexe
	 *
	 * @return $this
	 */
	public function setSexe($sexe)
	{
		$this->sexe = $sexe;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDateNaissance()
	{
		return $this->dateNaissance;
	}

	/**
	 * @param mixed $dateNaissance
	 *
	 * @return $this
	 */
	public function setDateNaissance($dateNaissance)
	{
		$this->dateNaissance = $dateNaissance;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMobile()
	{
		return $this->mobile;
	}

	/**
	 * @param mixed $mobile
	 *
	 * @return $this
	 */
	public function setMobile($mobile)
	{
		$this->mobile = $mobile;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 *
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}



}
