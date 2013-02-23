<h3>Associate Sejmometr information with this record:</h3>

{if $notFound}
    {ts 1=$fullName}Could not find Parliament Members with the name being exactly: %1.{/ts}

    {ts}Maybe you would like to choose from these other Members below:{/ts}
    <ul>
    {foreach from=$othersByFirstName item=otherFname}
        <li>{$otherFname->data.nazwa} ({$otherFname->data.id})
        - <a href="{crmURL p='civicrm/sejmometr/associateaction' q="cid=`$contactID`&sejmid=`$otherFname->data.id`"}">{ts}associate{/ts}</a>
        </li>
    {/foreach}
    {foreach from=$othersByLastName item=otherLname}
        <li>{$otherLname->data.nazwa}</li>
    {/foreach}
    </ul>
{else}
    {foreach from=$members item=member}
        <li>{$member->data.nazwa}</li>
    {/foreach}
{/if}