{if $shipping.full_description}

    {$ship_view_type = $addons.ship_extended.view_type}

    <div class="ty-ship_extended__description-wrapper">    
    {if $ship_view_type == 'click'}

        <a id="sw_ship_extended_{$shipping.shipping_id}" class="cm-combination ty-ship_extended__click-link">{__("text_click_here")}</a>

        <div id="ship_extended_{$shipping.shipping_id}" class="ty-ship_extended__click-block hidden">
            <div class="ty-ship_extended__description">
                {$shipping.full_description nofilter}
            </div>
        </div>

    {elseif $ship_view_type == 'popup'}

        {capture name="ship_full_description"}
            {$shipping.full_description nofilter}
        {/capture}

        {include file="common/popupbox.tpl"
            content=$smarty.capture.ship_full_description
            link_text={__("text_click_here")}
            text=$shipping.shipping
            id=$shipping.shipping_id
            link_meta="ty-ship_extended__click-link"
        }

    {else}

        {$shipping.full_description nofilter}

    {/if}

    </div>
{/if}
