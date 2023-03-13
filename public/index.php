<?php

use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;

require_once __DIR__ . '/../vendor/autoload.php';


$registration = new Registration();

$registration->setName("Felipe Ribeiro de Andrade")
    ->setBirthDate(new \DateTimeImmutable('1986-10-17'))
    ->setMail(new Email('phelipperibeiro@hotmail.com'))
    ->setRegistrationAt(new \DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('12345678909'));


dd($registration);





