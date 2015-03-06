<?php
namespace Craft;

use Mockery as m;

/**
 * Permission Fields Field Types Test class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.tests
 * @since     1.0.0
 */
class PermissionFields_FieldTypesTest extends PermissionFields_BaseTest
{
	protected $subjects = array();

	public function setUp()
	{
		parent::setUp();

		foreach($this->fieldTypes as $fieldType => $name)
		{
			$class = '\\Craft\\PermissionFields_'.$fieldType.'FieldType';
			$parent = "\\Craft\\{$fieldType}FieldType";

			$this->subjects[$fieldType] = array(
				'class' => $class,
				'instance' => new $class,
				'parent' => $parent,
				'name' => $name,
			);
		}
	}

	/**
	 * Plugin tests
	 */
	public function testFieldTypesExtendTheCorrectBaseClass()
	{
		foreach($this->subjects as $fieldType)
		{
			$this->assertTrue($fieldType['instance'] instanceof $fieldType['parent'], "{$fieldType['class']} is not an instance of {$fieldType['parent']}");
		}
	}

	public function testFieldTypesHaveTheCorrectNames()
	{
		foreach($this->subjects as $fieldType)
		{
			$this->assertEquals("Permission {$fieldType['name']}", $fieldType['instance']->getName());
		}
	}
}