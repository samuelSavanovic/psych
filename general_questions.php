<?php

function general_questions() {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
            <div class="center">
                <form action="questionnaire.php" method="post" target="popup"
            onsubmit="window.open(\'questionnaire.php\',\'popup\',\'height=\' + screen.height + \',width=\' + screen.width);">
                    <h3 class="heading">General Questions</h3>
                    <p>Is this your first time participating in this exact study?</p>
                    <input type="radio" value="1" 
                    name="first_time_participating" checked>Yes 
                     <input type="radio" value="0" 
                    name="first_time_participating">No 
                    <p>Please enter Your age and gender.</p>
                    <p> I am <input type="number" name="age" min="1" max="100" value="18"> years old.</p>
                    <p>I am <select name="gender">
                    <option name = "gender" value="0">male</option>
                    <option name = "gender" value="1">female</option>
                    <option name = "gender" value="2">other</option>
                    </select></p>
                    <input type="submit" style="float: right;" class="button" name="general_questions_submit" value="Next">
                    </form>
            </div>
       
    </body>
    </html>
    ';
}


