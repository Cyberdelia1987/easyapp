<div class="form-field">
	<div class="holder label-holder">
		<label for="preferences_{$pref_name}">{$pref_config.label}</label>
	</div>
	<div class="holder field-holder">
		<select id="preferences_{$pref_name}" name="preferences[{$pref_name}]">
			{foreach from=$pref_config.options key="o_val" item="o_label"}
				<option value="{$o_val}" {if $pref_config.value==$o_val}selected="selected"{/if}>{$o_label}</option>
			{/foreach}
		</select>
	</div>
</div>