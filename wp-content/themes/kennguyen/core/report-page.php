<?php
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
    add_menu_page( 'Pill', 'Pill', 'manage_options', 'kn-pill', 'admin_pill_page', 'dashicons-tickets');
    add_menu_page( 'Reports', 'Reports', 'manage_options', 'kn-report', 'admin_report_page', 'dashicons-tickets');
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
        <h2>Pill</h2>
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
    $items_per_page = 10;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $items_per_page ) - $items_per_page;
    $result = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );
    ?>
    <div class="wrap">
        <h2>Reports</h2>
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
    </div>
    <h2>Report chart</h2>
    <div id="columnchart_material"></div>
    <div id="piechart"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            let data = google.visualization.arrayToDataTable([
                ['Year', 'Month', 'Year'],
                ['2014', 1000, 400],
                ['2015', 1170, 460],
                ['2016', 660, 1120],
                ['2017', 1030, 540]
            ]);

            let options = {
                chart: {
                    title: 'Company Performance',
                    subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                }
            };

            let chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            let data = google.visualization.arrayToDataTable([
                ['Package', 'Income'],
                ['Month',     11],
                ['Year',      2]
            ]);

            let options = {
                title: 'My Daily Activities'
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
                DATE_FORMAT(wp_order.bought_date,"%d/%m/%Y") AS "timeLine"
                FROM wp_order
                WHERE DATE_FORMAT(wp_order.bought_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(wp_order.bought_date,"%Y-%m") <= "'.$to.'"
                GROUP BY DATE(wp_order.bought_date)
                ORDER BY wp_order.bought_date DESC';
    }

    if ($type == 'week') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                CONCAT(DATE_FORMAT(DATE(wp_order.bought_date + INTERVAL ( - WEEKDAY(wp_order.bought_date)) DAY),"%d/%m/%Y")," ~ ",
                DATE_FORMAT(DATE(wp_order.bought_date + INTERVAL (6 - WEEKDAY(wp_order.bought_date)) DAY),"%d/%m/%Y")) AS timeLine
                FROM wp_order
                WHERE DATE_FORMAT(wp_order.bought_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(wp_order.bought_date,"%Y-%m") <= "'.$to.'"
                GROUP BY WEEK(wp_order.bought_date, 1), YEAR(wp_order.bought_date)
                ORDER BY wp_order.bought_date DESC';
    }

    if ($type == 'month') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                DATE_FORMAT(wp_order.bought_date,"%m/%Y") AS "timeLine"
                FROM wp_order
                WHERE DATE_FORMAT(wp_order.bought_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(wp_order.bought_date,"%Y-%m") <= "'.$to.'"
                GROUP BY MONTH(wp_order.bought_date), YEAR(wp_order.bought_date)
                ORDER BY wp_order.bought_date DESC';
    }

    if ($type == 'quarter') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                CONCAT(DATE_FORMAT(MAKEDATE(YEAR(wp_order.bought_date), 1) + INTERVAL QUARTER(wp_order.bought_date) QUARTER - INTERVAL 1 QUARTER,"%d/%m/%Y")," ~ ",
                DATE_FORMAT(MAKEDATE(YEAR(wp_order.bought_date), 1) + INTERVAL QUARTER(wp_order.bought_date) QUARTER - INTERVAL 1 DAY,"%d/%m/%Y")) AS timeLine
                FROM wp_order
                WHERE DATE_FORMAT(wp_order.bought_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(wp_order.bought_date,"%Y-%m") <= "'.$to.'"
                GROUP BY QUARTER(wp_order.bought_date), YEAR(wp_order.bought_date)
                ORDER BY wp_order.bought_date DESC';
    }

    if ($type == 'year') {
        return 'SELECT * , ROUND(SUM(if(wp_order.package like "Monthly", wp_order.sale_price, 0))) AS incomeMonth,
			ROUND(SUM(if(wp_order.package like "Year", wp_order.sale_price, 0))) AS incomeYear,
                DATE_FORMAT(wp_order.bought_date,"%m/%Y") AS "timeLine"
                FROM wp_order
                WHERE DATE_FORMAT(wp_order.bought_date,"%Y-%m") >= "'.$from.'"
                AND DATE_FORMAT(wp_order.bought_date,"%Y-%m") <= "'.$to.'"
                GROUP BY YEAR(wp_order.bought_date)
                ORDER BY wp_order.bought_date DESC';
    }
}

function usd($string) {
    return $string.' $';
}