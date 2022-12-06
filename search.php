<?php
include_once("includes/functions.php");
$limit = 10;  
if (isset($_GET["page"])) {
	$page  = $_GET["page"]; 
	} 
	else{ 
	$page=1;
	};  
$start_from = ($page-1) * $limit;

?>
<!DOCTYPE html>
<head>
<title>nstumart</title>
<!-- favicon -->

<link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"/> -->
<script>
    

    function getareas(cid){
        $(document).ready(function(){
            $.get("getAreas.php?cid="+cid, function(data, status){
                $("#areaDiv").html(data);
            });
        });
    }

						  
</script>

</head>
<style>
 
.card:hover{
     transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}
ul{
    margin-bottom:200px;
}

</style>

<body>
<?php
drawHeader(1);
?>
<div class="container ">
    <div class="control d-flex  justify-content-around">
        <div class="search text-center">
        <form method="get" action="index.php" class=" ">
                        
                        

                        <select class="select " name="Maincategory">
                        <option value='0'>CategoryName</option>
                            <?php
                            $resultcategories=mysqli_query($clink,"SELECT CategoryID , CategoryName FROM categories");
                            while ($rowcategories=mysqli_fetch_assoc($resultcategories)){
                                echo "<option value='{$rowcategories['CategoryID']}'>{$rowcategories['CategoryName']}</option>";
                            }
                            
                            ?>
                        </select><input type="submit" class="btn clicksearch" value="search">
            </form>
        </div>
    </div>
</div>
<div class='container'>
<div class="btn-group btn-group-justified col-sm-12 m-2">
    <a href="index.php?pricedp" class="btn btnselect ">Lowest price</a>
    <a href="index.php?pricepd" class="btn btnselect ">Highest price</a>
    <a href="index.php?New" class="btn btnselect ">New</a>
  </div>
</div>
<section class="ads">
    <div class="container">
        <div class="row ">
            
        <?php 
                    //Get DB products and display them
                    if (isset($_GET['pricedp'])){
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` ASC  ");
                    }else if (isset($_GET['pricepd'])){
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` DESC ");
                    }else if (isset($_GET['New'])){
                    $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`AdsID` DESC     ");
                    }else if (isset($_GET['Maincategory'] ) AND $_GET['Maincategory'] !=0){
                        $categoryID =$_GET['Maincategory'];
                        $result = mysqli_query($clink, "SELECT * FROM advertisments , categories where categories.CategoryID= $categoryID and advertisments.CategoryID = categories.CategoryID ");
                    }else {
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Details` ASC   ");

                    }
                 if (isLogged() == 1 || isLogged() == 2 ){ 
                    
                 if(isset($_GET['search']))
               {
                        $value=mysqli_real_escape_string($clink,$_GET['search']);
                        $value = str_replace("<", "&lt", $value);
                        $value = str_replace(">", "&gt", $value);
               
                        $query="SELECT *
                        FROM (`advertisments`)
                        WHERE MATCH (`Title`, `Details`) AGAINST ('$value' IN BOOLEAN MODE)
                        OR `Title` LIKE '%$value%' OR `Details` LIKE '%$value%'
                   OR `Price` LIKE '%$value%'";
                        $result = mysqli_query($clink, $query);
            
                      
                    if(mysqli_num_rows($result)>0){
						//Show them

						while($row = mysqli_fetch_assoc($result)){
							if($row['Status'] == 1 || isLogged() == 2 ) {
                                echo "<div class=' col-lg-3 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3 '>
                                <div class='text-center card h-100' > 
                                <a href='pageads.php?ADS-ID={$row['AdsID']}' >
                                <img  class='' src='assets/img/{$row['Image']}' class='card-img-top img-fluid' alt='...'>
                                </a>
                                <span class='float-left'> Tk {$row['Price']}</span>
                                    <div class='card-body p-0'>
                                    <h5 style='display:inline-block' class='card-title'>{$row['Title']}</h5>
                                    <a href='pageads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary more'>More Details</a>
                                    
                                    "; 
                                    
                    
                                    if ($row['Status'] == 1 &&(isLogged() == 2) ){
                                        echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}' class='btn btn-danger ml-2 ' >Hide</a>";
                                    }else if  ($row['Status'] == 0 &&(isLogged() == 2) ) {
                                        echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}'  class='btn btn-primary  ml-2  ' >Show</a>";
    
                                    }
                                    echo" </div> </div></div>";
                            }
                        }
						}else{
						outputMessage("No products found in our catalog",'warning');
					}
                }
            }
            else{
                outputMessage("Login first",'warning');
            }
				?>


        </div>


    </div>
    <?php  
global $clink;
$result_db = mysqli_query($clink,"SELECT COUNT(AdsID) FROM advertisments"); 
$row_db = mysqli_fetch_row($result_db);  
$total_records = $row_db[0];  
$total_pages = ceil($total_records / $limit); 
/* echo  $total_pages; */

echo '<ul style="margin-top: 50px;position:relative;z-index:1" class="pagination justify-content-center">';
if($page > 1)
{        
 echo '<li class="page-item ">
 <a class="page-link" href="index.php?page='.($page - 1).'">Previous</a> 
  </li>';
}
for($i=1; $i<=$total_pages; $i++)
{
 if($i == $page){
          
  $active = "active"; 
 }
 else{
           
  $active = "";
 }
          
 echo '<li class="page-item '.$active.' ">
   <a class="page-link" href="index.php?page='.$i.'">'.$i.'</a> 
    </li>';
}
if($total_pages > $page)
{        
 echo '<li class="page-item '.$active.' ">
 <a class="page-link" href="index.php?page='.($page + 1).'">Next</a> 
  </li>';
}
echo '</ul>';
 
?>
    <?php
    include_once("footer.php");
    ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>