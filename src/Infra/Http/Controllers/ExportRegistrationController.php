<?php


declare(strict_types=1);

namespace App\Infra\Http\Controllers;

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Infra\Presentation\ExportRegistrationPresenter;

final class ExportRegistrationController
{
    private Request $request;
    private Response $response;
    private ExportRegistrationPresenter $presenter;
    private ExportRegistration $useCase;

    public function __construct(
        Request                     $request,
        Response                    $response,
        ExportRegistrationPresenter $presenter,
        ExportRegistration          $useCase
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
        $this->presenter = $presenter;
    }

    public function handle(): Response
    {
        parse_str($this->request->getUri()->getQuery(), $data);

        $inputBoundary = new InputBoundary(
            $data['registrationNumber'] ?? '',
            'xpto-dompdf.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        $this->response
            ->getBody()
            ->write($this->presenter->output([
                'fullFileName' => $output->getFullFileName()
            ]));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
