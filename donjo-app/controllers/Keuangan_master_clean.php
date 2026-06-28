<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Donjo\Application\UseCases\GetKeuanganMaster\GetKeuanganMasterInput;
use Donjo\Application\UseCases\ListKeuanganMaster\ListKeuanganMasterInput;
use Donjo\Infrastructure\Auth\Ci3SessionAuth;
use Donjo\Infrastructure\Middleware\AuthMiddleware;
use Donjo\Infrastructure\ServiceContainer;

/**
 * Keuangan_master_clean — Clean Architecture controller for KeuanganMaster domain.
 *
 * Routes:
 *   GET /keuangan_master_clean             -> index()   list keuangan master
 *   GET /keuangan_master_clean/detail/:id  -> detail($id) single keuangan master
 */
class Keuangan_master_clean extends CI_Controller
{
    private ServiceContainer $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new ServiceContainer($this->db);
    }

    /**
     * GET /keuangan_master_clean
     * Optional: ?tahun=2024&limit=50&offset=0
     */
    public function index(): void
    {
        if (!$this->checkAuth('keuangan')) {
            $this->forbidden();
            return;
        }

        $input = new ListKeuanganMasterInput(
            tahun:  $this->input->get('tahun')  !== false
                ? (int) $this->input->get('tahun')
                : null,
            limit:  (int) ($this->input->get('limit')  ?: 50),
            offset: (int) ($this->input->get('offset') ?: 0),
        );

        $output = $this->container->makeListKeuanganMasterUseCase()->execute($input);

        $items = array_map(
            static fn($m) => [
                'id'    => $m->id,
                'tahun' => $m->tahun,
            ],
            $output->items
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $items, 'total' => count($items)]));
    }

    /**
     * GET /keuangan_master_clean/detail/:id
     */
    public function detail(int $id): void
    {
        if (!$this->checkAuth('keuangan')) {
            $this->forbidden();
            return;
        }

        $input  = new GetKeuanganMasterInput(masterId: $id);
        $output = $this->container->makeGetKeuanganMasterUseCase()->execute($input);

        if ($output->master === null) {
            $this->notFound($id);
            return;
        }

        $m = $output->master;
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => [
                    'id'    => $m->id,
                    'tahun' => $m->tahun,
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
