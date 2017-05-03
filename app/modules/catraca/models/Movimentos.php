<?php

/**
 * @copyright   2016 Grupo MPE
 * @license     New BSD License; see LICENSE
 * @link        http://www.grupompe.com.br
 * @author      Denner Fernandes <denner.fernandes@grupompe.com.br>
 * */

namespace App\Modules\Catraca\Models;

use App\Modules\Nucleo\Models\Protheus\Colaboradores;
use App\Shared\Models\ModelBase;
use Phalcon\Db\RawValue;
use Phalcon\Config as ObjectPhalcon;

class Movimentos extends ModelBase {

    protected $id;
    protected $name;
    protected $dataMovimento;
    protected $tipo;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDataMovimento() {
        return $this->dataMovimento;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDataMovimento($dataMovimento) {
        $this->dataMovimento = new RawValue("TO_DATE('{$dataMovimento}', 'YYYY-MM-DD HH24:MI:SS')");
        return $this;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function initialize() {

        parent::initialize();

        $this->belongsTo('TRIM(name)', 'App\Modules\Nucleo\Models\Protheus\Colaboradores', 'TRIM(szhNome)', ['alias' => 'Colaboradores',]);
    }

    public function getSource() {
        return 'MOVIMENTO_CATRACA';
    }

    public static function columnMap() {
        return [
            'ID_MOVIMENTO_CATRACA' => 'id',
            'DS_NOME' => 'name',
            'DT_MOVIMENTO' => 'dataMovimento',
            'DS_TIPO' => 'tipo',
        ];
    }

    public function getReport($dateFrom = '', $dateTo = '', $pesquisa = '') {

        $busca = '';

        if (!empty($dateFrom)) {
            $busca .= " AND DT_MOVIMENTO >= TO_DATE('{$dateFrom}', 'YYYY-MM-DD')";
        }
        if (!empty($dateTo)) {
            $dateTo = $dateTo . ' 23:59:59';
            $busca .= " AND DT_MOVIMENTO <= TO_DATE('{$dateTo}', 'YYYY-MM-DD HH24:MI:SS')";
        }
        if (!empty($pesquisa)) {
            $busca .= " AND (UPPER(EMPRESA) LIKE UPPER('%$pesquisa%')
                          OR UPPER(NOME) LIKE UPPER('%$pesquisa%')
                          OR UPPER(CPF) LIKE UPPER('%$pesquisa%')
                          OR UPPER(SECAO) LIKE UPPER('%$pesquisa%'))";
        }

        $connection = $this->customSimpleQuery('db');

        $query = "SELECT EMPRESA, NOME, CPF, SECAO, DATA, HORA, TIPO FROM(
                    SELECT CO.EMPRESA,
                        CO.NOME,
                        CO.CPF,
                        CO.CODSECAO SECAO,
                        TO_CHAR(MO.DT_MOVIMENTO, 'DD/MM/YYYY') DATA,
                        TO_CHAR(MO.DT_MOVIMENTO, 'HH24:MI:SS') HORA,
                        TRIM(MO.DS_TIPO) TIPO,
                        MO.DT_MOVIMENTO
                    FROM MOVIMENTO_CATRACA MO
                    LEFT JOIN VW_COLABORADOR_PROTHEUS CO
                        ON CO.NOME = MO.DS_NOME
                  )
                  WHERE 1 = 1 {$busca}
                  ORDER BY NOME, DATA, HORA";
        return new ObjectPhalcon($connection->fetchAll($query, \Phalcon\Db::FETCH_ASSOC));
    }

    public function deleteByRange($dateFrom, $dateTo) {

        $connection = $this->customConnection('db');
        $result = $connection->delete('MOVIMENTO_CATRACA', "DT_MOVIMENTO BETWEEN TO_DATE('{$dateFrom}', 'YYYY-MM-DD') AND TO_DATE('{$dateTo}', 'YYYY-MM-DD HH24:MI:SS')");
        $connection->bye();
        return $result;
    }

}
