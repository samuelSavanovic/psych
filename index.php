<?php

echo '
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Psych</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
     <form action="questionnaire.php" method="post" target="popup"
    onsubmit="window.open(\'questionnaire.php\',\'popup\',\'height=\' + screen.height + \',width=\' + screen.width);">
    <div class="center">
	    <h3 class="heading">HELLO!</h3>
        <p>Thank you for choosing to participate in this short research study! The aim of the study is to
    investigate how people make different judgements.<br><br>
    All your responses will be anonymus and you can choose to quit at any time.<br><br>
    Participating will take less than 5 minutes of your time.<br><br>
    <span style="font-style: italic;"> By pressing start, you are giving permission to use your answers for research purposes</span></p>
    <input type="submit" style="float: right;" class="button" value="Next">
    </div>
    </form>
</body>
</html>
';