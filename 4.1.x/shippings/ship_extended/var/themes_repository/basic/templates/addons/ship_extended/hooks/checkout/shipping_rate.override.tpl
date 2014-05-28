{if $addons.ship_extended.view_type == "tooltip"}
    {if $display == "radio"}
        <p class="shipping-options-method">
            <input type="radio" class="valign" id="sh_{$group_key}_{$shipping.shipping_id}" name="shipping_ids[{$group_key}]" value="{$shipping.shipping_id}" onclick="fn_calculate_total_shipping_cost();" {$checked} />
            <label for="sh_{$group_key}_{$shipping.shipping_id}" class="valign">{$shipping.shipping}{if $shipping.full_description}{include file="common/tooltip.tpl" tooltip=$shipping.full_description}{/if} {$delivery_time} - {if $shipping.free_text && $shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}</label>
        </p>

    {elseif $display == "select"}
        <option value="{$shipping.shipping_id}" {$selected}>{$shipping.shipping}{if $addons.ship_extended.view_type == "tooltip" && $shipping.full_description}{include file="common/tooltip.tpl" tooltip=$shipping.full_description}{/if} {$delivery_time} - {if $shipping.free_text && $shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}</option>

    {elseif $display == "show"}
            <p>
                {$strong_begin}{$rate.name} {$delivery_time} - {if $shipping.free_text && $shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}{$strong_begin}
            </p>
    {/if}

{else}

    {if $display == "radio"}
        <p class="shipping-options-method">
            <input type="radio" class="valign" id="sh_{$group_key}_{$shipping.shipping_id}" name="shipping_ids[{$group_key}]" value="{$shipping.shipping_id}" onclick="fn_calculate_total_shipping_cost();" {$checked} />
            <label for="sh_{$group_key}_{$shipping.shipping_id}" class="valign">{$shipping.shipping} {$delivery_time} - {if $shipping.free_text && $shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}</label>
        </p>

    {elseif $display == "select"}
        <option value="{$shipping.shipping_id}" {$selected}>{$shipping.shipping} {$delivery_time} - {if $shipping.free_text &&$shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}</option>

    {elseif $display == "show"}
            <p>
                {$strong_begin}{$rate.name} {$delivery_time} - {if $shipping.free_text && $shipping.rate == 0}{$shipping.free_text nofilter}{else}{$rate nofilter}{/if}{$strong_begin}
            </p>
    {/if}

{/if}

{if $addons.ship_extended.view_type == "click"}
    {if $display == "radio"}
        {if $shipping.full_description}
        <div class="extended-ship">
            <a id="sw_extended_ship_{$shipping.shipping_id}" class="cm-combination extended_ship_link">{__("text_click_here")}</a>

            <div id="extended_ship_{$shipping.shipping_id}" class="extended_ship_div hidden">
                    <div class="caret-info-wrapper">
                        <span class="caret-info light"> <span class="caret-outer"></span> <span class="caret-inner"></span></span>
                    </div>
                    <div class="extended_ship_descr">
                        {$shipping.full_description nofilter}
                    </div>
            </div>
        </div>
        {/if}
    {/if}
{/if}