<div id="login-status">
{ifuserconnected}
    {$login}, vous êtes connecté.
    (<a href="{jurl 'jcommunity~login:out'}">déconnexion</a>,
    <a href="{jurl 'jcommunity~account:show', array('user'=>$login)}">votre compte</a>)
{else}
    Non connecté.
    <a href="{jurl 'jcommunity~login:index'}">Login</a>,
    <a href="{jurl 'jcommunity~registration:index'}">S'inscrire</a>,
    <a href="{jurl 'jcommunity~password:index'}">Mot de passe oublié</a>
{/ifuserconnected}
</div>

