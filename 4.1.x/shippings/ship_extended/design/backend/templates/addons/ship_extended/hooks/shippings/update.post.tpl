{if $id}

<div class="control-group">
    <label class="control-label" for="elm_shipping_data_free_text">{__("ship_extended.free_text")}</label>
    <div class="controls">
		<input type="text" name="shipping_free_text" id="elm_shipping_data_free_text" size="30" value="{$shipping_free_text}" class="input-large" />
    </div>
</div>


<div class="control-group cm-no-hide-input">
    <label class="control-label" for="elm_shipping_data_full_descr">{__("full_description")}:</label>
    <div class="controls">
        <textarea id="elm_shipping_data_full_descr" name="shipping_full_descr" cols="55" rows="8" class="cm-wysiwyg input-large">{$shipping_full_descr}</textarea>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="elm_shipping_data_disable_payments">{__("ship_extended.disable_payments")}</label>
    <div class="controls">
        {include file="common/selectable_box.tpl" name="disable_payments" id="elm_shipping_data_disable_payments" fields=$payments selected_fields=$disable_payments}
    </div>
</div>

{/if}