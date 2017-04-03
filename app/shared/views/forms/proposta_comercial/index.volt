{{ content() }}

<div class="card">
    <div class="card-header">
        <h2>Proposta Comercial <small>Preencha as informações para realizar a solicitação desejada.</small></h2>
    </div>

    <div class="card-body card-padding">
        <div class="form-wizard-basic fw-container">
            {{ form("forms/proposta_comercial/sendForm", "method":"post", "autocomplete" : "off", 'onsubmit': 'overlay(true);') }}
            <fieldset class="well well-alt">
                <legend><span class="badge bgm-green">1.0</span> Dados Gerais</legend>
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <!-- empresa -->
                        <div class="form-group">
                            <label for="empresa"><i class="badge bgm-lightgreen">1.1</i> Empresa <span class="text-danger">*</span></label>
                            <?php
                            echo $this->tag->selectStatic(['empresa',
                                $empresas,
                                'useEmpty' => true,
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
                                'name' => 'Empresa',
                                'required' => 'required']
                            );
                            ?>
                        </div>
                        <!-- /empresa -->
                        <!-- data | hora -->
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group fg-line">
                                    <label for="data"><i class="badge bgm-lightgreen">1.2</i> Data de Elaboração <span class="text-danger">*</span></label>
                                    {{ text_field("data", "name": "Data de Elaboração", "class" : "form-control fg-input fc-alt datepicker", 'required': 'required', 'value': date('d/m/Y')) }}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group fg-line">
                                    <label for="hora"><i class="badge bgm-lightgreen">1.3</i> Hora <span class="text-danger">*</span></label>
                                    {{ text_field("hora", "name": "Hora", "class" : "form-control fg-input fc-alt timePicker", 'required': 'required', 'value': date('h:i')) }}
                                </div>
                            </div>
                        </div>
                        <!-- /data | hora -->
                        <!-- cliente -->
                        <div class="form-group fg-line">
                            <label for="cliente"><i class="badge bgm-lightgreen">1.4</i> Cliente <span class="text-danger">*</span></label>
                            {{ text_field("cliente", "name": "Cliente", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
                        </div>
                        <!-- /cliente -->
                        <!-- unidadeLocal -->
                        <div class="form-group fg-line">
                            <label for="unidadeLocal"><i class="badge bgm-lightgreen">1.5</i> Unidade/Local <span class="text-danger">*</span></label>
                            {{ text_field("unidadeLocal", "name": "Unidade/Local", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
                        </div>
                        <!-- /unidadeLocal -->
                        <div class="row">
                            <div class="col-md-5">
                                <!-- tipoEdital -->
                                <div class="form-group">
                                    <label for="tipoEdital"><i class="badge bgm-lightgreen">1.6</i> Tipo Edital <span class="text-danger">*</span></label>
                                    <?php
                                    echo $this->tag->selectStatic(['tipoEdital',
                                        $tipoEdital,
                                        'useEmpty' => true,
                                        'name' => 'Tipo Edital',
                                        'emptyText' => 'Escolha uma opção',
                                        'emptyValue' => '',
                                        'class' => 'form-control fg-input fc-alt',
                                        'name' => 'Tipo Edital',
                                        'required' => 'required']
                                    );
                                    ?>
                                </div>
                                <!-- /tipoEdital -->
                            </div>
                            <div class="col-md-7">
                                <!-- descEsital -->
                                <div class="form-group fg-line">
                                    <label for="descEsital"><i class="badge bgm-lightgreen">1.7</i> Descrição Edital <span class="text-danger">*</span></label>
                                    {{ text_field("descEsital", "name": "Descrição Edital", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
                                </div>
                                <!-- /descEsital -->
                            </div>
                        </div>
                        <!-- objeto -->
                        <div class="form-group fg-line">
                            <label for="objeto"><i class="badge bgm-lightgreen">1.8</i> Objeto <span class="text-danger">*</span></label>
                            {{ text_area("objeto", "name": "Objeto", "class" : "form-control fg-input fc-alt", 'rows': 4, 'required': 'required') }}
                        </div>
                        <!-- /objeto -->
                    </div>

                    <div class="col-md-5">
                        <!-- unidadeOrganizacional -->
                        <div class="form-group">
                            <label for="unidadeOrganizacional"><i class="badge bgm-lightgreen">1.9</i> Unidade Organizacional <span class="text-danger">*</span></label>
                            <?php
                            echo $this->tag->selectStatic(['unidadeOrganizacional',
                                $unidadeOrganizacional,
                                'useEmpty' => true,
                                'name' => 'Tipo Edital',
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
                                'name' => 'Unidade Organizacional',
                                'required' => 'required']
                            );
                            ?>
                        </div>
                        <!-- /unidadeOrganizacional -->

                        <!-- razoesEstrategicas -->
                        <div class="form-group">
                            <label for="razoesEstrategicas"><i class="badge bgm-lightgreen">1.10</i> Razões Estratégicas <span class="text-danger">*</span></label>
                            <?php
                            echo $this->tag->selectStatic(['razoesEstrategicas',
                                $razoesEstrategicas,
                                'useEmpty' => true,
                                'name' => 'Tipo Edital',
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
                                'name' => 'Razões Estratégicas',
                                'required' => 'required']
                            );
                            ?>
                        </div>
                        <!-- /razoesEstrategicas -->

                        <!-- analisePreliminarExequivel -->
                        <div class="form-group m-r-15">
                            <label for="analisePreliminarExequivel"><i class="badge bgm-lightgreen">1.11</i> Análise Preliminar Exequível <span class="text-danger">*</span></label>
                            <br />
                            <label class="checkbox checkbox-inline">
                                {{ check_field("analisePreliminarExequivel1", "name": "Análise Preliminar Exequível[]", "value" : "Técnica / Operacional") }}
                                <i class="input-helper"></i>
                                Técnica / Operacional
                            </label>
                            <br />
                            <label class="checkbox checkbox-inline">
                                {{ check_field("analisePreliminarExequivel2", "name": "Análise Preliminar Exequível[]", "value" : "Comercial / Financeira") }}
                                <i class="input-helper"></i>
                                Comercial / Financeira
                            </label>
                            <p class="help-block"></p>
                        </div>
                        <!-- /analisePreliminarExequivel -->

                        <!-- analiseRisco -->
                        <div class="form-group m-r-15">
                            <label for="analiseRisco"><i class="badge bgm-lightgreen">1.12</i> Análise de Risco <span class="text-danger">*</span></label>
                            <br />
                            <label class="radio radio-inline">
                                {{ radio_field("analiseRisco1", "name": "Análise de Risco", "value" : "Sim") }}
                                <i class="input-helper"></i>
                                Sim
                            </label>
                            <label class="radio radio-inline">
                                {{ radio_field("analiseRisco2", "name": "Análise de Risco", "value" : "Não") }}
                                <i class="input-helper"></i>
                                Não
                            </label>
                            <p class="help-block"></p>
                        </div>
                        <!-- /analiseRisco -->

                        <!-- responsavel -->
                        <div class="form-group">
                            <label for="responsavel"><i class="badge bgm-lightgreen">1.13</i> Responsável <span class="text-danger">*</span></label>
                            <?php
                            echo $this->tag->selectStatic(['responsavel',
                                $responsavel,
                                'useEmpty' => true,
                                'name' => 'Tipo Edital',
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
                                'name' => 'Responsável',
                                'required' => 'required']
                            );
                            ?>
                        </div>
                        <!-- /responsavel -->

                    </div>
                </div>
            </fieldset>
            <div class="form-group clearfix">
                <button type="submit" class="btn btn-success pull-right">Enviar</button>
            </div>
            {{ end_form() }}
        </div>
    </div>
</div>
