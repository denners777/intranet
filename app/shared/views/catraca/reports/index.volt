{{ content() }}

<div id="errors" class="text-danger"></div>

<div class="card">
    <div class="card-header">
        <h2>Relatório Catraca <small>Digite a informação desejada ou deixe em branco para buscar escolhendo um range de datas.</small></h2>
    </div>
    <div class="card-body card-padding">
        <div class="row">
            {{ form('catraca/reports/', 'role': 'form', 'method': 'post', 'autocomplete': 'off', 'onsubmit': 'overlay(true)') }}
            <div class="col-sm-3">
                <div class="form-group fg-line">
                    <label class="fg-label" for="pesquisa">Pesquisa</span></label>
                    {{ text_field("pesquisa", "class" : "form-control fg-input fc-alt") }}
                </div>

            </div>
            <div class="col-sm-3">
                <div class="input-group fg-line">
                    <label class="fg-label" for="dateFrom">Data de</label>
                    {{ text_field("dateFrom", "class" : "form-control datepicker fg-input fc-alt", "required": "required") }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group fg-line">
                    <label class="fg-label" for="dateTo">Data até</label>
                    {{ text_field("dateTo", "class" : "form-control datepicker fg-input fc-alt") }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group fg-line">
                    <label for="type">Tipo</label>
                    {{ select_static('type', types, "useEmpty" : true, "emptyText"  : "Escolha uma opção", "emptyValue" : "", "class" : "form-control datepicker fg-input fc-alt", "required": "required") }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-sm-offset-11">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm m-t-5 waves-effect">Busca</button>
                </div>
            </div>
            {{ end_form() }}
        </div>
    </div>
</div>
{% if pesquisa is not empty %}
<div class="card">
    <div class="card-header">
        Resultado para pesquisa: <span class="text-danger">{{ pesquisa }}</span>
        <ul class="actions">
            {% if export %}
            <li>
                {{ link_to('catraca/reports/export?obj=catraca&type=excel&search='~pesquisa, '<i class="fa fa-file-excel-o c-green" aria-hidden="true"></i>', 'class': 'tooltips', 'title': 'Exportar para Excel', 'target': '_new') }}
            </li>
            <li>
                {{ link_to('catraca/reports/export?obj=catraca&type=pdf&search='~pesquisa, '<i class="fa fa-file-pdf-o c-red" aria-hidden="true"></i>', 'class': 'tooltips', 'title': 'Exportar para PDF', 'target': '_new') }}
            </li>
            {% endif %}
        </ul>
        <br />
        <br />
        <p><b><span class="text-danger">*</span> Horário de Almoço:</b> 11:30 às 14:30</p>
    </div>
    
    <div class="card-body card-padding">
        <div class="table-responsive">
            <table class="table table-striped table-vmiddle datatable">
                <thead>
                    <tr>
                        <th data-column-id="empres">Empresa</th>
                        <th data-column-id="nome">Nome</th>
                        <th data-column-id="cpf">CPF</th>
                        <th data-column-id="secao">Seção</th>
                        <th data-column-id="data">Data</th>
                        {% if type == 'Analítico' %}
                        <th data-column-id="HORA">Hora</th>
                        <th data-column-id="TIPO">Ação</th>
                        {% else %}
                        <th data-column-id="primeiraBatida">1ª Bat</th>
                        <th data-column-id="ultimaBatida">U. Bat</th>
                        <th data-column-id="cargaHoraria">Carga Hor.</th>
                        <th data-column-id="permanencia">Permanência</th>
                        <th data-column-id="ausencia">Ausência</th>
                        <th data-column-id="almoco">Almoço</th>
                        {% endif %}
                    </tr>
                </thead>
                <tbody>
                    {% for movimento in movimentos %}
                    
                    {% if type == 'Analítico' %}
                    <tr>
                        <td>{{ movimento.EMPRESA }}</td>
                        <td>{{ movimento.NOME }}</td>
                        <td>{{ movimento.CPF }}</td>
                        <td>{{ movimento.SECAO }}</td>
                        <td>{{ movimento.DATA }}</td>
                        <td>{{ movimento.HORA }}</td>
                        <td>{{ movimento.TIPO }}</td>
                    </tr>
                    {% else %}
                    <tr>
                        <td>{{ movimento['empresa'] }}</td>
                        <td>{{ movimento['nome'] }}</td>
                        <td>{{ movimento['cpf'] }}</td>
                        <td>{{ movimento['secao'] }}</td>
                        <td>{{ movimento['data'] }}</td>
                        <td>{{ movimento['primeiraBatida'] }}</td>
                        <td>{{ movimento['ultimaBatida'] }}</td>
                        <td>{{ movimento['cargaHoraria'] }}</td>
                        <td>{{ movimento['permanencia'] }}</td>
                        <td>{{ movimento['ausencia'] }}</td>
                        <td>{{ movimento['almoco'] }}</td>
                    </tr>
                    {% endif %}
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>
{% endif %}