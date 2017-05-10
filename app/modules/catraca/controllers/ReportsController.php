<?php

/**
 * @copyright   2016 - 2016 Grupo MPE
 * @license     New BSD License; see LICENSE
 * @link        http://www.grupompe.com.br
 * @author      Denner Fernandes <denner.fernandes@grupompe.com.br>
 * */

namespace App\Modules\Catraca\Controllers;

use App\Shared\Controllers\ControllerBase;
use App\Modules\Catraca\Models\Movimentos;
use App\Modules\Catraca\Models\Firebird;
use App\Modules\Catraca\Models\Reports;
use App\Plugins\Tools;

/**
 * Class ReportsController
 * @package Catraca\Controllers
 */
class ReportsController extends ControllerBase
{

    public function indexAction()
    {

        try {

            $this->view->movimentos = '';
            $this->view->pesquisa = '';
            $this->view->export = false;
            $this->view->types = ['Sintético' => 'Sintético', 'Analítico' => 'Analítico', ];

            if ($this->request->isPost()) {

                $search = $this->request->getPost('pesquisa', 'string');
                $dateFrom = $this->extractDate('dateFrom');
                $dateTo = $this->extractDate('dateTo');
                $type = $this->request->getPost('type', 'string');

                //$this->prepareMovimento($dateFrom, $dateTo);

                $this->view->movimentos = $this->getMovimentos($dateFrom, $dateTo, $search, $type);
                $this->view->pesquisa = $search . '|' . $dateFrom . '|' . $dateTo . '|' . $type;
                $this->view->export = true;
                $this->view->type = $type;
            }
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        } catch (\PDOException $e) {
            $this->flash->error($e->getMessage());
        }
    }

    public function exportAction()
    {
        $search = $this->request->get('search', 'string');
        $aux = explode('|', $search);
        $dados = $this->getMovimentos($aux[1], $aux[2], $aux[0], $aux[3]);
        $options['fileName'] = 'Relatório Catraca';

        if ($aux[3] != 'Analítico') {
            $options['toArray'] = false;
        }

        $tools = new Tools();

        switch ($this->request->get('type')) {
            case 'excel':
                return $tools->writeXLS($dados, $options);
            case 'pdf':
                return $tools->writePdf($dados, $options);
            default:
                throw new Exception('Erro ao exportar: Tipo não definido.');
        }
    }

    private function getMovimentos($dateFrom, $dateTo, $search, $type)
    {
        $movimentos = new Movimentos();
        $dados = $movimentos->getReport($dateFrom, $dateTo, $search);

        if ($type == 'Analítico') {
            return $dados;
        }

        $report = new Reports($dados);
        return $report->relatorioSintetico();
    }

    private function prepareMovimento($dateFrom, $dateTo)
    {
        if (empty($dateTo)) {
            $dateTo = date('Y-m-d');
        }
        if ($dateTo < $dateFrom && !empty($dateTo)) {
            throw new \Exception('Data até menor que Data de.');
        }
        $find = "dataMovimento BETWEEN TO_DATE('{$dateFrom}', 'YYYY-MM-DD') AND TO_DATE('{$dateTo} 23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
        $movimentosCount = Movimentos::find($find);
        if ($movimentosCount->count() <= 0) {
            $movimentos = new Movimentos();
            if ($movimentos->deleteByRange($dateFrom, $dateTo . ' 23:59:59') == false) {
                return false;
            }
            $firebird = new Firebird();
            $movimentoFirebird = $firebird->getMovimento($dateFrom, $dateTo);
            foreach ($movimentoFirebird as $movimento) {
                $this->saveMovimentos($movimento);
            }
        }
        return true;
    }

    private function extractDate($field)
    {
        return implode('-', array_reverse(explode('/', $this->request->getPost($field, 'string'))));
    }

    private function saveMovimentos($request)
    {
        $movimentos = new Movimentos();
        $this->makeSetObject($request, $movimentos);
        if (!$movimentos->save()) {
            $msg = '';
            foreach ($movimentos->getMessages() as $message) {
                $msg .= $message . '<br />';
            }
            throw new \Exception($msg);
        }
    }

}
