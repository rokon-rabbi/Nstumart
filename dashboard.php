<?php
include_once("includes/functions.php");
if (isLogged() !== 2) {
    header("Location: index.php ");
}
$limit = 10;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

?>
<!DOCTYPE html>

<head>
    <title>nstumart</title>
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <script>
        function getareas(cid) {
            $(document).ready(function() {
                $.get("getAreas.php?cid=" + cid, function(data, status) {
                    $("#areaDiv").html(data);
                });
            });
        }
    </script>
</head>


<body>

    <?php
    drawHeader();
    ?>

    <div class="container">
        <h2 class="m-3">Users Ads </h2>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>AdsID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`AdsID` DESC LIMIT $start_from, $limit  ");
                if (mysqli_num_rows($result) > 1) {
                    //Show them

                    while ($row = mysqli_fetch_array($result)) {
                        echo " <tr '>
                                    <td>{$row['AdsID']}</td>
                                    <td>{$row['UserID']}</td>";

                        echo "<td class='hov'><a href=\"pageads.php?ADS-ID={$row['AdsID']}\">{$row['Title']}</a></td>";


                        echo "<td>{$row['Price']}</td>
                                    <td>{$row['Date']}</td>
                                    <td></a> ";
                        if ($row['Status'] == 1) {
                            echo "<a href='activeordeactive.php?UserID={$row['UserID']}' class='btn btn-danger ml-2 ' >Deactivate<a>";
                        } else if ($row['Status'] == 0) {
                            echo "<a href='activeordeactive.php?UserID={$row['UserID']}' class='btn btn-primary ml-2  ' >Activate<a>";
                        }
                        echo "</td> </tr>";
                    }
                } else {
                    outputMessage("No Account Users found in our Database", 'warning');
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    global $clink;
    $result_db = mysqli_query($clink, "SELECT COUNT(AdsID) FROM advertisments");
    $row_db = mysqli_fetch_row($result_db);
    $total_records = $row_db[0];
    $total_pages = ceil($total_records / $limit);
    /* echo  $total_pages; */

    echo '<ul style="margin-top: 50px;position:relative;z-index:1;" class="pagination justify-content-center">';
    if ($page > 1) {
        echo '<li class="page-item ">
 <a class="page-link" href="dashboard.php?page=' . ($page - 1) . '">Previous</a> 
  </li>';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {

            $active = "active";
        } else {

            $active = "";
        }

        echo '<li class="page-item ' . $active . ' ">
   <a class="page-link" href="dashboard.php?page=' . $i . '">' . $i . '</a> 
    </li>';
    }
    if ($total_pages > $page) {
        echo '<li class="page-item ' . $active . ' ">
 <a class="page-link" href="dashboard.php?page=' . ($page + 1) . '">Next</a> 
  </li>';
    }
    echo '</ul>';

    ?>
    <?php
    include_once("footer.php");
    ?>
    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>

</html>