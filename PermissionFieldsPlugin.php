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
		return '1.1.0';
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

	/**
	 * Plugin initialization
	 *
	 * Adds a hook so the field permissions cache is refreshed when field layouts are saved
	 *
	 * @return null
	 */
	public function init()
	{
		craft()->on('fields.saveFieldLayout', function(Event $event){
			craft()->permissionFields->getUserPermissions(true);
		});
	}

	/**
	 * Returns the plugin settings url
	 *
	 * @return string
	 */
	public function getSettingsUrl()
	{
		return 'permissionfields/manager';
	}

	/**
	 * Returns the plugin CP routes
	 *
	 * @return array
	 */
	public function registerCpRoutes()
	{
		return array(
			'permissionfields/manager' => array('action' => 'permissionFields/fieldManager/index'),
		);
	}

	/**
	 * Returns an array of plugin user permissions for each of this installation's permission fields
	 *
	 * This permissions array is populated by searching the `craft_fields` table for supported fields,
	 * and is stored in Craft's data cache for improved performance.
	 *
	 * @return array
	 */
	public function registerUserPermissions($force = false)
	{
		return craft()->permissionFields->getUserPermissions($force);
	}
}