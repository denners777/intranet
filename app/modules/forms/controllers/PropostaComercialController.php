<?php

namespace App\Modules\Forms\Controllers;

use App\Shared\Controllers\ControllerBase;
use App\Modules\Nucleo\Models\Protheus\Protheus;
use App\Modules\Forms\Models\PropostaComercial;

class PropostaComercialController extends ControllerBase
{

    /**
     * initialize
     */
    public function initialize()
    {
        $this->tag->setTitle('Formulário de Proposta Comercial');
        parent::initialize();
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        try {

            $this->view->empresas = PropostaComercial::getEmpresas();
            $this->view->tipoEdital = PropostaComercial::getTipoEdital();
            $this->view->unidadeOrganizacional = PropostaComercial::getUnidadeOrganizacional();
            $this->view->razoesEstrategicas = PropostaComercial::getRazoesEstrategicas();

            $protheus = Protheus::getProtheus()->getGestores();
            $gestores = [];
            foreach ($protheus as $value) {
                $gestores[$value['code'] . ' - ' . $value['name']] = $value['name'];
            }

            $this->view->responsavel = $gestores;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    public function sendFormAction()
    {
        try {
            if (!$this->request->isPost()) {
                throw new \Exception('Acesso indevido a essa action.');
            }

            $post = $this->request->getPost();

            $propostaComercial = $this->create($post);
            $post['record'] = $propostaComercial['record'];
            $post['status'] = $propostaComercial['status'];
            $campos = $this->defineFields($post);

            $this->view->campos = $campos;

            $this->view->setTemplateBefore('blank');

            $to = [];
            $subject = 'Formulário de Proposta Comercial';
            $params = ['campos' => $campos];
            $options['copy'] = ['denner.fernandes@grupompe.com.br' => 'Denner Fernandes'];

            //log
            /* $options['log'] = [
              'formName' => $subject,
              'identKey' => 'CPF: ' . $cpf . ' - Tipo: ' . $type,
              'usersName' => $cpf,
              ]; */

            $return = $this->mail->send($to, $subject, 'blank', $params, $options);

            if ($return) {
                $this->flash->success('Sua solicitação foi enviada com Sucesso. Você receberá, em breve, um e-mail contendo as informações dessa solicitação.');
            }
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        } catch (\PDOException $e) {
            $this->flash->error($e->getMessage());
        }
        return $this->response->redirect('forms/proposta_comercial/');
    }

    private function create($post)
    {
        $propostaComercial = new PropostaComercial();
        $propostaComercial->setId($propostaComercial->autoincrement());
        $propostaComercial->setRecord($this->makeRecord($post));
        $propostaComercial->setContent(json_encode([
            'empresa' => $post['empresa'],
            'data' => $post['data'],
            'hora' => $post['hora'],
            'cliente' => $post['cliente'],
            'unidadeLocal' => $post['unidadeLocal'],
            'tipoEdital' => $post['tipoEdital'],
            'descEdital' => $post['descEdital'],
            'objeto' => $post['objeto'],
            'razoesEstrategicas' => $post['razoesEstrategicas'],
            'analisePreliminarExequivel' => $post['analisePreliminarExequivel'],
            'analiseRisco' => $post['analiseRisco'],
            'responsavel' => $post['responsavel'],
        ]));

        $propostaComercial->setCpf($this->auth_identity->cpf);
        $propostaComercial->setStatus('B');

        if (!$propostaComercial->create()) {
            throw new \Exception($this->getMessage($propostaComercial->getMessages()));
        }

        return $propostaComercial->toArray();
    }

    private function makeRecord($post)
    {
        $empresa = $post['empresa'];
        $unidOrg = $post['unidadeOrganizacional'];
        $sequencial = PropostaComercial::getSequencial();
        return $empresa . '-' . $unidOrg . '-' . $sequencial . '/' . date('Y');
    }

    private function defineFields($post)
    {
        return [
            'Nº Registro' => $post['record'],
            'Empresa' => PropostaComercial::getEmpresas()[$post['empresa']],
            'Data' => $post['data'],
            'Hora' => $post['hora'],
            'Cliente' => $post['cliente'],
            'Unidade/Local' => $post['unidadeLocal'],
            'Tipo Edital' => $post['tipoEdital'],
            'Descrição Edital' => $post['descEdital'],
            'Objeto' => $post['objeto'],
            'Unidade Organizacional' => PropostaComercial::getUnidadeOrganizacional()[$post['unidadeOrganizacional']],
            'Razões Estratégicas' => $post['razoesEstrategicas'],
            'Análise Preliminar Exequível' => $post['analisePreliminarExequivel'],
            'Análise de Risco' => $post['analiseRisco'],
            'Status' => PropostaComercial::getTypeStatus()[$post['status']],
        ];
    }

}
