<?php
declare(strict_types=1);

namespace App\Infra\Cli\Commands;

use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;


final class ExportRegistrationCommand
{
    private ExportRegistration $useCase;
    private ExportRegistrationPresenter $presenter;

    public function __construct(
        ExportRegistration $useCase,
        ExportRegistrationPresenter $presenter
    )
    {
        $this->useCase = $useCase;
        $this->presenter = $presenter;
    }

    public function handle(): string
    {
        $inputBoundary = new InputBoundary(
            '12345678909',
            'xpto-cli.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        return $this->presenter->output([
            'fullFileName' => $output->getFullFileName()
        ]);
    }
}
