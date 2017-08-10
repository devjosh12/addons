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

    <div class="c_Frame">
        <div class="c_Frame-top">
            <div class="c_Frame-header">
                {include file="partials/header.tpl"}
            </div>
            <div class="c_Frame-body">
                <div class="c_Frame-content">
                    <div class="c_Container">
                        <div class="c_Frame-contentWrap">
                            <div class="c_Frame-details">
                                <div class="c_Frame-row c_Crumbs">
                                    {breadcrumbs}
                                    <div class="SearchBox">
                                        {searchbox}
                                    </div>
                                </div>
                                <div class="c_Content">
                                    {if inSection("Profile")}
                                        <div class="c_Panel c_Panel--top">
                                            {asset name="Panel"}
                                        </div>
                                    {/if}
                                    {asset name="Content"}
                                </div>
                                <div class="c_Panel c_Panel--bottom">
                                    {asset name="Panel"}
                                </div>
                                {event name="AfterBody"}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="c_Frame-footer">
        </div>
    </div>
</body>

</html>
