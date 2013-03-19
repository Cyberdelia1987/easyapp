<div class="form-field">
	<label for="preferences_{$pref_name}">{$pref_config.label}</label>
	<input type="hidden" name="preferences[{$pref_name}]" value=0>
	<input type="checkbox" id="preferences_{$pref_name}" name="preferences[{$pref_name}]" value="1" {if $pref_config.value}checked="checked"{/if}>
</div>