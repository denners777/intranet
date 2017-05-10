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

/**
 * Class IndexController
 * @package Catraca\Controllers
 */
class IndexController extends ControllerBase
{

    public function indexAction($dateFrom = '', $dateTo = '')
    {

        try {

            if ($dateFrom == '') {
                $hoje = time();
                $ontem = $hoje - (24 * 3600);
                $dateFrom = date('Y-m-d', $ontem);
            }

            if ($dateTo == '') {
                $dateTo = date('Y-m-d');
            }
            if ($dateTo < $dateFrom) {
                throw new \Exception('Parametros ordenados de forma errada.');
            }

            $firebird = new Firebird();
            $movimentoFirebird = $firebird->getMovimento($dateFrom, $dateTo);
            $count = count($movimentoFirebird);

            foreach ($movimentoFirebird as $movimento) {
                $movimentos = new Movimentos();
                $this->makeSetObject($movimento, $movimentos);
                if (!$movimentos->save()) {
                    $msg = $this->getMessage($movimentos->getMessages());
                    throw new \Exception($msg);
                }
            }

            $this->flash->success("Foram inseridos {$count} registros.");
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        } catch (\PDOException $e) {
            $this->flash->error($e->getMessage());
        }
        return $this->response->redirect('catraca/reports');
    }

}
