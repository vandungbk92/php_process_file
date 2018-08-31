<?php
     $a = '';
     if(isset($_POST['confirm'])){
        $path = './file_name_search.txt';
             $fp = @fopen($path, "r") or die('file file_name_search không tồn tại');
             $searchTxt = array();
            // Kiểm tra file mở thành công không
            if (!$fp) {
                echo 'file file_name_search.txt không tồn tại';
            }
            else
            {
                // Lặp qua từng dòng để đọc
                while(!feof($fp))
                {
                    array_push($searchTxt, trim(fgets($fp)));
                }

                fclose($fp);
            }

            if(!is_dir('./folder_file_input')){
                echo 'Folder folder_file_input không Tồn Tại';
            }

            if(!is_dir('./folder_file_output')){
                mkdir('./folder_file_output');
            }

            $dir = "./folder_file_input";
            $listFileName = scandir($dir);
            array_shift($listFileName);
            array_shift($listFileName);

            $filesDel = glob('./folder_file_output/*'); // get all file names
            foreach($filesDel as $file){ // iterate files
              if(is_file($file))
                unlink($file); // delete file
            }


            for ($x = 0; $x < count($searchTxt); $x++) {
                $childStr = $searchTxt[$x];
                for($y = 0; $y < count($listFileName); $y++){
                    $mainStr = $listFileName[$y];
                    if(strpos($mainStr, $childStr) !== false){
                        copy('./folder_file_input/'.$mainStr, './folder_file_output/'.$mainStr);
                    }
                }
            }
            $a = '<p class="alert alert-success alertShow" id="alertShow">
                                                            Tìm kiếm dữ liệu thành công, vui lòng kiểm tra folder <em>"folder_file_output"</em></p>';
     }

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>

  <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
  <link rel="stylesheet" href="./asset/css/style.css">

  <script src="./asset/js/jquery-3.1.1.min.js"></script>
  <script src="./asset/js/popper.min.js"></script>
  <script src="./asset/js/bootstrap.bundle.js"></script>
  </script>
  <script>
    $(document).ready(function(){
        $('#classBtn').click(function(){
        console.log('111')
            $('#alertShow').fadeOut(4000)
        })
    })
  </script>

  <style>
    .classBtn{
        margin: auto;
        display: block;
    }
    .alertShow{
        margin-top: 15px;
    }
  </style>

</head>
<body>
  <div class="container">
    <h3>Tìm kiếm file theo string đọc từ file file_name_search.txt</h3>

    <h6>Cấu trúc thư mục</h6>
    <em>- Thư mục "folder_file_input" : Thư mục chứa toàn bộ các file cần tìm kiếm </em><br />
    <em>- Thư mục "folder_file_output" : Thư mục chứa toàn bộ các file sau khi tìm kiếm </em><br />
    <em>- file "file_name_search.txt" : file chứa nội dung các khóa tìm kiếm, đọc dữ liệu theo từng dòng một </em><br />
    <form action="" method="post">
        <input type="submit" value="Tìm kiếm" name="confirm" class="btn btn-primary classBtn" id="classBtn"/>
    </form>
    <?php
        echo $a;
    ?>

  </div>
</body>
</html>