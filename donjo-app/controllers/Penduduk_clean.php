<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Donjo\Application\UseCases\GetPenduduk\GetPendudukInput;
use Donjo\Application\UseCases\ListPenduduk\ListPendudukInput;
use Donjo\Infrastructure\Auth\Ci3SessionAuth;
use Donjo\Infrastructure\Middleware\AuthMiddleware;
use Donjo\Infrastructure\ServiceContainer;

/**
 * Penduduk_clean — Pilot controller for Clean Architecture wiring.
 *
 * Thin adapter: parse input, call use case, format output.
 * Business logic lives in the use case and domain layers — not here.
 *
 * Routes:
 *   GET /penduduk_clean           -> index()   list penduduk
 *   GET /penduduk_clean/detail/1  -> detail(1) single penduduk
 */
class Penduduk_clean extends CI_Controller
{
    private ServiceContainer $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new ServiceContainer($this->db);
    }

    /**
     * GET /penduduk_clean
     * Optional query params: ?id_cluster=5&limit=50&offset=0
     */
    public function index(): void
    {
        if (!$this->checkAuth('penduduk')) {
            $this->forbidden();
            return;
        }

        $input = new ListPendudukInput(
            idCluster: $this->input->get('id_cluster') !== false
                ? (int) $this->input->get('id_cluster')
                : null,
            limit:  (int) ($this->input->get('limit')  ?: 50),
            offset: (int) ($this->input->get('offset') ?: 0),
        );

        $output = $this->container->makeListPendudukUseCase()->execute($input);

        $items = array_map(
            static fn($p) => [
                'id'   => $p->id,
                'nama' => $p->nama,
                'nik'  => $p->nik?->getValue(),
            ],
            $output->items
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $items, 'total' => count($items)]));
    }

    /**
     * GET /penduduk_clean/detail/:id
     *
     * @param int $id Penduduk identifier.
     */
    public function detail(int $id): void
    {
        if (!$this->checkAuth('penduduk')) {
            $this->forbidden();
            return;
        }

        $input  = new GetPendudukInput(pendudukId: $id);
        $output = $this->container->makeGetPendudukUseCase()->execute($input);

        if ($output->penduduk === null) {
            $this->notFound($id);
            return;
        }

        $p = $output->penduduk;
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => [
                    'id'            => $p->id,
                    'nama'          => $p->nama,
                    'nik'           => $p->nik?->getValue(),
                    'tempat_lahir'  => $p->tempatLahir,
                    'tanggal_lahir' => $p->tanggalLahir,
                    'id_cluster'    => $p->idCluster,
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

