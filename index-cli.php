<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Infra\Adapters\DomPdfAdapter;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Cli\Commands\ExportRegistrationCommand;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySql\PdoRegistrationRepository;

//ini_set('display_errors', 'off');

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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

//$pdfExporter = new DomPdfAdapter();
$pdfExporter = new Html2PdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration(
    $registrationRepository,
    $pdfExporter,
    $storage);

$exportRegistrationPresenter = new ExportRegistrationPresenter();

$exportRegistrationCommand = new ExportRegistrationCommand(
    $exportRegistrationUseCase,
    $exportRegistrationPresenter
);

echo $exportRegistrationCommand->handle();
