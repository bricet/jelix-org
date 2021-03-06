{ifuserconnected}
<div class="box loginbox-connected">
	<h2>{@havefnubb~member.identity@}</h2>
	<div class="block-post">
		<p>{jlocale 'havefnubb~member.login.welcome', array($login)}
		(<a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">{@havefnubb~member.login.your.account@}</a>,
		<a href="{jurl 'jcommunity~login:out'}">{@havefnubb~member.login.logout@}</a>)
		</p>
	</div>
</div>
{else}
<div class="box loginbox">
	<h2>{@havefnubb~main.login.connection@}</h2>
	<div class="block-post">
	{form $form, 'jcommunity~login:in'}
	   <p>
			{ctrl_label 'auth_login'}
			{ctrl_control 'auth_login'}
		&nbsp;
			{ctrl_label 'auth_password'}
			{ctrl_control 'auth_password'}
		{if $persistance_ok}
			{ctrl_label 'auth_remember_me'} {ctrl_control 'auth_remember_me'}
		{/if}
			{formsubmit}

		{if $url_return}
			&nbsp;
			<input type="hidden" name="auth_url_return" value="{$url_return|eschtml}" />
		{/if}
		</p>
	{/form}
		<div id="loginbox-links">
				(<a href="{jurl 'jcommunity~registration:index'}">{@havefnubb~member.login.register@}</a>,
				<a href="{jurl 'jcommunity~password:index'}">{@havefnubb~member.login.forgotten.password@}</a>)
		</div>
	</div>
</div>
{/ifuserconnected}
