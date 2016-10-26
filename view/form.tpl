<div class="vendors" data-type="{$param.type}" data-linkid="{$param.linkid}">
    <input type="hidden" name="link_id" value="{$param.linkid}">
    <input type="hidden" name="type" value="{$param.type}">
    <div class="grayblock">
        <div data-action="{adminUrl mod_controller="vendors-blockvendors" do=false tdo="saveLinks"}" class="vendor_form">
            <table class="otable">
                {foreach $vendors as $vendor}
                    <tr>
                        <td class="otitle">
                            {$vendor.title}&nbsp;{t}(ссылка){/t}
                        </td>
                        <td>
                            {if isset($vendor.link) && isset($vendor.link.id)}
                                <input type="hidden" name="vendors[{$vendor.id}][id]" {if isset($vendor.link) && isset($vendor.link.id)}value="{$vendor.link.id}"{/if} />
                            {/if}
                            <input maxlength="50" size="50" type="text" name="vendors[{$vendor.id}][url]" {if isset($vendor.link) && isset($vendor.link.url)}value="{$vendor.link.url}"{/if} />
                            <span class="hint" title="{t}Введите ссылку на этот товар у поставщика{/t}">?</span>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </div>
</div>