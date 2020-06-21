<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
$q = isset($_POST['choice'])? htmlspecialchars($_POST['choice']) : '';
if($q) {
    if($q =='title') {
        //先判断有没有提交值
        $xxm = "";//定义要关键字变量
        $tj = " 1=1 ";
        if (!empty($_POST['title']) && $_POST['title'] != "")//没有值就说明是第一次加载这个页面，没有输入查询条件,点击查询就是查询所有的。有值就按照输入的值查询。
        {
            $xxm = $_POST['title'];//提取关键字
            $tj = " Title like '%{$_POST['title']}%' ";


            $sql = "select Title,PATH,ImageID,Description from travelimage where " . $tj;//把条件拼在查询语句后面，并加上where。
            $result = $conn->query($sql);
            if($result->num_rows == 0){echo '<div class="feedback">No result found.</div>';}
            $attr = $result->fetch_all();

            foreach ($attr as $v) {
                if ($v[0] == NULL) {
                    $v[0] = "Wonderland";
                } else {
                    $newtitle = str_replace($xxm, "<mark>{$xxm}</mark>", $v[0]);
                }//替换关键字

                echo '<div class="box">
        <a href="details.php?id=' . $v[2] . '"><img src="../../travel-images/large/' . $v[1] . '." alt="image" height="150" width="200"></a>
        <div class="words">
        <h4>' . $newtitle . '</h4>
        <p>' . $v[3] . '</p>
        </div>
        </div>';
            }
        }
        else {
            echo '<script>alert("Textarea is empty. Please fill in.");</script>';
            echo '<div class="feedback">Search to get some pics...</div>';
        }//alert

    } else if($q =='description') {
        //先判断有没有提交值
        $xxm = "";//定义要关键字变量
        $tj = " 1=1 ";
        if (!empty($_POST['description']) && $_POST['description'] != "")//没有值就说明是第一次加载这个页面，没有输入查询条件,点击查询就是查询所有的。有值就按照输入的值查询。
        {
            $xxm = $_POST['description'];//提取关键字
            $tj = " Description like '%{$_POST['description']}%' ";

            $sql2 = "select Title,PATH,ImageID,Description from travelimage where " . $tj;//把条件拼在查询语句后面，并加上where。
            $result2 = $conn->query($sql2);
            if($result2->num_rows == 0){echo '<div class="feedback">No result found.</div>';}
            $attr2 = $result2->fetch_all();

            foreach ($attr2 as $v) {
                if ($v[0] == NULL) {
                    $v[0] = "Wonderland";
                }

                $newdescription = str_replace($xxm, "<mark>{$xxm}</mark>", $v[3]);
                //替换关键字

                echo '<div class="box">
        <a href="details.php?id=' . $v[2] . '"><img src="../../travel-images/large/' . $v[1] . '." alt="image" height="150" width="200"></a>
        <div class="words">
        <h4>' . $v[0] . '</h4>
        <p>' . $newdescription . '</p>
        </div>
        </div>';
            }
        }
        else {
            echo '<script>alert("Textarea is empty. Please fill in.");</script>';
            echo '<div class="feedback">Search to get some pics...</div>';
        }//alert
    }
}
else{
    echo '<script>alert("Empty form. Please fill in.");</script>';
    echo '<div class="feedback">Search to get some pics...</div>';
}
//空表单的情况




