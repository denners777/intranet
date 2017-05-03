<?php

namespace App\Modules\Catraca\Models;

class Reports
{

    /**
     *
     * @var type 
     */
    private $dados;

    /**
     * 
     * @param type $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * 
     * @return type
     */
    public function relatorioSintetico()
    {
        $return = [];
        $i = 0;
        $cpf = $data = '';

        foreach ($this->dados as $key => $value) {
            if ($value->CPF != $cpf) {
                $return[$value->CPF] = [
                    'name' => $value->NOME,
                    'cpf' => $value->CPF,
                    'empresa' => $value->EMPRESA,
                    'secao' => $value->SECAO,
                ];
                $i = 0;
                $cpf = $value->CPF;
            }
            if ($value->DATA != $data) {
                $i = 0;
                $data = $value->DATA;
            }
            $return[$value->CPF]['datas'][$value->DATA]['data'] = $value->DATA;
            $return[$value->CPF]['datas'][$value->DATA]['batidas'][$i] = [
                'tipo' => $value->TIPO,
                'hora' => $value->HORA
            ];
            $i++;
        }
        return $this->prepareArray($return);
    }

    /**
     * 
     * @param type $array
     * @return type
     */
    private function prepareArray($array)
    {
        $return = [];

        foreach ($array as $arr) {
            foreach ($arr['datas'] as $datas) {
                $return[] = [
                    'nome' => $arr['name'],
                    'cpf' => $arr['cpf'],
                    'empresa' => $arr['empresa'],
                    'secao' => $arr['secao'],
                    'data' => $datas['data'],
                    'primeiraBatida' => $this->getBatida($datas['batidas'], 'first'),
                    'ultimaBatida' => $this->getBatida($datas['batidas'], 'last'),
                    'cargaHoraria' => $this->makeCargaHoraria($datas['batidas']),
                    'permanencia' => $this->makePermanecia($datas['batidas']),
                    'ausencia' => $this->makeAusencia($datas['batidas']),
                    'almoco' => $this->makeAlmoco($datas['batidas']),
                ];
            }
        }
        return $return;
    }

    /**
     * 
     * @param type $batidas
     * @return type
     */
    private function makeCargaHoraria($batidas)
    {
        $primeiraBatida = $this->transformInHour($this->getBatida($batidas, 'first'));
        $ultimaBatida = $this->transformInHour($this->getBatida($batidas, 'last'));
        return $this->makediffHour($primeiraBatida, $ultimaBatida);
    }

    /**
     * 
     * @param type $batidas
     * @return type
     */
    private function makePermanecia($batidas)
    {
        $return = [];
        $entrada = $saida = '';
        $first = false;

        foreach ($batidas as $value) {
            if ($this->getTipoBatida($value, 'ENTRADA')) {
                $entrada = $this->transformInHour($value['hora']);
                $first = true;
            }

            if ($this->getTipoBatida($value, 'SAIDA') and $first) {
                $saida = $this->transformInHour($value['hora']);
            }

            if ($entrada != '' and $saida != '') {
                $return[] = $this->makediffHour($entrada, $saida);
                $entrada = $saida = '';
            }
        }
        if (count($return > 1)) {
            return $this->sumHourByArray($return);
        }

        return $return[0];
    }

    /**
     * 
     * @param type $batidas
     * @return type
     */
    private function makeAusencia($batidas)
    {
        $return = [];
        $entrada = $saida = '';
        $first = false;

        foreach ($batidas as $value) {
            if ($this->getTipoBatida($value, 'ENTRADA') and $first) {
                $entrada = $this->transformInHour($value['hora']);
            }

            if ($this->getTipoBatida($value, 'SAIDA')) {
                $saida = $this->transformInHour($value['hora']);
                $first = true;
            }

            if ($entrada != '' and $saida != '') {
                $return[] = $this->makediffHour($saida, $entrada);
                $entrada = $saida = '';
            }
        }

        if (count($return > 1)) {
            return $this->sumHourByArray($return);
        }

        return $return[0];
    }

    /**
     * 
     * @param type $batidas
     * @return type
     */
    private function makeAlmoco($batidas)
    {
        $return = [];
        $entrada = $saida = '';
        $first = false;

        foreach ($batidas as $value) {
            if ($this->getTipoBatida($value, 'ENTRADA') and $first) {
                $entrada = $this->transformInHour($value['hora']);
            }
            if ($this->getTipoBatida($value, 'SAIDA')) {
                if ($this->verificarHoraAlmoco($value['hora'])) {
                    $saida = $this->transformInHour($value['hora']);
                    $first = true;
                }
                else {
                    $first = false;
                }
            }
            if ($entrada != '' and $saida != '') {
                $return[] = $this->makediffHour($saida, $entrada);
                $entrada = $saida = '';
            }
        }
        if (count($return > 1)) {
            return $this->sumHourByArray($return);
        }
        return $return[0];
    }

    /**
     * 
     * @param type $hour
     * @return type
     */
    private function verificarHoraAlmoco($hour)
    {
        $start = '11:30:00';
        $finish = '14:30:59';
        return $hour >= $start and $hour <= $finish;
    }

    /**
     * 
     * @param type $hours
     * @return type
     */
    private function sumHourByArray($hours)
    {
        $segundos = 0;

        foreach ($hours as $hour) {
            list( $h, $m, $s ) = explode(':', $hour);
            $segundos += $h * 3600;
            $segundos += $m * 60;
            $segundos += $s;
        }
        $horas = str_pad(floor($segundos / 3600), 2, 0, STR_PAD_LEFT);
        $segundos %= 3600;
        $minutos = str_pad(floor($segundos / 60), 2, 0, STR_PAD_LEFT);
        $segundos %= 60;
        $segundos = str_pad($segundos, 2, 0, STR_PAD_LEFT);
        return "{$horas}:{$minutos}:{$segundos}";
    }

    /**
     * 
     * @param type $hour
     * @return type
     */
    private function transformInHour($hour)
    {
        return \DateTime::createFromFormat('H:i:s', $hour);
    }

    /**
     * 
     * @param \DateTime $hour1
     * @param \DateTime $hour2
     * @param type $object
     * @return type
     */
    private function makediffHour(\DateTime $hour1, \DateTime $hour2, $object = false)
    {
        $diff = $hour1->diff($hour2);
        if ($object) {
            return $diff;
        }
        return $diff->format('%H:%I:%S');
    }

    /**
     * 
     * @param type $batidas
     * @param type $type
     * @return string
     */
    private function getBatida($batidas, $type)
    {
        for ($i = 0; $i < count($batidas); $i++) {
            switch ($type) {
                case 'first':
                    if ($this->getTipoBatida($batidas[$i], 'ENTRADA')) {
                        return $batidas[$i]['hora'];
                    }
                    break;
                case 'last':
                    if ($this->getTipoBatida($batidas[$i], 'SAIDA') and $i == count($batidas) - 1) {
                        return $batidas[$i]['hora'];
                    }
                default:
                    break;
            }
        }
        return '17:48:00';
    }

    /**
     * 
     * @param type $batida
     * @param type $tipo
     * @return type
     */
    private function getTipoBatida($batida, $tipo)
    {
        return $batida['tipo'] == $tipo;
    }

}
