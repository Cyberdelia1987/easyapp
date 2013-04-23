<div class="navbar navbar-inverse navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="/">Метод Аленцева-Фока</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					{foreach from=$topnav_config item="one"}
						<li {if $one.active}class="active"{/if}><a href="{$one.url}">{$one.title}</a></li>
					{/foreach}
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>