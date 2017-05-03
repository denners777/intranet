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
                                'required' => 'required']
                            );
                            ?>
                        </div>
                        <!-- /empresa -->

                        <div class="row">
                            <div class="col-md-7">
                                <!-- data -->
                                <div class="form-group fg-line">
                                    <label for="data"><i class="badge bgm-lightgreen">1.2</i> Data de Elaboração <span class="text-danger">*</span></label>
                                    {{ text_field("data", "class" : "form-control fg-input fc-alt datepicker", 'required': 'required', 'value': date('d/m/Y')) }}
                                </div>
                                <!-- /data -->
                            </div>
                            <div class="col-md-5">
                                <!-- hora -->
                                <div class="form-group fg-line">
                                    <label for="hora"><i class="badge bgm-lightgreen">1.3</i> Hora <span class="text-danger">*</span></label>
                                    {{ text_field("hora", "class" : "form-control fg-input fc-alt timePicker", 'required': 'required', 'value': date('h:i')) }}
                                </div>
                                <!-- /hora -->
                            </div>
                        </div>

                        <!-- cliente -->
                        <div class="form-group fg-line">
                            <label for="cliente"><i class="badge bgm-lightgreen">1.4</i> Cliente <span class="text-danger">*</span></label>
                            {{ text_field("cliente", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
                        </div>
                        <!-- /cliente -->
                        <!-- unidadeLocal -->
                        <div class="form-group fg-line">
                            <label for="unidadeLocal"><i class="badge bgm-lightgreen">1.5</i> Unidade/Local <span class="text-danger">*</span></label>
                            {{ text_field("unidadeLocal", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
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
                                        'emptyText' => 'Escolha uma opção',
                                        'emptyValue' => '',
                                        'class' => 'form-control fg-input fc-alt',
                                        'required' => 'required']
                                    );
                                    ?>
                                </div>
                                <!-- /tipoEdital -->
                            </div>
                            <div class="col-md-7">
                                <!-- descEdital -->
                                <div class="form-group fg-line">
                                    <label for="descEdital"><i class="badge bgm-lightgreen">1.7</i> Descrição Edital <span class="text-danger">*</span></label>
                                    {{ text_field("descEdital", "class" : "form-control fg-input fc-alt", 'required': 'required') }}
                                </div>
                                <!-- /descEdital -->
                            </div>
                        </div>
                        <!-- objeto -->
                        <div class="form-group fg-line">
                            <label for="objeto"><i class="badge bgm-lightgreen">1.8</i> Objeto <span class="text-danger">*</span></label>
                            {{ text_area("objeto", "class" : "form-control fg-input fc-alt", 'rows': 4, 'required': 'required') }}
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
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
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
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
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
                                {{ check_field("analisePreliminarExequivel1", "name": "analisePreliminarExequivel[]", "value" : "Técnica / Operacional", 'required': 'required') }}
                                <i class="input-helper"></i>
                                Técnica / Operacional
                            </label>
                            <br />
                            <label class="checkbox checkbox-inline">
                                {{ check_field("analisePreliminarExequivel2", "name": "analisePreliminarExequivel[]", "value" : "Comercial / Financeira") }}
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
                                {{ radio_field("analiseRisco1", "name": "analiseRisco", "value" : "Sim", 'required': 'required') }}
                                <i class="input-helper"></i>
                                Sim
                            </label>
                            <label class="radio radio-inline">
                                {{ radio_field("analiseRisco2", "name": "analiseRisco", "value" : "Não") }}
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
                                'emptyText' => 'Escolha uma opção',
                                'emptyValue' => '',
                                'class' => 'form-control fg-input fc-alt',
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
