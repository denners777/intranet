<?php

/**
 * @copyright   2016 - 2016 Grupo MPE
 * @license     New BSD License; see LICENSE
 * @link        http://www.grupompe.com.br
 * @author      Denner Fernandes <denner.fernandes@grupompe.com.br>
 * */

namespace App\Modules\Forms\Models;

use App\Shared\Models\ModelBase;
use App\Shared\Models\beforeCreate;
use App\Shared\Models\beforeUpdate;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class PropostaComercial extends ModelBase
{

    use beforeCreate;

    use beforeUpdate;

    /**
     *
     * @var integer 
     */
    protected $id;

    /**
     *
     * @var string 
     */
    protected $record;

    /**
     *
     * @var string 
     */
    protected $content;

    /**
     *
     * @var string 
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $contract;

    /**
     *
     * @var string
     */
    protected $comments;

    /**
     *
     * @var double
     */
    protected $budgetAmount;

    /**
     *
     * @var string
     */
    protected $sdel;

    /**
     *
     * @var string
     */
    protected $createBy;

    /**
     *
     * @var datetime
     */
    protected $createIn;

    /**
     *
     * @var string
     */
    protected $updateBy;

    /**
     *
     * @var datetime
     */
    protected $updateIn;

    /**
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * 
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * 
     * @return double
     */
    public function getBudgetAmount()
    {
        return $this->budgetAmount;
    }

    /**
     * 
     * @return string
     */
    public function getSdel()
    {
        return $this->sdel;
    }

    /**
     * 
     * @return string
     */
    public function getCreateBy()
    {
        return $this->createBy;
    }

    /**
     * 
     * @return datetime
     */
    public function getCreateIn()
    {
        return $this->createIn;
    }

    /**
     * 
     * @return string
     */
    public function getUpdateBy()
    {
        return $this->updateBy;
    }

    /**
     * 
     * @return datetime
     */
    public function getUpdateIn()
    {
        return $this->updateIn;
    }

    /**
     * 
     * @param type $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param type $record
     * @return $this
     */
    public function setRecord($record)
    {
        $this->record = $record;
        return $this;
    }

    /**
     * 
     * @param type $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 
     * @param type $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * 
     * @param type $contract
     * @return $this
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
        return $this;
    }

    /**
     * 
     * @param type $comments
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * 
     * @param type $budgetAmount
     * @return $this
     */
    public function setBudgetAmount($budgetAmount)
    {
        $this->budgetAmount = $budgetAmount;
        return $this;
    }

    /**
     * 
     * @param type $sdel
     * @return $this
     */
    public function setSdel($sdel)
    {
        $this->sdel = $sdel;
        return $this;
    }

    /**
     * 
     * @param type $createBy
     * @return $this
     */
    public function setCreateBy($createBy)
    {
        $this->createBy = $createBy;
        return $this;
    }

    /**
     * 
     * @param \App\Modules\Forms\Models\datetime $createIn
     * @return $this
     */
    public function setCreateIn($createIn)
    {
        $this->createIn = $createIn;
        return $this;
    }

    /**
     * 
     * @param type $updateBy
     * @return $this
     */
    public function setUpdateBy($updateBy)
    {
        $this->updateBy = $updateBy;
        return $this;
    }

    /**
     * 
     * @param \App\Modules\Forms\Models\datetime $updateIn
     * @return $this
     */
    public function setUpdateIn($updateIn)
    {
        $this->updateIn = $updateIn;
        return $this;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {

        parent::initialize();

        $this->addBehavior(new SoftDelete([
            'field' => 'sdel',
            'value' => '*'
        ]));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'FRM_PROPOSTA_COMERCIAL';
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public static function columnMap()
    {
        return [
            'ID_FRM_PROPOSTA_COMERCIAL' => 'id',
            'CD_REGISTRO' => 'record',
            'DS_CONTEUDO' => 'content',
            'ST_STATUS' => 'status',
            'CD_CONTRATO' => 'contract',
            'DS_COMENTARIOS' => 'comments',
            'VR_ORCAMENTO' => 'budgetAmount',
            'SDEL' => 'sdel',
            'CREATEBY' => 'createBy',
            'CREATEIN' => 'createIn',
            'UPDATEBY' => 'updateBy',
            'UPDATEIN' => 'updateIn',
        ];
    }

    public static function getDeleted()
    {
        return 'sdel';
    }

    public static function getEmpresas()
    {
        return [
            'MP' => 'MP - MPE',
            'EB' => 'EB - EBE',
            'GE' => 'GE - GEMOM',
            'ME' => 'ME - MPE Engenharia',
            'PC' => 'PC - Paineis',
        ];
    }

    public static function getTipoEdital()
    {
        return [
            'Pregão' => 'Pregão',
            'Leilão' => 'Leilão',
            'Chamada Pública' => 'Chamada Pública',
            'Tomada de Preço' => 'Tomada de Preço',
            'Convite' => 'Convite',
            'Pesquisa de Mercado' => 'Pesquisa de Mercado',
            'Concorrência' => 'Concorrência',
        ];
    }

    public static function getUnidadeOrganizacional()
    {
        return[
            '01' => 'MACAÉ',
            '02' => 'REDUC',
            '03' => 'AIRJ',
            '04' => 'AISP',
            '05' => 'DOCAS SEPETIBA',
            '06' => 'DOCAS PORTO',
            //'07' => 'EM DEFINIÇÃO',
            '08' => 'REPLAN PAULINIA',
            //'09' => 'EM DEFINIÇÃO',
            //'10' => 'EM DEFINIÇÃO',
            //'11' => 'EM DEFINIÇÃO',
            '12' => 'Unidade Corporativa COMERCIAL',
            '13' => 'Unidade Corporativa COMPRAS E APOIO',
            '14' => 'Unidade Corporativa ADMINISTRAÇÃO',
            '15' => 'Unidade Corporativa FINANCEIRO',
            //'16' => 'EM DEFINIÇÃO',
            //'17' => 'EM DEFINIÇÃO',
            '18' => 'Unidade Corporativa SGI',
            //'19' => 'EM DEFINIÇÃO',
            //'20' => 'EM DEFINIÇÃO',
            //'21' => 'EM DEFINIÇÃO',
            //'22' => 'EM DEFINIÇÃO',
            //'23' => 'EM DEFINIÇÃO',
            //'24' => 'EM DEFINIÇÃO',
            '25' => 'CAMPINAS',
            '26' => 'RECAP',
            '27' => 'AEROPORTO DE CONGONHAS',
            //'28' => 'EM DEFINIÇÃO',
            //'29' => 'EM DEFINIÇÃO',
            '30' => 'ANGRA',
            '35' => 'BRASILIA',
            '40' => 'PORTO ALEGRE',
            //'41' => 'EM DEFINIÇÃO',
            //'42' => 'EM DEFINIÇÃO',
            //'43' => 'EM DEFINIÇÃO',
            //'44' => 'EM DEFINIÇÃO',
            '44' => 'VOTORANTIM',
            '45' => 'CASA DE PEDRA / CSN / INB (VOLTA REDONDA)',
            '46' => 'CSA',
            '47' => 'COMPERJ',
            //'48' => 'EM DEFINIÇÃO',
            '49' => 'REVAP',
            '50' => 'AMPLA',
            '51' => 'CACIMBAS',
            //'52' => 'EM DEFINIÇÃO',
            //'53' => 'EM DEFINIÇÃO',
            //'54' => 'EM DEFINIÇÃO',
            '55' => 'TBG',
            '56' => 'RECAP',
            '57' => 'RNEST',
            '60' => 'METRO',
            //'61' => 'EM DEFINIÇÃO',
            //'62' => 'EM DEFINIÇÃO',
            //'63' => 'EM DEFINIÇÃO',
            //'64' => 'EM DEFINIÇÃO',
            '65' => 'MÓDULOS',
        ];
    }

    public static function getRazoesEstrategicas()
    {
        return [
            'Comercial' => 'Comercial',
            'Geográfica' => 'Geográfica',
            'Política' => 'Política',
        ];
        ;
    }

}
