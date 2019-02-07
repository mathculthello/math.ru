{if $error_message}<span class=error>{section name=i loop=$error_message}Ошибка: {$error_message[i]}<br>{/section}</span>
{elseif $message}<span class=msg>{$message}</span>{/if}
