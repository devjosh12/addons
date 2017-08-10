<header class="c_Header">
    {assign
        "linkFormat"
        "<div class='c_Navigation-linkContainer'>
            <a href='%url' class='c_Navigation-link %class'>
                %text
            </a>
        </div>
        <span class='c_Navigation-divider'></span>"
    }
    <div class="c_Container">
        <div class="c_Header-row">
            <a href="{home_link format="%url"}" class="c_Header-logo">
                {logo}
            </a>
            <div class="c_Header-right">
                <div class="c_Header-links">
                    <div class="c_Header-languageSelector">
                        {module name="SubcommunityToggleModule"}
                    </div>
                    <div class="c_Header-ctaContainer">
                        <a href="{t c="Link-donate"}">
                            <button class="c_Header-cta">{t c="Donate"}</button>
                        </a>
                    </div>
                </div>
                <div class="c_MeBox--header">
                    {module name="MeModule" CssClass="FlyoutRight"}
                </div>
            </div>
            <div class="c_Hamburger">
                {include file="partials/hamburger.html"}
            </div>
        </div>
    </div>
    <nav id="navdrawer" class="c_Navigation">
        <div class="c_Container">
            <div class="c_Navigation-row">
                <div class="c_MeBox c_MeBox--mobile">
                    {module name="MeModule"}
                </div>
                <div class="c_Navigation-buttons">
                    <div class="c_Header-languageSelector Button c_Navigation-button">
                        {module name="SubcommunityToggleModule"}
                    </div>
                    <div class="Button c_Navigation-button">
                        <a href="{t c="Link-ovarian"}">{t c="ovariancanada.org"}</a>
                    </div>
                </div>
                <div class="c_NewDiscussion--mobile">
                    {module name="NewDiscussionModule"}
                </div>
                {discussions_link format=$linkFormat}
                <div class="c_Navigation-accordianContainer">
                    {module name="CollapsableCategoriesModule"}
                </div>
                <span class='c_Navigation-divider'></span>
                {activity_link format=$linkFormat}
                {custom_menu format=$linkFormat}
            </div>
        </div>
    </nav>
</header>
