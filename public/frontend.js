var apiUrl = "http://localhost:8000/v1/countries";

google.load('visualization', '1.1', {'packages': ['geochart']});

function processData(apiData)
{
    chartData = [];

    chartData[0] = [
        'Country',
        'Value',
        'Tooltip'
    ];

    for (var i = 0; i < apiData.length; i++)
    {
        tooltip =
                'Total number of messages: ' + apiData[i].messageCount + "\n" +
                'Top currency pair: ' + apiData[i].topCurrencyPair + "\n" +
                'Top pair average rate: ' + apiData[i].topCurrencyPairAvgRate + "\n" +
                'Top pair number of messages: ' + apiData[i].topCurrencyPairMsgCnt + "\n" +
                'Top pair messages share: ' + apiData[i].topCurrencyPairMsgShare + "\n";

        chartData[i + 1] = [
            apiData[i].countryName,
            apiData[i].messageCount,
            tooltip
        ];
    }

    return chartData;
}

function drawData(chartData) {
    table = google.visualization.arrayToDataTable(chartData);
    view = new google.visualization.DataView(table);
    view.setColumns([0, 1, {sourceColumn: 2, role: 'tooltip'}]);

    options = {
        tooltip: {
            showTitle: true
        }
    };

    chart = new google.visualization.GeoChart(document.getElementById('chart'));
    chart.draw(view, options);
}

function update()
{
    $.ajax({
        cache: false,
        timeout: 10000,
        type: 'get',
        tryCount: 0,
        retryLimit: 3,
        url: apiUrl,
        beforeSend: function () {
            $('#button').text('Loading ...');
        },
        success: function (rcvData, textStatus, xhr) {
            drawData(processData(rcvData.data));
            $('#button').text('Refresh chart');
        },
        error: function (xhr, textStatus, errorThrown) {
            if (textStatus == 'timeout') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                return;
            }

            alert("Error no. " + xhr.status + " - " + xhr.statusText);
            $('#button').text('Error. Refresh chart again.');
        }

    });
}

$(function () {
    update();

    $('#button').on('click', function () {
        update();
    });

});
