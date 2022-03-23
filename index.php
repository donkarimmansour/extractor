<?php

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
    set_time_limit(0);
    //  $_SESSION['msg'] = "";

    function extract_emails_from($string)
    {
        preg_match_all("/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i", $string, $matches);
        return $matches[0];
    }

    $text = $_POST["text"];
    $separator = $_POST["separator"];
    $emails = extract_emails_from($text);
    $trimmed = (implode("{$separator}", $emails));

    //  $new = array_unique(explode("{$Delimiter}", $trimmed));
    //  $newemail = implode("{$Delimiter}",$new);
    echo $trimmed;

}else{ // post 



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extractor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body style="background-color: #234f56;">
    

    <!-- Content -->
    <div class="container mt-3 mb-3">


        <div class="card">

        <div class="card-header ">
            <span style="font-weight: bold;">Extractor </span>

            <div style="text-align:center; display: inline-block;">
                <button type="button" class="btn btn-info m-1">
                    total <span class="badge badge-light info" id="total">0</span>
                </button>

                <button type="button" class="btn btn-primary m-1">
                    tested <span class="badge badge-light primary" id="tested">0</span>
                </button>

                <button type="button" class="btn btn-success m-1">
                    Extracted <span class="badge badge-light success" id="Extracted">0</span>
                </button>

                <button type="button" class="btn btn-danger m-1">
                    Duplicate <span class="badge badge-light danger" id="Duplicate">0</span>
                </button>

                <button type="button" class="btn btn-warning m-1">
                    Unique <span class="badge badge-light warning" id="Unique">0</span>
                </button>

            </div>

        </div>

            <div class="card-body">

              
            <form id="form" method="post" enctype="multipart/form-data">

<div class="row">

    <div class="col-sm-12 mb-3">
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" id="progressbar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="separator">Separator</label>
                    <select id="separator" name="separator" class="form-control">
                        <option value="&#13;">New Line</option>
                        <option value="|">|</option>
                        <option value=":">:</option>
                        <option value=";">;</option>
                        <option value=";">;</option>
                        <option value="$">$</option>
                        <option value="*">*</option>
                        <option value="#">#</option>
                        <option value="&">&</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="text" class="control-label mb-1 required">Enter the text/content</label>
                    <textarea id="text" class="form-control" placeholder="Enter the text/content" rows="9"><?php if (isset($_POST["text"])) echo $_POST["text"]; ?></textarea>
                    <small id="list_err" class="form-text text-danger d-none">Please Enter the text/content.</small>

                </div>
            </div>
        </div>
    </div>




    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="okay" class="control-label mb-1 required">Unique</label>
                    <textarea id="okay" class="form-control" placeholder="Unique" rows="6"></textarea>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="form-group">
                    <label for="errors" class="control-label mb-1 required">Duplicate</label>
                    <textarea id="errors" class="form-control" placeholder="Duplicate" rows="4"><?php if (isset($_POST["errors"])) echo $_POST["errors"]; ?></textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-1">
                <button type="submit" id="start" class="btn btn-lg btn-success btn-block">
                    <span>Extract</span>
                </button>
            </div>
            <div class="col-md-6 col-sm-12 mb-1">
                <button type="button" id="stop" class="btn btn-lg btn-danger btn-block">
                    <span>stop</span>
                </button>
            </div>
        </div>
    </div>

</div>

</form>


            </div>

        </div>

    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {


$('#stop').attr('disabled', true);

var Unique = 0;
var Duplicate = 0;
var Extracted = 0;
var tested = 0;

//$('#start').click(function() {
$("#form").submit(function(e) {
    // custom handling here
    e.preventDefault();

    if ($("#text").val() == null || $("#text").val().trim() == "") {
        $("#list_err").removeClass("d-none").addClass("d-block")
        return
    } else {
        $("#list_err").removeClass("d-block").addClass("d-none")


        // audio.play()
        var text = $('#text').val().split('\n');
        var total = text.length;
        $('#total').html(total);

        text.forEach(function(value, index) {
            ajaxCall = $.ajax({
              //  url: '../controller/extractor.php',
                type: 'POST',
                data: $('#form').serialize() + "&text=" + value,

                beforeSend: function() {
                    $('#stop').attr('disabled', null);
                    $('#start').attr('disabled', 'disabled');
                },

                success: function(data) {

                    var newdata = data.split("\n")
                    tested++
                    newdata.forEach((email) => {
                        if (email != "") {

                            if ($("#okay").val().includes(email)) {

                                Duplicate++
                                document.getElementById("errors").innerHTML += email + $("#separator").val();


                            } else {
                                Unique++
                                document.getElementById("okay").innerHTML += email + $("#separator").val();

                            }

                        }

                        var text = $("#text").val().split('\n');
                        text.splice(0, 1);
                        $("#text").val(text.join("\n"));

                    })


                    Extracted = parseInt(Unique) + parseInt(Duplicate);

                    $('#Unique').html(Unique);
                    $('#Duplicate').html(Duplicate);
                    $('#tested').html(tested);
                    $('#Extracted').html(Extracted);

                    var result = Math.ceil((tested / total) * 100);

                    $('#title').html('[' + tested + '/' + total + '] checker');
                    document.getElementById("progressbar").style.width = result + "%";
                    document.getElementById("progressbar").innerText = result + "%";

                    if (tested == total) {
                        $('#start').attr('disabled', null);
                        $('#stop').attr('disabled', 'disabled');
                        // audio.play();
                    }

                }

            }); //end ajax

        }); //end foreach

    }


}); //end onclick


$('#stop').click(function() {
  
    ajaxCall.abort();

    $('#start').attr('disabled', null);
    $('#stop').attr('disabled', 'disabled');
});


});
    </script>

</body>
</html>

<?php } ?>