# SimpleXMLElementExtended
A simple extended version of SimpleXMLElement that adds CDATA whenever necessary.

##Example
When using SimpleXMLElementExtended, you just call the same `addChild()` method like you're used to when using SimpleXMLElement. For example, the following code...

```php
$xml = new SimpleXMLElementExtended( '<xmlData></xmlData>' );

$child = $xml->addChild( 'data' );

$child->addChild( 'child1' );
$child->addChild( 'child2', 'value' );
$child->addChild( 'child3', 'A string with <a href="/test?p=1&q=e">HTML elements</a>.' )
		->addAttribute( 'attribute', 'value' );

$subChild = $child->addChild( 'child4' );
$subChild->addChild( 'child4_1', 'value' );

print $xml->asXML();
```

...outputs the following XML:
```xml
<?xml version="1.0"?>
<xmlData>
	<data>
		<child1/>
		<child2>value</child2>
		<child3 attribute="value"><![CDATA[A string with <a href="/test?p=1&q=e">HTML elements</a>.]]></child3>
		<child4>
			<child4_1>value</child4_1>    
		</child4>
	</data>
</xmlData>
```
