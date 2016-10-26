{$vendors = $elem.__vendors->vendorApi->getList()}
{$links = $elem.__vendors->vendorApi->getProductLinks($elem.id)}

<table class="otable">
    {foreach $vendors as $vendor}
        <tr>
            <td class="otitle">
                {$vendor.title}&nbsp;{t}(ссылка){/t}
            </td>
            <td>
                {if isset($links[$vendor.id])}
                    <input type="hidden" name="vendors[{$vendor.id}][id]" value="{$links[$vendor.id].id}"/>
                {/if}
                <input maxlength="50" size="50" type="text" name="vendors[{$vendor.id}][url]" value="{$links[$vendor.id].url}"/>
                <span class="hint" title="{t}Введите ссылку на этот товар у поставщика{/t}">?</span>
            </td>
        </tr>
    {/foreach}
</table>