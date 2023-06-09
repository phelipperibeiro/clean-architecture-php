<?php

namespace App\Application\UseCases\ExportRegistration;

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Application\Contracts\Storage;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;

final class ExportRegistration
{
    private LoadRegistrationRepository $repository;
    private ExportRegistrationPdfExporter $pdfExporter;
    private Storage $storage;

    public function __construct(
        LoadRegistrationRepository    $repository,
        ExportRegistrationPdfExporter $pdfExporter,
        Storage                       $storage
    )
    {
        $this->repository = $repository;
        $this->pdfExporter = $pdfExporter;
        $this->storage = $storage;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cpf = new Cpf($input->getRegistrationNumber());
        $registration = $this->repository->loadByRegistrationNumber($cpf);
        $fileContect = $this->pdfExporter->generate($registration);
        $this->storage->store($input->getPdfFileName(), $input->getPath(), $fileContect);

        return new OutputBoundary($input->getPath() . DIRECTORY_SEPARATOR . $input->getPdfFileName());
    }
}
