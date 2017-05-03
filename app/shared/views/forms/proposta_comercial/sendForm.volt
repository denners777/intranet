{{ content() }}
<table class="table table-bordered table-condensed">
    <caption><h2 style="text-align: center">Proposta Comercial</h2></caption>
    <tbody>
        
        {% for key, campo in campos %}

        {% if campo is null %}
        {% continue %}
        {% endif %}
        
        {% if key == 'Análise Preliminar Exequível' %}
        <tr>
            <th style="border: 1px solid #CCC">{{ key }} : </th>
            <td style="border: 1px solid #CCC">
                {% for c in campo %}
                {{ c }} <br />
                {% endfor %}
            </td>
        </tr>
        {% continue %}
        {% endif %}

        <tr>
            <th style="border: 1px solid #CCC">{{ key }} : </th>
            <td style="border: 1px solid #CCC">{{ campo|nl2br }}</td>
        </tr>
        {% endfor %}
    </tbody>
</table>