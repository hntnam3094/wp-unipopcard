<?php
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
    add_menu_page( 'Pill management', 'Pills', 'manage_options', 'kn-pill', 'admin_pill_page', 'dashicons-tickets');
    add_menu_page( 'Report management', 'Reports', 'manage_options', 'kn-report', 'admin_report_page', 'dashicons-tickets');
    wp_enqueue_script( 'google-charts', get_template_directory_uri() . '/js/google-charts.js', array(), '20151215', false );
}

function admin_pill_page(){
    global $wpdb;

    $from = $_GET['from'] ?? date('Y-m');
    $to = $_GET['to'] ?? date('Y-m');
    $type = $_GET['type'] ?? 'day';

    $query = "SELECT * FROM wp_order";
    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var( $total_query );
    $items_per_page = 10;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $items_per_page ) - $items_per_page;
    $result = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );

    $totalAmount = 0;
    ?>
    <div class="wrap">
        <h2>Pill management</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <label>From</label>
                <input type="month" id="month-from" value="<?=$from?>">
                <label>To</label>
                <input type="month" id="month-to" value="<?=$to?>">
            </div>
            <div class="alignleft actions">
                <label>Report type</label>
                <select style="float: unset" id="select-type-report">
                    <option value="day" <?= $type == 'day' ? 'selected' : ''?>>Day</option>
                    <option value="week" <?= $type == 'week' ? 'selected' : ''?>>Week</option>
                    <option value="month" <?= $type == 'month' ? 'selected' : ''?>>Month</option>
                    <option value="quarter" <?= $type == 'quarter' ? 'selected' : ''?>>Quarter</option>
                    <option value="year" <?= $type == 'year' ? 'selected' : ''?>>Year</option>
                </select>
                <input type="submit" id="btn-report-submit" class="button action" value="Apply">
            </div>
        </div>
        <table class="widefat fixed">
            <thead>
            <tr>
                <th class="manage-column column-columnname" scope="col">No</th>
                <th class="manage-column column-columnname" scope="col">Full name</th>
                <th class="manage-column column-columnname" scope="col">Email</th>
                <th class="manage-column column-columnname" scope="col">Package</th>
                <th class="manage-column column-columnname" scope="col">Bought date</th>
                <th class="manage-column column-columnname num" scope="col">Price</th>
                <th class="manage-column column-columnname num" scope="col">Sale price</th>

            </tr>
            </thead>

            <tbody>
            <?php
            $start = $items_per_page * ($page - 1);
            $no = $start == 0 ? 1 : $start;
            foreach ($result as $value) { $totalAmount += $value->sale_price?>
                <tr class="alternate">
                    <td class="column-columnname"><?= $no++ ?></td>
                    <td class="column-columnname"><?= $value->full_name ?></td>
                    <td class="column-columnname"><?= $value->email ?></td>
                    <td class="column-columnname"><?= $value->package ?></td>
                    <td class="column-columnname"><?= $value->bought_date ?></td>
                    <td class="column-columnname num"><?= usd($value->price) ?></td>
                    <td class="column-columnname num"><?= usd($value->sale_price) ?></td>
                </tr>
            <?php }?>
            </tbody>

            <tfoot>
            <tr>
                <th class="manage-column column-cb check-column" scope="col" colspan="5"></th>
                <th class="manage-column column-columnname" scope="col" style="text-align: right"><strong>Total</strong></th>
                <th class="manage-column column-columnname num" scope="col"><?= $totalAmount ?></th>
            </tr>
            </tfoot>
        </table>
        <?php
        echo paginate_links( array(
            'base' => add_query_arg( 'cpage', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => ceil($total / $items_per_page),
            'current' => $page
        ));
        ?>
    </div>
    <?php
}

function admin_report_page(){
    global $wpdb;

    $from = $_GET['from'] ?? date('Y-m');
    $to = $_GET['to'] ?? date('Y-m');
    $type = $_GET['type'] ?? 'day';

    $query = getQueryReport($type, $from, $to);
    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var( $total_query );
    $items_per_page = 45;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $items_per_page ) - $items_per_page;
    $result = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );
    ?>
    <div class="wrap">
        <h2>Report management</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <label>From</label>
                <input type="month" id="month-from" value="<?=$from?>">
                <label>To</label>
                <input type="month" id="month-to" value="<?=$to?>">
            </div>
            <div class="alignleft actions">
                <label>Report type</label>
                <select style="float: unset" id="select-type-report">
                    <option value="day" <?= $type == 'day' ? 'selected' : ''?>>Day</option>
                    <option value="week" <?= $type == 'week' ? 'selected' : ''?>>Week</option>
                    <option value="month" <?= $type == 'month' ? 'selected' : ''?>>Month</option>
                    <option value="quarter" <?= $type == 'quarter' ? 'selected' : ''?>>Quarter</option>
                    <option value="year" <?= $type == 'year' ? 'selected' : ''?>>Year</option>
                </select>
                <input type="submit" id="btn-report-submit" class="button action" value="Apply">
            </div>
        </div>
        <table class="widefat fixed">
            <thead>
                <tr>
                    <th class="manage-column column-columnname" scope="col">No</th>
                    <th class="manage-column column-columnname" scope="col">Timeline</th>
                    <th class="manage-column column-columnname num" scope="col">Package month income</th>
                    <th class="manage-column column-columnname num" scope="col">Package year income</th>
                    <th class="manage-column column-columnname num" scope="col">Total</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $start = $items_per_page * ($page - 1);
            $no = $start == 0 ? 1 : $start;
            $totalMonthIncome = 0;
            $totalYearIncome = 0;
            $totalIncome = 0;
            foreach ($result as $value) {
                $income = $value->incomeMonth + $value->incomeYear;
                $totalMonthIncome += $value->incomeMonth;
                $totalYearIncome += $value->incomeYear;
                $totalIncome += $income;
                ?>
                <tr class="alternate">
                    <td class="column-columnname"><?= $no++ ?></td>
                    <td class="column-columnname"><?= $value->timeLine ?></td>
                    <td class="column-columnname num"><?= usd($value->incomeMonth) ?></td>
                    <td class="column-columnname num"><?= usd($value->incomeYear) ?></td>
                    <td class="column-columnname num"><?= usd($income) ?></td>
                </tr>
            <?php }?>
            </tbody>

            <tfoot>
            <tr>
                <th class="manage-column column-columnname" scope="col" colspan="2" style="text-align: right"><strong>Total</strong></th>
                <th class="manage-column column-columnname num" scope="col"><?= usd($totalMonthIncome) ?></th>
                <th class="manage-column column-columnname num" scope="col"><?= usd($totalYearIncome) ?></th>
                <th class="manage-column column-columnname num" scope="col"><?= usd($totalIncome) ?></th>
            </tr>
            </tfoot>
        </table>
        <?php
//        echo paginate_links( array(
//            'base' => add_query_arg( 'cpage', '%#%' ),
//            'format' => '',
//            'prev_text' => __('&laquo;'),
//            'next_text' => __('&raquo;'),
//            'total' => ceil($total / $items_per_page),
//            'current' => $page
//        ));
        ?>
        <div id="columnchart_material" style="height: 500px; margin-top: 15px"></div>
        <div id="piechart" style="margin-top: 15px"></div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <?php
    $dataColumnChart = [['Timeline', 'Package month', 'Package year']];
    foreach ($result as $value) {
        array_push($dataColumnChart, [$value->timeLine, $value->incomeMonth, $value->incomeYear]);
    }
    $dataPieChart = [['Package', 'Income']];
    array_push($dataPieChart, ['Package month', $totalMonthIncome]);
    array_push($dataPieChart, ['Package year', $totalYearIncome]);
    ?>

    <script type="text/javascript">
        let listDataColumnChart = <?= json_encode($dataColumnChart) ;?>;
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            let data = google.visualization.arrayToDataTable(listDataColumnChart);

            let options = {
                chart: {
                    title: 'Ken nguyen report',
                    subtitle: 'Package month, year from: <?=$from?>~<?=$to?>',
                }
            };

            let chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

    <script type="text/javascript">
        let listDataPieChart = <?= json_encode($dataPieChart) ;?>;
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            let data = google.visualization.arrayToDataTable(listDataPieChart);

            let options = {
                title: 'Ken nguyen report'
            };

            let chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

    <script>
        document.getElementById('btn-report-submit').onclick = () => {
            const urlParams = new URLSearchParams(window.location.search)
            let monthFrom = document.getElementById('month-from')
            let monthTo = document.getElementById('month-to')
            let typeReport = document.getElementById('select-type-report')
            urlParams.set('from', monthFrom.value);
            urlParams.set('to', monthTo.value);
            urlParams.set('type', typeReport.value);
            window.location.href='?' + urlParams.toString()
        }
    </script>
    <?php
}

function getQueryReport($type, $from, $to) {
    if ($type == 'day') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                DATE_FORMAT(v.start_date,"%d/%m/%Y") AS "timeLine"
                FROM wp_order
                RIGHT JOIN (
                SELECT * FROM (
                  SELECT ADDDATE("1970-01-01", t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                  FROM
                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                ) v1) v ON v.start_date = wp_order.bought_date
                WHERE DATE_FORMAT(v.start_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(v.start_date,"%Y-%m") <= "'.$to.'"
                GROUP BY DATE(v.start_date)
                ORDER BY v.start_date';
    }

    if ($type == 'week') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                CONCAT(DATE_FORMAT(DATE(v.start_date + INTERVAL ( - WEEKDAY(v.start_date)) DAY),"%d/%m/%Y")," ~ ",
                DATE_FORMAT(DATE(v.start_date + INTERVAL (6 - WEEKDAY(v.start_date)) DAY),"%d/%m/%Y")) AS timeLine
                FROM wp_order
                RIGHT JOIN (
                SELECT * FROM (
                  SELECT ADDDATE("1970-01-01", t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                  FROM
                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                ) v1) v ON v.start_date = wp_order.bought_date
                WHERE DATE_FORMAT(v.start_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(v.start_date,"%Y-%m") <= "'.$to.'"
                GROUP BY WEEK(v.start_date, 1), YEAR(v.start_date)
                ORDER BY v.start_date DESC';
    }

    if ($type == 'month') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                DATE_FORMAT(v.start_date,"%m/%Y") AS "timeLine"
                FROM wp_order
                RIGHT JOIN (
                SELECT * FROM (
                  SELECT ADDDATE("1970-01-01", t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                  FROM
                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                ) v1) v ON v.start_date = wp_order.bought_date
                WHERE DATE_FORMAT(v.start_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(v.start_date,"%Y-%m") <= "'.$to.'"
                GROUP BY MONTH(v.start_date), YEAR(v.start_date)
                ORDER BY v.start_date DESC';
    }

    if ($type == 'quarter') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                CONCAT(DATE_FORMAT(MAKEDATE(YEAR(v.start_date), 1) + INTERVAL QUARTER(v.start_date) QUARTER - INTERVAL 1 QUARTER,"%d/%m/%Y")," ~ ",
                DATE_FORMAT(MAKEDATE(YEAR(v.start_date), 1) + INTERVAL QUARTER(v.start_date) QUARTER - INTERVAL 1 DAY,"%d/%m/%Y")) AS timeLine
                FROM wp_order
                RIGHT JOIN (
                SELECT * FROM (
                  SELECT ADDDATE("1970-01-01", t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                  FROM
                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                ) v1) v ON v.start_date = wp_order.bought_date
                WHERE DATE_FORMAT(v.start_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(v.start_date,"%Y-%m") <= "'.$to.'"
                GROUP BY QUARTER(v.start_date), YEAR(v.start_date)
                ORDER BY v.start_date DESC';
    }

    if ($type == 'year') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                DATE_FORMAT(v.start_date,"%Y") AS "timeLine"
                FROM wp_order
                RIGHT JOIN (
                SELECT * FROM (
                  SELECT ADDDATE("1970-01-01", t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                  FROM
                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                ) v1) v ON v.start_date = wp_order.bought_date
                WHERE DATE_FORMAT(v.start_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(v.start_date,"%Y-%m") <= "'.$to.'"
                GROUP BY YEAR(v.start_date)
                ORDER BY v.start_date DESC';
    }
}

function usd($string) {
    return $string.' $';
}