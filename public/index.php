<?php

use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Infra\Repositories\MySql\PdoRegistrationRepository;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\DomPdfAdapter;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use App\Infra\Presentation\ExportRegistrationPresenter;


require_once __DIR__ . '/../vendor/autoload.php';


######################################################################################################################
################################################# Entities ###########################################################
######################################################################################################################

$registration = new Registration();
$registration->setName("Felipe Ribeiro de Andrade")
    ->setBirthDate(new \DateTimeImmutable('1986-10-17'))
    ->setEmail(new Email('phelipperibeiro@hotmail.com'))
    ->setRegistrationAt(new \DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('12345678909'));


######################################################################################################################
################################################# UseCases (services) ################################################
######################################################################################################################

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$env = $dotenv->load();

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_DATABASE'],
    $env['DB_CHARSET'],
);
$pdo = new PDO($dsn, $env['DB_USERNAME'], $env['DB_PASSWORD'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => TRUE
]);

$registrationRepository = new PdoRegistrationRepository(
    $pdo
);

//$pdfExporter = new Html2PdfAdapter();
$pdfExporter = new DomPdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration(
    $registrationRepository,
    $pdfExporter,
    $storage
);

//$output = $exportRegistrationUseCase->handle(
//    new \App\Application\UseCases\ExportRegistration\InputBoundary('12345678909', 'XPTO', __DIR__ . '/../storage')
//);

######################################################################################################################
################################################# Controllers ########################################################
######################################################################################################################

$request = new Request('GET', 'http://localhost:80?registrationNumber=12345678909');
$response = new Response();
$exportRegistrationPresenter = new ExportRegistrationPresenter();

$exportRegistrationController = new ExportRegistrationController(
    $request,
    $response,
    $exportRegistrationPresenter,
    $exportRegistrationUseCase
);

$output = $exportRegistrationController->handle();
echo $output->getBody();










