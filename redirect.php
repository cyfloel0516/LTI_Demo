<?php

session_start();

$url = '';
if($_SESSION['isStudent'])
    $url = '../student-mode';
else if($_SESSION['isInstructor'])
    $url = '../instructor-mode';

?>


<!doctype html>
<html>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        $.post('../api/login2').done(function(response){
            var user = JSON.parse(response);
            var url = '../student-mode';
            if(user.type == 500){
                url = '../instructor-mode';
            }
            window.location.href = url;
        }).error(function(response){
            alert('Some errors occurs while redirect to our application, please try again or contact administrator to solve it.');
        });
    </script>
</html>