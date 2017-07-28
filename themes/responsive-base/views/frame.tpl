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
        {asset name="Foot"} {include file="partials/footer.tpl"}
    </div>
</div>
