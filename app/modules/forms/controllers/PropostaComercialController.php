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

}
