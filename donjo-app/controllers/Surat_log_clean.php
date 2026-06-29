<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Donjo\Application\UseCases\GetSuratLog\GetSuratLogInput;
use Donjo\Application\UseCases\ListSuratLog\ListSuratLogInput;
use Donjo\Infrastructure\Auth\Ci3SessionAuth;
use Donjo\Infrastructure\Middleware\AuthMiddleware;
use Donjo\Infrastructure\ServiceContainer;

/**
 * Surat_log_clean — Clean Architecture controller for SuratLog domain.
 *
 * Routes:
 *   GET /surat_log_clean             -> index()   list surat log
 *   GET /surat_log_clean/detail/:id  -> detail($id) single surat log
 */
class Surat_log_clean extends CI_Controller
{
    private ServiceContainer $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new ServiceContainer($this->db);
    }

    /**
     * GET /surat_log_clean
     * Optional: ?bulan=6&tahun=2024&id_pend=123&limit=50&offset=0
     */
    public function index(): void
    {
        if (!$this->checkAuth('surat')) {
            $this->forbidden();
            return;
        }

        $input = new ListSuratLogInput(
            bulan:  $this->input->get('bulan')  !== false
                ? (int) $this->input->get('bulan')
                : null,
            tahun:  $this->input->get('tahun')  !== false
                ? (int) $this->input->get('tahun')
                : null,
            idPend: $this->input->get('id_pend') !== false
                ? (int) $this->input->get('id_pend')
                : null,
            limit:  (int) ($this->input->get('limit')  ?: 50),
            offset: (int) ($this->input->get('offset') ?: 0),
        );

        $output = $this->container->makeListSuratLogUseCase()->execute($input);

        $items = array_map(
            static fn($s) => [
                'id'         => $s->id,
                'id_pend'    => $s->idPend,
                'nama_surat' => $s->namaSurat,
                'tgl_cetak'  => $s->tglCetak,
            ],
            $output->items
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $items, 'total' => count($items)]));
    }

    /**
     * GET /surat_log_clean/detail/:id
     */
    public function detail(int $id): void
    {
        if (!$this->checkAuth('surat')) {
            $this->forbidden();
            return;
        }

        $input  = new GetSuratLogInput(suratLogId: $id);
        $output = $this->container->makeGetSuratLogUseCase()->execute($input);

        if ($output->suratLog === null) {
            $this->notFound($id);
            return;
        }

        $s = $output->suratLog;
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => [
                    'id'         => $s->id,
                    'id_pend'    => $s->idPend,
                    'nama_surat' => $s->namaSurat,
                    'tgl_cetak'  => $s->tglCetak,
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
