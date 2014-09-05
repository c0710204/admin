<?php
// home :: new users line chart 

$sql="SELECT COUNT(*) as n, date(date_joined) as `date` FROM edxapp.auth_user WHERE date_joined > (DATE_SUB(CURDATE(), INTERVAL 15 DAY)) ";
$sql.=" GROUP BY date(date_joined);";

$q=$admin->db()->query($sql) or die($admin->db()->errorInfo()[2]."<hr />$sql");
$count=$q->fetchColumn();

//echo "<pre>$sql\n$count</pre>";

$DAR=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $DAT[]=['y'=>$r['date'], 'item1'=>$r['n']*1];
}
//print_r($DAT);
//echo json_encode($DAT);

$box = new Admin\Box;
$box->type("primary");
$box->icon("fa fa-users");
$box->title("User registration");
echo $box->html("<div class=chart id=line-chart style='height: 200px;'></div>");


?>
<script>
// LINE CHART ** New users


var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: <?php echo json_encode($DAT)?>,
    xkey: 'y',
    ykeys: ['item1'],
    labels: ['New users'],
    lineColors: ['#3c8dbc'],
    hideHover: 'auto'
});

</script>