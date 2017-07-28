<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {asset name="Head"}
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body id="{$BodyID}" class="{$BodyClass} {if $User.SignedIn} UserLoggedIn{else} UserLoggedOut{/if} {if inSection('Discussion') and $Page gt 1}isNotFirstPage{/if}">
    <!--[if lt IE 9]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    {include 'frame.tpl'}
</body>

</html>
