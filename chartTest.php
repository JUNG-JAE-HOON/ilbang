<html>
<head>
<title>My first chart using FusionCharts Suite XT</title>
<script type="text/javascript" src="lib/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="lib/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<script>
    var dataset = [
        {
            "seriesname": "구인중",
            "data": [
                {
                    "value": "0"
                },
                {
                    "value": "5"
                },
                {
                    "value": "7"
                },
                {
                    "value": "0"
                },
                {
                    "value": "0"
                },
                {
                    "value": "4"
                },
                {
                    "value": "0"
                },
                {
                    "value": "5"
                },
                {
                    "value": "6"
                },
                {
                    "value": "45"
                },
                {
                    "value": "0"
                },
                {
                    "value": "4"
                }
            ]
        },
        {
            "seriesname": "구직중",
            "data": [
                {
                    "value": "7"
                },
                {
                    "value": "0"
                },
                {
                    "value": "10"
                },
                {
                    "value": "4"
                },
                {
                    "value": "5"
                },
                {
                    "value": "7"
                },
                {
                    "value": "2"
                },
                {
                    "value": "6"
                },
                {
                    "value": "8"
                },
                {
                    "value": "0"
                },
                {
                    "value": "0"
                },
                {
                    "value": "0"
                }
            ]
        }
    ]

    
	FusionCharts.ready(function(){
      var revenueChart = new FusionCharts({
        "type": "msline",//msline , column2d
        "renderAt": "chartContainer",
        "width": "500",
        "height": "300",
        "dataFormat": "json",
        "dataSource": {
    "chart": {
//        "caption": "Harry's SuperMart - Comparison of yearly sales ",
//        "subcaption": "2015 v 2014",
       "numbernextfix": "건",
        "plotgradientcolor": "",
        "divlinecolor": "CCCCCC",
        "showvalues": "0",
        "captionpadding": "30",
        "palettecolors": "#f8bd19,#008ee4",
//        "plottooltext": " 파란색: 구인중, 노란색: 구인중",
        "theme": "zune",
        "toolTipColor": "#ffffff",
        "toolTipBorderThickness": "0",
            "toolTipBgColor": "#000000",
            "toolTipBgAlpha": "80",
            "toolTipBorderRadius": "2",
            "toolTipPadding": "5"        
    },
    "categories": [
        {
            "category": [
                {
                    "label": "1월"
                },
                {
                    "label": "2월"
                },
                {
                    "label": "3월"
                },
                {
                    "label": "4월"
                },
                {
                    "label": "5월"
                },
                {
                    "label": "6월"
                },
                {
                    "label": "7월"
                },
                {
                    "label": "8월"
                },
                {
                    "label": "9월"
                },
                {
                    "label": "10월"
                },
                {
                    "label": "11월"
                },
                {
                    "label": "12월"
                }
            ]
        }
    ],
    "dataset": dataset
}
    });

    revenueChart.render();
})

</script>
</head>
<body>
<select>
    <option>2016</option>
    <option>2017</option>
</select>
<div id="chartContainer">FusionCharts XT will load here!</div>
</body>
</html>