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
        ?>
</head>

<body>
    <div class="container">
          <form action="" method="get" style="width:50%; margin:0 auto;margin-top:08%">
          <div class="form-group">
            <label for="exampleInputEmail1">Enter Url </label>
            <input type="url" name="url" class="form-control" id="exampleInputEmail1" placeholder="Enter url">
          </div>
     
          <button type="submit" name="post" class="btn btn-success">Scrap</button>
        </form>
    </div>
    <div class="container">
    <?php 
        if(isset($_GET['post'])){
           // echo $_GET['url']."<br />";
            $url = $_GET['url'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch ,CURLOPT_PROXY, '10.3.100.207');
            curl_setopt($ch, CURLOPT_PROXYPORT,'8080');
            $page = curl_exec($ch);
            $page = str_get_html($page);
            //echo $page;
            curl_close($ch);
            $count =0;
            $title = $page->find(".content-article-title",0);
            echo "<h1> Title </h1>";
            echo $title->plaintext."<br />";
            echo "<h1> date </h1>";
            $date = $page->find(".date",0);
             echo $date->plaintext."<br />";
             $content = $page->find(".main-article-content",0);
             echo "<h1> content </h1>";
             echo $content->plaintext."<br />";
             
            
        }

    ?>

    </div>
  
</body>
</html>