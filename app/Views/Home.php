<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>swapi App </title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/dist/js/bootstrap.min.js"></script>
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    body {
        background: url('/star-wars-backgrounds-25.jpg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        background-size: cover;
        -o-background-size: cover;
    }
</style>
<div class="container ">
    <div class="row-cols-2 text-center align-items-center justify-content-center w-50">

        <img src="/star_wars_logo_PNG34.png" class="card-img center-block " alt="...">

    </div>
    <div class="row text-center align-items-center justify-content-center">
        <div class="col-12">
            <h3 class="text-white" id="selectionString"> Select 3 Characters!</h3>
        </div>
        <div class="col-12">
            <input type="hidden" name="Download" id="download" value="DOWNLOAD" class="btn-success">
            <input type="hidden" name="reset" id="reset" value="RESET" class="btn-danger">
        </div>

    </div>

    <div class="row">
        <?php
        $id = 0;
        foreach ($characters['data']['name'] as $v){
            echo "<div class=\"col-4 p-1\">
            <div class=\"card characters test\" id='characterDiv".$id."'>
                <input type='hidden' name='characterURL".$id."'  id='characterURL".$id."' value='".$characters["data"]["url"][$id]."'>
                <div class=\"row no-gutters\">
                    <div class=\"col-4 border-right\">
                        <img src=\"/images.png\" class=\"card-img-top\"/>
                    </div>
                    <div class=\"col-8 card-body text-center tf\">
                        <h5 id='characterID".$id."'> $v</h5>
                    </div>
                </div>
            </div>
        </div>";
            $id++;
        }

        ?>
    </div>
</div>
<script>


var st =  document.querySelector('#selectionString');
const elements = $('.tf');
var selectedCharacters = [];
var selectedURLS = [];

for ( i = 0; i < elements.length; i++){
    x = i;
    $("#characterDiv"+i).click(function () {
            currentCha = $.trim($(this).text().replace(/ /g,' ')); //Trims values return by text()
            currentURL = $(this).find("input").val();
            if(!selectedCharacters.includes(currentCha) && selectedCharacters.length < 3){ //Makes sure a max of 3 characters are selected
                selectedCharacters.push(currentCha);
                selectedURLS.push(currentURL);
                console.log(selectedURLS);
                $(this).css('background-color', '#5cb85c');
            }
            updateString(selectedCharacters); //Calls updateString method each time a character is clicked.

            $('#reset').click(function () {
                resetSelection();
                selectedCharacters = [];
                updateString(selectedCharacters);
            });
    });
}

//Calls downloadCSV method when clicked.
$('#download').click(function () {
    var ite = 0;
    while (ite < selectedURLS.length){
        downloadCSV(selectedURLS[ite]);
        ite++;
    }
});

function removeURls(){
    selectedURLS = [];
}
//updates home screen accordingly
function updateString(arr) {
    if (arr.length > 0){
        this.st.innerText = "You have selected "+arr;
        document.querySelector('#reset').type = 'button';
        document.querySelector('#download').type = 'button';
    }else if(!arr.length > 0){
        document.querySelector('#reset').type = 'hidden';
        document.querySelector('#download').type = 'hidden';
        removeURls();
        this.st.innerText = "Select 3 Characters!";
    }

}

//Takes in URL from parameter > Converts JSON to CSV > downloads file.
function downloadCSV(urls) {
       fetch(urls)
           .then(resp => resp.blob())
           .then(blob => {
               const url = window.URL.createObjectURL(blob);
               const a = document.createElement('a');
               a.style.display = 'none';
               a.href = url;

               a.download = 'character.csv';
               document.body.appendChild(a);
               a.click();
               window.URL.revokeObjectURL(url);
               alert('your file has downloaded!');
           })
           .catch(() => alert('Please allow your browser to download the file'));
}

//changes colour back to original
function resetSelection(){
    $('.test').css('background-color', '#f7f7f7');
}
</script>

</html>
