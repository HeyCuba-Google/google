<h1>{$query|capitalize	}</h1>

{$debugging}

{foreach from=$responses item=response}
    <p>{link href="WEB {$response['url']}" caption="{$response['title']}"}</p>
		<p>{$response['note']}</p>
    <p>{$response['characters']} KB</p>
		{space10}
{/foreach}
