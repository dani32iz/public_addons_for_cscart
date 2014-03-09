{if $fbnp_result}
<div id="content_fbnp_result">
	{include file="common/subheader.tpl" title="Федеральная база неблагонадёжных покупателей Российской Федерации"}

	{if $fbnp_result.col > 0} 
		<div class="control-group">
	        <label class="control-label">Найдено</label>
	        <div class="controls">
	            <p>{$fbnp_result.col}</p>
	        </div>
	    </div>
	    <div class="control-group">
	        <label class="control-label">Найдены</label>
	        <div class="controls">
	        	<ul>
	        	{foreach from=$fbnp_result.bug item="bug"}
	            	<li>{$bug}</li>
	            {/foreach}
	        	</ul>
	        </div>
	    </div>
	{else}
	    <div class="control-group">
	        <label class="control-label">Результат</label>
	        <div class="controls">
	            <p>{$fbnp_result}</p>
	        </div>
	    </div>
	{/if}
    
<!--content_fbnp_result--></div>
{/if}