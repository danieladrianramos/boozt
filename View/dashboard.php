<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Boozt Test</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Dashboard</h1>
                <p><?php echo $message; ?></p>
            </div>
        </div>
    </div>

    <div class="container pt-4">
        <h3>General</h3>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <strong>#Orders</strong>
                        <p><?php echo $orderCount; ?></p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <strong>#Customers</strong>
                        <p><?php echo $customerCount; ?></p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <strong>Revenue</strong>
                        <p><?php echo $revenue; ?> U$S</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <figure class="highcharts-figure">
                            <div id="highcharts-container"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5">
        <h3>Statistics</h3>
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label>From:</label>
                        <input type="date" name="from" id="from" value="<?php echo $from; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>To:</label>
                        <input type="date" name="to" id="to" value="<?php echo $to; ?>" class="form-control">
                    </div>

                    <button id="stadisticsBtn" class="btn btn-primary btn-lg btn-block">Submit</button>
                </form>

                <div id="target" class="pt-3">
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script>
    Highcharts.chart('highcharts-container', {
        chart: {
            type: 'line'
        },
        title: {
            text: '<?php echo $chartTitle; ?>'
        },
        xAxis: {
            categories: ['<?php echo $chartLabelX; ?>']
        },
        yAxis: {
            title: {
                text: '<?php echo $chartLabelY; ?>'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
            <?php
            $series = [];
            foreach ($chartSeries as $name => $values) {
                $series[] = "{name: '". $name ."', data: [". implode(",", $values) ."]}";
            }
            echo implode(",", $series);
            ?>
        ]
    });

    // --------------------------------------------------------------------------------

    $("#stadisticsBtn").click(function(e) {
        e.preventDefault();

        if (($("#from").val() != "") && ($("#to").val() != "")) {
            var formData = {
                from: $("#from").val(),
                to: $("#to").val()
            }

            $('#target').html('sending..');

            $.ajax({
                url: '/ajax',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                success: function (response) {
                    console.log(response);

                    var header = `
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">PurchaseDate</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Device</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    var footer = `
                            </tbody>
                        </table>
                    `;

                    var rows = "";

                    var revenue = 0;
                    var orderCount = 0;
                    var customerCount = 0;
                    var lastCustomerId = null;

                    response.forEach((order) => {
                        total = 0;
                        order.items.forEach((item) => {
                            total += item.price * item.quantity;
                        });
                        
                        rows += `
                            <tr>
                                <th scope="row">${order.id}</th>
                                <td>${order.customer.lastName}</td>
                                <td>${order.purchaseDate}</td>
                                <td>${order.country}</td>
                                <td>${order.device}</td>
                                <th>${total} U$S</th>
                            </tr>
                        `;

                        if (order.customerId != lastCustomerId) {
                            lastCustomerId = order.customerId;
                            customerCount++;
                        }

                        revenue += total;
                        orderCount++;
                    });

                    var general = `
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <strong>#Orders</strong>
                                <p>${orderCount}</p>
                            </div>
                            <div class="col-sm-4 text-center">
                                <strong>#Customers</strong>
                                <p>${customerCount}</p>
                            </div>
                            <div class="col-sm-4 text-center">
                                <strong>Revenue</strong>
                                <p>${revenue} U$S</p>
                            </div>
                        </div>
                    `;

                    $('#target').html(general + header + rows + footer);
                },
                data: JSON.stringify(formData)
            });
        }
    });

    $("document").ready(function() {
        $("#stadisticsBtn").trigger('click');
    });
</script>