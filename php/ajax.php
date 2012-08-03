<?php

//from http://blog.arnaud-k.fr/2010/03/08/astuce-jquery-la-fonction-serialize/

if(!empty($_POST)) {
    var_dump($_POST);
    //echo json_encode($_POST);
    exit();
}    

?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
</head>
    <body>
        
        <form class="ajax" action="ajax.php" method="post">
             <p>
                  <label for="name">Name :</label>
                  <input type="text" name="name" id="name" />
             </p>
             <p>
                  <label for="email">Email :</label>
                  <input type="text" name="email" id="email" />
             </p>
             <p>
                  <input type="submit" value="Send" />
             </p>
        </form>


        <div id="output" style="color:red"></div>


        <script type="text/javascript">

        $('form.ajax').submit( function(e) {
            e.preventDefault();
            var data = $(this).serialize(); 
            //var data = $(this).serializeArray();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                dataType: "text",
                //dataType: "json",
                data: data,
                success: function(msg) {
                    $("#output").html(msg);
                    //$("#output").html(msg.name);
                }
            });
        });

        </script>
    </body>
</html>
