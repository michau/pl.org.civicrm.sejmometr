<h3>Sejmometr Parliament member information:</h3>

{* Example: Display a variable directly *}
<p>
<h2>{ts}This contact record is associated with Sejmometr Parliament Member record of:{/ts}<br/>
    <strong>{$pm->sejmometrName}</strong>
    (<a href="http://sejmometr.pl/poslowie/{$pm->sejmometrId}" target="_new">{ts}see in Sejmometr{/ts}</a>)
</h2>
</p>

<div class="pmProperties">
    <div class="pmProperty">
        <span class="label">{ts}First Name{/ts}</span>: 
        <span class="property">{$pm->first_name}</span>
        <span class="action">(<a href="{$pm->buildCopyURL('first_name')}">{ts}copy{/ts}</a>)</span>
    </div>

    <div class="pmProperty">
        <span class="label">{ts}Middle Name{/ts}</span>: 
        <span class="property">{$pm->middle_name}</span>
        <span class="action">(<a href="{$pm->buildCopyURL('middle_name')}">{ts}copy{/ts}</a>)</span>
    </div>

    <div class="pmProperty">
        <span class="label">{ts}Last Name{/ts}</span>: 
        <span class="property">{$pm->last_name}</span>
        <span class="action">(<a href="{$pm->buildCopyURL('last_name')}">{ts}copy{/ts}</a>)</span>
    </div>

    <div class="pmProperty">
        <span class="label">{ts}Birth Date{/ts}</span>: 
        <span class="property">{$pm->birth_date}</span>
        <span class="action">(<a href="{$pm->buildCopyURL('birth_date')}">{ts}copy{/ts}</a>)</span>
    </div>
</div> <!-- pmProperties -->

<div class="pmAssociates">
<ul>
    {foreach from=$pm->associates() item=associate}
        <li>
            <span class="label">{$associate->job_title}</span>: 
            <span class="property">{$associate->first_name} {$associate->last_name}</span>
            <span class="action">(<a href="{$associate->buildCopyURL()}">{ts}copy{/ts}</a>)</span>
        </li>
    {/foreach}
</ul>
</div> <!-- pmAssociates -->


<p>
<ul>
    {foreach from=$commissions item=commission}
        <li>{$commission.nazwa_stanowiska} - {$commission.nazwa}</li>
    {/foreach}
</ul>
</p>