var D3Charts = function () {

    // Run D3 Charts
    var runD3Charts = function () {

       // D3 charts colors
        var Colors = [bgPrimary, bgSuccess, bgInfo, bgWarning, bgAlert, bgDanger, bgSystem];

        // Line Chart
        var chart1 = c3.generate({
        	bindto: '#line-chart',
          color: {
            pattern: Colors
          },
          point: {
            r: 3
          },
          padding: {
            left: 30,
            right: 30,
            top: 0,
            bottom: 0
          },
          data: {
            columns: [
                ['data1', 200, 240, 280, 300, 120, 0],
                ['data2', 90, 110, 130, 220, 190, 20]
            ],
            axes: {
              data1: 'y',
              data2: 'y2'
            }
          },
          axis: {
            x: {
              label: 'X Axis'
            },
            y: {
              label: {
                text: 'Y Axis',
                position: 'outer-middle'
              }
            },
            y2: {
              show: true,
              label: {
                text: 'Y2 Axis',
                position: 'outer-middle'
              }
            }
          }
        });
        // Area Chart
        var chart2 = c3.generate({
            bindto: '#area-chart',
            color: {
              pattern: Colors
            },
            padding: {
            left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['data1', 200, 240, 280, 300, 120, 0],
                    ['data2', 90, 110, 130, 220, 190, 20]
                ],
                types: {
                    data1: 'area',
                    data2: 'area-spline'
                }
            }
        });

        var chart21 = c3.generate({
            bindto: '#area-chart1',
            color: {
                pattern: [bgSuccess,bgWarning,bgPrimary]
            },
            padding: {
                left: 30,
                right: 15,
                top: 0,
                bottom: 0
            },
            data: {
                columns: [
                    ['California', 50, 80, 90, 100, 70, 80],
                    ['Texas', 10, 20, 60, 80, 50, 40],
                    ['Florida', 0, 50, 40, 30, 10, 0]
                ],
                types: {
                    California: 'area',
                    Texas: 'area',
                    Florida: 'area'
                }
            }
        });

        var chart22 = c3.generate({
            bindto: '#area-chart2',
            color: {
                pattern: [bgSuccess,bgWarning,bgPrimary]
            },
            padding: {
                left: 30,
                right: 15,
                top: 0,
                bottom: 0
            },
            data: {
                columns: [
                    ['iPhone', 1150, 1180, 1190, 1000, 1070, 1800, 1150, 1180, 1190, 1000, 1070, 1800],
                    ['iPad', 910, 1020, 760, 1080, 850, 940, 910, 1020, 760, 1080, 850, 940],
                    ['iMac', 1000, 1050, 940, 830, 1010, 890, 1000, 1050, 940, 830, 1010, 890]
                ],
                types: {
                    iPhone: 'area',
                    iPad: 'area',
                    iMac: 'area'
                }
            }
        });


        // Step Chart
        var chart3 = c3.generate({
            bindto: '#step-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['data1', 200, 240, 280, 300, 120, 0],
                    ['data2', 90, 110, 130, 220, 190, 20]
                ],
                types: {
                    data1: 'step',
                    data2: 'area-step'
                }
            }
        });


        // Bar Chart
        var chart4 = c3.generate({
            bindto: '#bar-chart',
            color: {
              pattern: Colors
            },
            padding: {
            left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['data1', 200, 240, 280, 300, 120, 0],
                    ['data2', 90, 110, 130, 220, 190, 20]
                ],
                type: 'bar'
            },
            bar: {
                width: {
                    ratio: 0.5
                }
            }
        });
        setTimeout(function () {
            chart4.load({
                columns: [
                    ['data3', 95, -120, 100, 200, -150, 95]
                ]
            });
        }, 1000);


        // TimeSeries Chart
        var chart5 = c3.generate({
            bindto: '#timeseries-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                x: 'x',
                columns: [
                    ['x', '2013-01-01', '2013-01-02', '2013-01-03', '2013-01-04', '2013-01-05', '2013-01-06'],
                    ['data1', 200, 240, 280, 300, 120, 0],
                    ['data2', 90, 110, 130, 220, 190, 20]
                ]
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: '%Y-%m-%d'
                    }
                }
            }
        });

        // Scatter Chart
        var chart6 = c3.generate({
            bindto: '#scatter-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                xs: {
                    setosa: 'setosa_x',
                    versicolor: 'versicolor_x'
                },
                columns: [
                    ["setosa_x", 3.5, 3.0, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.4, 3.9, 3.5, 3.8, 3.2, 3.1, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.0, 3.8, 3.2, 3.7, 3.3],
                    ["versicolor_x", 3.2,  2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6],
                    ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.2],
                    ["versicolor", 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                ],
                type: 'scatter'
            },
            axis: {
                x: {
                    label: 'Sepal.Width',
                    tick: {
                        fit: false
                    }
                },
                y: {
                    label: 'Petal.Width'
                }
            }
        });

        // Spline Chart
        var chart7 = c3.generate({
            bindto: '#spline-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['data1', 200, 240, 280, 300, 120, 0],
                    ['data2', 90, 110, 130, 220, 190, 20]
                ],
                type: 'spline'
            }
        });


        // SubNav Chart
        var chart8 = c3.generate({
            bindto: '#subnav-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 25,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['sample', 200, 240, 280, 300, 120, 0]
                ]
            },
            subchart: {
                show: true
            }
        });


        // Zoom Chart
        var chart9 = c3.generate({
            bindto: '#zoom-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['sample', 100, 150, 250, 150, 200, 170, 170, 250, 300, 270, 140, 150, 90, 150, 50, 120, 70, 240, 30, 200, 30, 200, 100, 400, 150, 250, 150, 200, 170, 240, 350, 150, 100, 400, 350, 220, 240, 350, 150, 100, 400, 150, 250, 150, 200, 170, 240, 100, 400, 150, 250, 150, 200, 40]
                ]
            },
            zoom: {
                enabled: true
            }
        });


        // Donut Chart
        var chart10 = c3.generate({
            bindto: '#donut-chart',
            color: {
              pattern: Colors
            },
            data: {
                columns: [
                    ['data1', 44],
                    ['data2', 111]
                ],
                type : 'donut',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            donut: {
                title: "Google trends"
            }
        });

        var chart101 = c3.generate({
            bindto: '#donut-chart1',
            color: {
              pattern: [bgDangerLr, bgSuccessLr, bgPrimaryLr]
            },
            data: {
                columns: [
                    ['Chrome', 50],
                    ['Firefox', 40],
                    ['IE', 10]
                ],
                type : 'donut',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            donut: {
                title: ""
            }
        });


        // Guage Chart
        var chart11 = c3.generate({
            bindto: '#guage-chart',
            color: {
              pattern: Colors,
              threshold: {
                 values: [25, 50, 75, 100]
              }
            },
            data: {
                columns: [
                    ['data', 88.8]
                ],
                type: 'gauge',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            gauge: {},
            size: {
                height: 180
            }
        });
        var chart112 = c3.generate({
            bindto: '#guage-chart2',
            color: {
              pattern: Colors,
              threshold: {
                 values: [25, 50, 75, 100]
              }
            },
            data: {
                columns: [
                    ['data', 95.9]
                ],
                type: 'gauge',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            gauge: {

            },
            size: {
                height: 150
            }
        });
        var chart113 = c3.generate({
            bindto: '#guage-chart3',
            color: {
              pattern: Colors,
              threshold: {
                 values: [25, 50, 75, 100]
              }
            },
            data: {
                columns: [
                    ['data', 40.1]
                ],
                type: 'gauge',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            },
            gauge: {

            },
            size: {
                height: 150
            }
        });


        // Pie Chart
        var chart12 = c3.generate({
            bindto: '#pie-chart',
            color: {
              pattern: Colors
            },
            data: {
                columns: [
                    ['data1', 50],
                    ['data2', 100]
                ],
                type : 'pie',
                onclick: function (d, i) { console.log("onclick", d, i); },
                onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                onmouseout: function (d, i) { console.log("onmouseout", d, i); }
            }
        });


        // Combo Chart
        var chart13 = c3.generate({
            bindto: '#combo-chart',
            color: {
              pattern: Colors
            },
            padding: {
              left: 30,
              right: 15,
              top: 0,
              bottom: 0
           },
            data: {
                columns: [
                    ['data1', 210, 240, 280, 300, 120, 0],
                    ['data2', 86, 110, 130, 220, 190, 20],
                    ['data3', 77, 250, 250,300, 200, 160],
                    ['data4', 210, 240, 130, 220, 130, 90],
                    ['data5', 140, 140, 130, 120, 160, 150],
                    ['data6', 95, 70, 20, 110, 50, 60]
                ],
                type: 'bar',
                types: {
                    data3: 'spline',
                    data4: 'line',
                    data6: 'area'
                },
                groups: [
                    ['data1','data2']
                ]
            }
        });

    };
    return {
        init: function () {
        	runD3Charts();
        }
    };
}();