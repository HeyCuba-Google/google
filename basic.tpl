<h1>{$query|capitalize	}</h1>

{foreach from=$responses item=response}
    <p>{link href="WEB {$response['url']}" caption="{$response['title']}"}</p>
		<p>{$response['note']}</p>
		{space10}
{/foreach}
