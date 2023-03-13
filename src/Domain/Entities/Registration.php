<?php

declare(strict_types=1);

namespace App\Domain\Entities;

final class Registration
{
    private string $name;
    private string $mail;
    private string $cpf;
    private \DateTimeInterface $birthDate;
    private string $registrationNumber;
    private \DateTimeInterface $registrationAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Registration
     */
    public function setName(string $name): Registration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return Registration
     */
    public function setMail(string $mail): Registration
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return Registration
     */
    public function setCpf(string $cpf): Registration
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeInterface $birthDate
     * @return Registration
     */
    public function setBirthDate(\DateTimeInterface $birthDate): Registration
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @param string $registrationNumber
     * @return Registration
     */
    public function setRegistrationNumber(string $registrationNumber): Registration
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getRegistrationAt(): \DateTimeInterface
    {
        return $this->registrationAt;
    }

    /**
     * @param \DateTimeInterface $registrationAt
     * @return Registration
     */
    public function setRegistrationAt(\DateTimeInterface $registrationAt): Registration
    {
        $this->registrationAt = $registrationAt;
        return $this;
    }
}
