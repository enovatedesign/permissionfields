<?php
namespace Craft;

/**
 * Permission Fields Plugin class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.services
 * @since     1.1.0
 */
class PermissionFieldsService extends BaseApplicationComponent {

	/**
	 * Returns an array of supported field types, where the keys are the Permission field class names,
	 * and the values are the corresponding supported fields.
	 *
	 * @return array
	 */
	public function getSupportedFieldTypes()
	{
		return array(
			'PermissionFields_Assets'         => 'Assets',
			'PermissionFields_Categories'     => 'Categories',
			'PermissionFields_Checkboxes'     => 'Checkboxes',
			'PermissionFields_Color'          => 'Color',
			'PermissionFields_Date'           => 'Date',
			'PermissionFields_Dropdown'       => 'Dropdown',
			'PermissionFields_Entries'        => 'Entries',
			'PermissionFields_Lightswitch'    => 'Lightswitch',
			'PermissionFields_MultiSelect'    => 'MultiSelect',
			'PermissionFields_Number'         => 'Number',
			'PermissionFields_PlainText'      => 'PlainText',
			'PermissionFields_PositionSelect' => 'PositionSelect',
			'PermissionFields_RadioButtons'   => 'RadioButtons',
			'PermissionFields_RichText'       => 'RichText',
			'PermissionFields_Table'          => 'Table',
			'PermissionFields_Tags'           => 'Tags',
			'PermissionFields_Users'          => 'Users',
		);
	}

	public function getFieldsByFieldType($fieldTypes)
	{
		$fieldTypes = ArrayHelper::stringToArray($fieldTypes);

		return craft()->db->createCommand()
				->select('fields.id, fields.name, fields.type, groups.name as group')
				->from('fields fields')
				->join('fieldgroups groups','groups.id = fields.groupId')
				->where(array('in', 'fields.type', $fieldTypes))
				->order('groups.name, fields.name')
				->queryAll();
	}

	public function updateFieldTypeByFieldId($fieldId, $fieldType)
	{
		return craft()->db->createCommand()->update(
			'fields',
			array('type' => $fieldType),
			array('id'   => $fieldId)
		);
	}

	public function getUserPermissions($force = false)
	{
		$permissions = craft()->cache->get('permissionFields.permissions');

		if (!$permissions || $force)
		{
			$permissionFields = craft()->permissionFields->getFieldsByFieldType(
				array_keys($this->getSupportedFieldTypes())
			);

			foreach ($permissionFields as $field)
			{
				$permissions['permissionFields_editField:'.$field['id']] = array(
					'label' => TemplateHelper::getRaw(
						"Edit \"{$field['group']} &raquo; {$field['name']}\""
					),
				);
			}

			craft()->cache->set('permissionFields.permissions', $permissions);
		}

		return $permissions;
	}
}