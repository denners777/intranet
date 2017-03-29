<!DOCTYPE html>
<html>
    <head>
        <title>Intranet :: Exportar PDF :: Grupo MPE</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="{{ static_url('assets/css/pdf.css') }}" rel="stylesheet">
    </head>
    <body>

        <div class="card">
            <div class="card-header">
                <div class="page-header">
                    <h2>Relatório de Chamados</h2>
                    <?php foreach ($header as $key => $value) : ?>
                        <h5>{{ value[0] }}<small>{{ value[1] }}</small></h5>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-body">

                {% for dado in dados %}
                    {% if loop.first %}
                    <table class="table table-striped table-vmiddle datatable bootgrid-table">
                        <thead>
                            <tr>
                                {% for value in dado %}
                                <th>{{ value }}</th>
                                {% endfor %}
                            </tr>
                        </thead>
                        <tbody>
                     {% else %}
                            <tr>
                                {% for index, value in dado %}
                                <td>{{ value }}</td>
                                {% endfor %}
                            </tr>
                    {% endif %}
                    {% if loop.last %}
                        </tbody>
                    </table>
                    {% endif %}
                {% endfor %}
            </div>
        </div>
    </body>
</html>