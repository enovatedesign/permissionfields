<?php
namespace Craft;

use Mockery as m;

/**
 * Permission Fields Plugin Test class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.tests
 * @since     1.0.0
 */
class PermissionFieldsPluginTest extends PermissionFields_BaseTest
{
	/**
	 * @var PermissionFieldsPlugin
	 */
	protected $subject;

	public function setUp()
	{
		parent::setUp();

		$this->subject = new PermissionFieldsPlugin;
	}

	/**
	 * Plugin tests
	 */
	public function testGetNameReturnsPluginName()
	{
		$this->assertEquals('Permission Fields', $this->subject->getName());
	}

	public function testGetVersionReturnsProperlyFormattedString()
	{
		$this->assertTrue((bool) preg_match('/\d+.\d+(.\d+)?/', $this->subject->getVersion()));
	}

	public function testGetDeveloperReturnsNameAsDefined()
	{
		$this->assertEquals('Enovate Design', $this->subject->getDeveloper());
	}

	public function testGetDeveloperUrlReturnsUrlAsDefined()
	{
		$this->assertEquals('http://www.enovate.co.uk', $this->subject->getDeveloperUrl());
	}

	public function testHasNoCpSection()
	{
		$this->assertFalse($this->subject->hasCpSection());
	}

	public function testHasNoSettingsUrl()
	{
		$this->assertNull($this->subject->getSettingsUrl());
	}

	public function testGetSettingsReturnsBaseModel()
	{
		$this->assertTrue($this->subject->getSettings() instanceof BaseModel);
	}
}