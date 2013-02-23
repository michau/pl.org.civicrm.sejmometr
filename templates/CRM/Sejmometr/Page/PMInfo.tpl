<h3>Sejmometr Parliament member information:</h3>

{* Example: Display a variable directly *}
<p>Z tym rekordem powiązany jest poseł: <strong>{$member.nazwa}</strong> (<a href="http://sejmometr.pl/poslowie/{$member.id}" target="_new">zobacz w Sejmometrze</a>)</p>

<div>
    <span class="label">Imię pierwsze:</span> {$member.imie_pierwsze}
    (<a href="{crmURL p='civicrm/sejmometr/copydataaction' q="cid=`$contactID`&sejm_param=imie_pierwsze&civi_param=first_name"}">kopiuj do CiviCRMa</a>)
</div>

<div>
    <span class="label">Imię drugie:</span> {$member.imie_drugie}
    (<a href="{crmURL p='civicrm/sejmometr/copydataaction' q="cid=`$contactID`&sejm_param=imie_drugie&civi_param=middle_name"}">kopiuj do CiviCRMa</a>)
</div>

<div>
    <span class="label">Nazwisko:</span> {$member.nazwisko}
    (<a href="{crmURL p='civicrm/sejmometr/copydataaction' q="cid=`$contactID`&sejm_param=nazwisko&civi_param=last_name"}">kopiuj do CiviCRMa</a>)
</div>

<div>
    <span class="label">Data urodzenia:</span> {$member.data_urodzenia}
    (<a href="{crmURL p='civicrm/sejmometr/copydataaction' q="cid=`$contactID`&sejm_param=data_urodzenia&civi_param=birth_date"}">kopiuj do CiviCRMa</a>)
</div>


<p>
    <ul>
    {foreach from=$associates item=associate}
        <li>{$associate.nazwa}</li>
    {/foreach}
    </ul>
</p>
