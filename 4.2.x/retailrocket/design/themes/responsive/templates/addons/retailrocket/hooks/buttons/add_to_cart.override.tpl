{assign var="c_url" value=$config.current_url|escape:url}
{if $settings.General.allow_anonymous_shopping == "allow_shopping" || $auth.user_id}

{* RetailRocket *}
<!-- RetailRocket -->
    {$id_to_array = "_"|explode:$but_id}
    {$product_id = $id_to_array|array_pop}
    {$but_onclick = 'try{rrApi.addToBasket([product_id])}catch(e){}'}
    {$but_onclick = "[product_id]"|str_replace:$product_id:$but_onclick}
{* /RetailRocket *}

    {include file="buttons/button.tpl" but_id=$but_id but_text=$but_text|default:__("add_to_cart") but_name=$but_name but_onclick=$but_onclick but_href=$but_href but_target=$but_target but_role=$but_role|default:"text" but_meta="ty-btn__primary ty-btn__big ty-btn__add-to-cart cm-form-dialog-closer"}
{else}

    {if $runtime.controller == "auth" && $runtime.mode == "login_form"}
        {assign var="login_url" value=$config.current_url}
    {else}
        {assign var="login_url" value="auth.login_form?return_url=`$c_url`"}
    {/if}

    {include file="buttons/button.tpl" but_id=$but_id but_text=__("sign_in_to_buy") but_href=$login_url but_role=$but_role|default:"text" but_name=""}
    <p>{__("text_login_to_add_to_cart")}</p>
{/if}