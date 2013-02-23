<h3>Associate Sejmometr information with this record:</h3>

{if $emptyName}
    {ts}Seems like last name of your contact is empty. Please define at least last name in the contact record in order to be able to search through Sejmometr API.{/ts}
{elseif $notFound}
    <p>
    {ts 1=$fullName}Could not find Parliament Members with name being exactly: %1.{/ts}
    </p>
    <p>
    {ts}Maybe you would like to choose from these other Parliament Members below?{/ts}
    </p>
    {if not $noOthersByFirstName}
        <p>
        {ts}People in Parliament with the same first name:{/ts}
        <ul>
        {foreach from=$othersByFirstName item=otherFname}
            <li>{$otherFname->data.nazwa} ({$otherFname->data.id})
            - <a href="{crmURL p='civicrm/sejmometr/associateaction' q="cid=`$contactID`&sejmid=`$otherFname->data.id`"}">{ts}associate{/ts}</a>
            </li>
        {/foreach}
        </ul>
        </p>
    {/if}
    {if not $noOthersByLastName}
        <p>
        {ts}People in Parliament with the same last name:{/ts}
        <ul>
        {foreach from=$othersByLastName item=otherLname}
            <li>{$otherLname->data.nazwa} ({$otherLname->data.id})
            - <a href="{crmURL p='civicrm/sejmometr/associateaction' q="cid=`$contactID`&sejmid=`$otherLname->data.id`"}">{ts}associate{/ts}</a>            
            </li>
        {/foreach}
        </ul>
        </p>
    {/if}
{else}
    {ts}There you go. Is it this person?{/ts}
    <ul>
    {foreach from=$members item=member}
        <li>{$member->data.nazwa} ({$member->data.id})
            - <a href="{crmURL p='civicrm/sejmometr/associateaction' q="cid=`$contactID`&sejmid=`$member->data.id`"}">{ts}associate{/ts}</a>
        </li>
    {/foreach}
    </ul>
{/if}