<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $surname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="patients")
     */
    private $dr;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="dr")
     */
    private $patients;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="patient")
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="doctor")
     */
    private $appointmentsDoc;

    /**
     * @ORM\OneToMany(targetEntity=Diagnosis::class, mappedBy="patient")
     */
    private $diagnoses;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    public $specialties;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->appointmentsDoc = new ArrayCollection();
        $this->diagnoses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDr(): ?self
    {
        return $this->dr;
    }

    public function setDr(?self $dr): self
    {
        $this->dr = $dr;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(self $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setDr($this);
        }

        return $this;
    }

    public function removePatient(self $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getDr() === $this) {
                $patient->setDr(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPatient() === $this) {
                $appointment->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointmentsDoc(): Collection
    {
        return $this->appointmentsDoc;
    }

    public function addAppointmentsDoc(Appointment $appointmentsDoc): self
    {
        if (!$this->appointmentsDoc->contains($appointmentsDoc)) {
            $this->appointmentsDoc[] = $appointmentsDoc;
            $appointmentsDoc->setDoctor($this);
        }

        return $this;
    }

    public function removeAppointmentsDoc(Appointment $appointmentsDoc): self
    {
        if ($this->appointmentsDoc->removeElement($appointmentsDoc)) {
            // set the owning side to null (unless already changed)
            if ($appointmentsDoc->getDoctor() === $this) {
                $appointmentsDoc->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Diagnosis[]
     */
    public function getDiagnoses(): Collection
    {
        return $this->diagnoses;
    }

    public function addDiagnosis(Diagnosis $diagnosis): self
    {
        if (!$this->diagnoses->contains($diagnosis)) {
            $this->diagnoses[] = $diagnosis;
            $diagnosis->setPatient($this);
        }

        return $this;
    }

    public function removeDiagnosis(Diagnosis $diagnosis): self
    {
        if ($this->diagnoses->removeElement($diagnosis)) {
            // set the owning side to null (unless already changed)
            if ($diagnosis->getPatient() === $this) {
                $diagnosis->setPatient(null);
            }
        }

        return $this;
    }

    public function getSpecialties(): ?string
    {
        return $this->specialties;
    }

    public function setSpecialties(?string $specialties): self
    {
        $this->specialties = $specialties;

        return $this;
    }
}
