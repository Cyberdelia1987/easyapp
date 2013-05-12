<div class="topbar navbar-static-top">
	<div class="topbar-inner">
		<div class="container canvas">
			<a class="brand" href="/">Метод Аленцева-Фока</a>
			<div class="container canvas">
				<ul class="nav">
					{foreach from=$topnav_config item="one"}
						<li {if $one.active}class="active"{/if}><a href="{$one.url}">{$one.title}</a></li>
					{/foreach}
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>