{*
$_input

$_type
$_name
$_value
$_width
$_height
*}
{if $_input.type == 'text'}
<input type="text" name="{$_input.name}" size="{$_input.width}" value="{$_input.value}"/>
{elseif $_input.type == 'textarea'}
<textarea name="{$_input.name}">
</textarea>
{elseif $_input.type == 'checkbox'}
{/if}
