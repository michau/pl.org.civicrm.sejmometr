<h3>Sejmometr Parliament member information:</h3>

{* Example: Display a variable directly *}
<p>{$member.nazwa}</p>
<p>
    <ul>
    {foreach from=$associates item=associate}
        <li>{$associate.nazwa}</li>
    {/foreach}
    </ul>
</p>
