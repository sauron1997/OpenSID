<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Donjo\Application\UseCases\GetKeluarga\GetKeluargaInput;
use Donjo\Application\UseCases\ListKeluarga\ListKeluargaInput;
use Donjo\Infrastructure\Auth\Ci3SessionAuth;
use Donjo\Infrastructure\Middleware\AuthMiddleware;
use Donjo\Infrastructure\ServiceContainer;

/**
 * Keluarga_clean — Clean Architecture controller for Keluarga domain.
 *
 * Routes:
 *   GET /keluarga_clean              -> index()   list keluarga
 *   GET /keluarga_clean/detail/:id   -> detail($id) single keluarga
 */
class Keluarga_clean extends CI_Controller
{
    private ServiceContainer $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new ServiceContainer($this->db);
    }

    /**
     * GET /keluarga_clean
     * Optional: ?id_cluster=5&limit=50&offset=0
     */
    public function index(): void
    {
        if (!$this->checkAuth('keluarga')) {
            $this->forbidden();
            return;
        }

        $input = new ListKeluargaInput(
            idCluster: $this->input->get('id_cluster') !== false
                ? (int) $this->input->get('id_cluster')
                : null,
            limit:  (int) ($this->input->get('limit')  ?: 50),
            offset: (int) ($this->input->get('offset') ?: 0),
        );

        $output = $this->container->makeListKeluargaUseCase()->execute($input);

        $items = array_map(
            static fn($k) => [
                'id'     => $k->id,
                'no_kk'  => $k->nomorKk?->getValue(),
                'alamat' => $k->alamat,
            ],
            $output->items
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $items, 'total' => count($items)]));
    }

    /**
     * GET /keluarga_clean/detail/:id
     */
    public function detail(int $id): void
    {
        if (!$this->checkAuth('keluarga')) {
            $this->forbidden();
            return;
        }

        $input  = new GetKeluargaInput(keluargaId: $id);
        $output = $this->container->makeGetKeluargaUseCase()->execute($input);

        if ($output->keluarga === null) {
            $this->notFound($id);
            return;
        }

        $k = $output->keluarga;
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => [
                    'id'          => $k->id,
                    'no_kk'       => $k->nomorKk?->getValue(),
                    'nik_kepala'  => $k->nikKepala?->getValue(),
                    'alamat'      => $k->alamat,
                    'id_cluster'  => $k->idCluster,
                ],
            ]));
    }

    private function checkAuth(string $resource): bool
    {
        $auth       = new Ci3SessionAuth($this->db);
        $middleware = new AuthMiddleware($auth);
        return $middleware->canRead($this->session->userdata('id'), $resource);
    }

    private function forbidden(): void
    {
        $this->output
            ->set_status_header(403)
            ->set_content_type('application/json')
            ->set_output(json_encode(['error' => 'Forbidden']));
    }

    private function notFound(int $id): void
    {
        $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode(['error' => 'Not found', 'id' => $id]));
    }
}
