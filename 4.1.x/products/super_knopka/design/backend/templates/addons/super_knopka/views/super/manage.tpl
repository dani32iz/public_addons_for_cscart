{** Super section **}

{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="super_form" class="form-horizontal form-edit " enctype="multipart/form-data">

<input type="hidden" name="fake" value="1" />

{if "ULTIMATE"|fn_allowed_for}
    {include file="views/companies/components/company_field.tpl"
        name="company_id"
        id="super_data"
        selected=$company_id
    }
{/if}

<div class="control-group ">
    <label class="control-label" for="options_to_features">
        {__("super_knopka.options_to_features")} 
        {include file="common/tooltip.tpl" tooltip=__("super_knopka.options_to_features.tooltip")}:
    </label>
    <div class="controls" id="options_to_features">
        {include file="buttons/button.tpl" but_role="submit" but_name="dispatch[super.options_to_features]" but_text=__("super_knopka.options_to_features.button")}
    </div>
</div>

</form>

{/capture}
{include file="common/mainbox.tpl" title=__("super_knopka.options_to_features.title") content=$smarty.capture.mainbox}
