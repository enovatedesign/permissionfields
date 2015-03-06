<?php
namespace Craft;

/**
 * Permission Fields Plugin class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields
 * @since     1.0.0
 */
class PermissionFieldsPlugin extends BasePlugin implements IPlugin
{
	private $_permissions;

	/**
	 * Get the plugin name
	 *
	 * @return string The plugin name
	 */
	public function getName()
	{
		return Craft::t('Permission Fields');
	}

	/**
	 * Get the plugin version
	 *
	 * @return string The current version of the plugin
	 */
	public function getVersion()
	{
		return '1.0.0';
	}

	/**
	 * Get the plugin developer name
	 *
	 * @return string The developer name
	 */
	public function getDeveloper()
	{
		return 'Enovate Design';
	}

	/**
	 * Get the plugin developer url
	 *
	 * @return string The developer URL
	 */
	public function getDeveloperUrl()
	{
		return 'http://www.enovate.co.uk';
	}

	/**
	 * Returns true if the plugin should have a CP section link, false if not.
	 *
	 * @return boolean
	 */
	public function hasCpSection()
	{
		return false;
	}

	public function init()
	{
		craft()->on('fields.saveFieldLayout', function(Event $event){
			$this->registerUserPermissions(true);
		});
	}

	public function registerUserPermissions($force = false)
	{
		$permissionFields = craft()->cache->get('permissionFields');

		if (!$permissionFields || $force)
		{
			$permissionFields = array();

			$fields = craft()->db->createCommand()
				->select('fields.name, fields.id, groups.name as group')
				->from('fields fields')
				->join('fieldgroups groups','groups.id = fields.groupId')
				->where(array('in', 'fields.type', $this->supportedFields))
				->queryAll();

			foreach ($fields as $field)
			{
				$permissionFields['editField:'.$field['id']] = array(
					'label' => TemplateHelper::getRaw("Edit \"{$field['group']} &raquo; {$field['name']}\""
				));
			}

			PermissionFieldsPlugin::log('Updating permission fields cache');

			craft()->cache->set('permissionFields', $permissionFields);
		}

		return $permissionFields;
	}

	protected function getSupportedFields()
	{
		return array(
			'PermissionFields_PlainText',
			'PermissionFields_Assets',
			'PermissionFields_Categories',
			'PermissionFields_Checkboxes',
			'PermissionFields_Color',
			'PermissionFields_Date',
			'PermissionFields_Dropdown',
			'PermissionFields_Entries',
			'PermissionFields_Lightswitch',
			'PermissionFields_MultiSelect',
			'PermissionFields_Number',
			'PermissionFields_PlainText',
			'PermissionFields_PositionSelect',
			'PermissionFields_RadioButtons',
			'PermissionFields_RichText',
			'PermissionFields_Table',
			'PermissionFields_Tags',
			'PermissionFields_Users',
		);
	}
}