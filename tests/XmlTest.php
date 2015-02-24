<?php
namespace minphp\Xml;

use \PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \minphp\Xml\Xml
 */
class XmlTest extends PHPUnit_Framework_TestCase
{
    private $xml;
    
    public function setUp()
    {
        $this->xml = new Xml();
    }
    /**
     * @covers ::xmlEntities
     */
    public function testXmlEntities()
    {
        $this->assertEmpty($this->xml->xmlEntities(chr(0)));
        $this->assertEquals('&#9;&#10;&#13;', $this->xml->xmlEntities(chr(9) . chr(10) . chr(13)));
        $this->assertEquals('&amp;', $this->xml->xmlEntities('&'));
        $this->assertEquals('&lt;', $this->xml->xmlEntities('<'));
        $this->assertEquals('&gt;', $this->xml->xmlEntities('>'));
        $this->assertEquals('&quot;', $this->xml->xmlEntities('"'));
        $this->assertEquals('&apos;', $this->xml->xmlEntities('`'));
    }
    
    /**
     * @covers ::makeXml
     * @covers ::buildXmlSegment
     */
    public function testMakeXml()
    {
        $data = array(
            'section' => array(
                'contents' => (object)array(
                    'item1' => 1,
                    'item2' => "two",
                    'item4' => null
                ),
                'other' => array('item' => array(1, 2, 3)),
            )
        );
        $result =<<< XML
<?xml version="1.0" encoding="UTF-8" ?>
<section>
	<contents>
		<item1>1</item1>
		<item2>two</item2>
		<item4 />
	</contents>
	<other>
		
		<item>1</item>
		<item>2</item>
		<item>3</item>
	</other>
</section>
XML;
        $this->assertEquals($result, $this->xml->makeXml($data));
    }
}
