<?php
if(isset($_COOKIE['username'])){
    echo "
<a href=\"#\" class=\"user\">".$_COOKIE['username']."</a>
            <ul class=\"dropdown\">
                <li><a href=\"upload.php\" id=\"upload\"><i class=\"fa fa-upload fa-fw\" aria-hidden=\"true\"></i>upload</a></li>
                <li><a href=\"photo.html\" id=\"myPhoto\"><i class=\"fa fa-photo fa-fw\" aria-hidden=\"true\"></i>my photos</a></li>
                <li><a href=\"favorites.php\" id=\"myFavor\"><i class=\"fa fa-heart fa-fw\" aria-hidden=\"true\"></i>my favor</a></li>
                <li><a href=\"logout.php\"><i class=\"fa fa-sign-out fa-fw\" aria-hidden=\"true\"></i>log out</a></li>
            </ul>
       
";
}
else {echo "
<li><a href=\"../login.html\" class=\"user\">Log in </a><li>
";}


