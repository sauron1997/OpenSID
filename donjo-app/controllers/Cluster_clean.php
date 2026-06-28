<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Donjo\Application\UseCases\GetCluster\GetClusterInput;
use Donjo\Application\UseCases\ListCluster\ListClusterInput;
use Donjo\Infrastructure\Auth\Ci3SessionAuth;
use Donjo\Infrastructure\Middleware\AuthMiddleware;
use Donjo\Infrastructure\ServiceContainer;

/**
 * Cluster_clean — Clean Architecture controller for Cluster (Wilayah) domain.
 *
 * Routes:
 *   GET /cluster_clean              -> index()   list cluster
 *   GET /cluster_clean/detail/:id   -> detail($id) single cluster
 *
 * Optional filter for index: ?level=dusun|rw|rt&dusun=xxx&rw=xxx
 */
class Cluster_clean extends CI_Controller
{
    private ServiceContainer $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = new ServiceContainer($this->db);
    }

    /**
     * GET /cluster_clean
     * Optional: ?level=dusun|rw|rt&dusun=xxx&rw=xxx
     */
    public function index(): void
    {
        if (!$this->checkAuth('cluster')) {
            $this->forbidden();
            return;
        }

        $input = new ListClusterInput(
            level: $this->input->get('level') ?: null,
            dusun: $this->input->get('dusun') ?: null,
            rw:    $this->input->get('rw')    ?: null,
        );

        $output = $this->container->makeListClusterUseCase()->execute($input);

        $items = array_map(
            static fn($c) => [
                'id'    => $c->id,
                'dusun' => $c->dusun,
                'rw'    => $c->rw,
                'rt'    => $c->rt,
            ],
            $output->items
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $items, 'total' => count($items)]));
    }

    /**
     * GET /cluster_clean/detail/:id
     */
    public function detail(int $id): void
    {
        if (!$this->checkAuth('cluster')) {
            $this->forbidden();
            return;
        }

        $input  = new GetClusterInput(clusterId: $id);
        $output = $this->container->makeGetClusterUseCase()->execute($input);

        if ($output->cluster === null) {
            $this->notFound($id);
            return;
        }

        $c = $output->cluster;
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'data' => [
                    'id'        => $c->id,
                    'dusun'     => $c->dusun,
                    'rw'        => $c->rw,
                    'rt'        => $c->rt,
                    'id_kepala' => $c->idKepala,
                    'lat'       => $c->lat,
                    'lng'       => $c->lng,
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
