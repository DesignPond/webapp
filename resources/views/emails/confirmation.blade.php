<!DOCTYPE html>
<html lang="fr_FR">
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: arial, sans-serif;">
<h2 style="font-family: arial, sans-serif; color: #dd0330;font-size: 20px;font-weight: 300;letter-spacing: 0;line-height: 30px;">Riiingme</h2>
<h3 style="font-family: arial, sans-serif;">Inscription sur Riiingme</h3>
<div style="font-family: arial, sans-serif;">Pour confirmer votre inscription sur www.riiingme.ch veuillez suivre ce lien:
    <p style="font-family: arial, sans-serif;">
        <a style="text-align:center;font-size:13px;font-family:arial,sans-serif;
			color:white;font-weight:bold;background-color: #dd0330;border: 1px solid #cc002a;
			text-decoration:none;display:inline-block;min-height:27px;padding-left:8px;padding-right:8px;
			line-height:27px;border-radius:2px;border-width:1px" href="{{ URL::to('user/activation', array($token)) }}">Confirmer l'adresse email </a></p>
</div>
<p><a style="font-family: arial, sans-serif;color: #444; font-size: 13px;" href="http://www.riiingme.ch">www.riiingme.ch</a></p>
</body>
</html>
