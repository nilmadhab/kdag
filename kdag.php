<!DOCTYPE html>
<html>
<head>
    <title>Web scrapping 101</title>
    <!-- Latest compiled and minified CSS -->
    <link href=
    "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"
    rel="stylesheet">
    <?php
        require_once('simple_html_dom.php');
        function db_connect(){

    $con = mysqli_connect("localhost","root","25011994","kdag");
    
    // Check connection
    if (mysqli_connect_errno())
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
  
    
    return $con;
}
$conn = db_connect();

    ?>
</head>

<body>
   
    <div class="container">
    <?php 
        function single_page($url){
           $conn = db_connect();
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch ,CURLOPT_PROXY, '10.3.100.207');
            curl_setopt($ch, CURLOPT_PROXYPORT,'8080');
            $page = curl_exec($ch);
            $page = str_get_html($page);
            //echo $page;
            //curl_close($ch);
            $count =0;
            $title = $page->find(".content-article-title",0);
           // echo "<h1> Title </h1>";
           // echo $title->plaintext."<br />";
            $title = mysqli_real_escape_string($conn,$title->plaintext);
           // echo "<h1> date </h1>";
            $date = $page->find(".date",0);
            // echo $date->plaintext."<br />";
              $date = mysqli_real_escape_string($conn,$date->plaintext);
             $content = $page->find(".main-article-content",0);
           //  echo "<h1> content </h1>";
            // echo $content->plaintext."<br />";
              $content = mysqli_real_escape_string($conn,$content->plaintext);
                $sql1 = "INSERT INTO `articles`( `url`, `title`, `date`, `content`) 
                VALUES ('$url','$title','$date','$content')";

                //echo $sql1."<br />";


                if( mysqli_query($conn,$sql1) ) {
                    echo "recoreds inserted sucessfully".$no_insert;//."<br />";
                    //echo "\n";
                    //$no_insert +=1;
                }else{
                    echo $sql1."<br />";
                    echo "\n";
                    echo "insertion failed".mysqli_error($conn);
                    echo "\n";
                }
               // return 0;

        }

       // single_page("http://www.northeasttoday.in/louis-berger-papers-missing-assam-cm-orders-cid-probe/");
        $url = "http://www.northeasttoday.in/category/arunachal-pradesh/";
        $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch ,CURLOPT_PROXY, '10.3.100.207');
            curl_setopt($ch, CURLOPT_PROXYPORT,'8080');
            $page = curl_exec($ch);
            $page = str_get_html($page);
            //echo $page;
            curl_close($ch);
            $count =0;
            $content = $page->find(".main-content-left",0);
             $links = $content->find("h2");
            foreach ($links as $url1) {
                $url = $url1->find("a",0);
                $count +=1;
               // if(!preg_match("/northeasttoday.in/", subject))
                echo $count." : ".$url->plaintext."-->".$url->getAttribute("href")."<br />";

                single_page($url->getAttribute("href"));
            }


    ?>

    </div>
  
</body>
</html>