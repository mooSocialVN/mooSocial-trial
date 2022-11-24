var mooIndex = function () {

    var doChart = function (e,data){


        function showChartTooltip(x, y, xValue, yValue) {
            $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 40,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff'
            }).appendTo("body").fadeIn(200);
        }

        //var data = [];
        var totalPoints = 250;

// random data generator for plot charts
/*
        function getRandomData() {
            if (data.length > 0) data = data.slice(1);
            // do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50;
                var y = prev + Math.random() * 10 - 5;
                if (y < 0) y = 0;
                if (y > 100) y = 100;
                data.push(y);
            }
            // zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) res.push([i, data[i]])
            return res;
        }

        function randValue() {
            return (Math.floor(Math.random() * (1 + 50 - 20))) + 10;
        }

        var visitors = [
            ['02/2013', 1500],
            ['03/2013', 2600],
            ['04/2013', 1200],
            ['05/2013', 560],
            ['06/2013', 2000],
            ['07/2013', 2350],
            ['08/2013', 1500],
            ['09/2013', 4700],
            ['10/2013', 1300]
        ];

*/
        if (e.length != 0) {

            //$('#site_statistics_loading').hide();
            //$('#site_statistics_content').show();

            var plot_statistics = $.plot(e,
                [{
                    data: data,
                    lines: {
                        fill: 0.6,
                        lineWidth: 0
                    },
                    color: ['#f89f9f']
                }, {
                    data: data,
                    points: {
                        show: true,
                        fill: true,
                        radius: 5,
                        fillColor: "#f89f9f",
                        lineWidth: 3
                    },
                    color: '#fff',
                    shadowSize: 0
                }],

                {
                    xaxis: {
                        tickLength: 0,
                        tickDecimals: 0,
                        mode: "categories",
                        min: 0,
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    yaxis: {
                        ticks: 5,
                        tickDecimals: 0,
                        tickColor: "#eee",
                        font: {
                            lineHeight: 14,
                            style: "normal",
                            variant: "small-caps",
                            color: "#6F7B8A"
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    }
                });

            var previousPoint = null;
            $(e).bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' ' + mooPhrase.__('users'));
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        }


    }

    return {

        //main function to initiate the theme
        init: function (activities,registration) {
            doChart($("#site_activities"),activities);
            doChart($("#site_registration"),registration);
        }
    };
}();