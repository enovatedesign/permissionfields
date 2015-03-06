<?php
namespace Craft;

use Mockery as m;

/**
 * Permission Fields Base Test class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.tests
 * @since     1.0.0
 */
class PermissionFields_BaseTest extends BaseTest
{
	protected $mocks;
	protected $fieldTypes = array(
		'Assets' => 'Assets',
		'Categories' => 'Categories',
		'Checkboxes' => 'Checkboxes',
		'Color' => 'Color',
		'Date' => 'Date',
		'Dropdown' => 'Dropdown',
		'Entries' => 'Entries',
		'Lightswitch' => 'Lightswitch',
		'MultiSelect' => 'Multi Select',
		'Number' => 'Number',
		'PlainText' => 'Plain Text',
		'PositionSelect' => 'Position Select',
		'RadioButtons' => 'Radio Buttons',
		'RichText' => 'Rich Text',
		'Table' => 'Table',
		'Tags' => 'Tags',
		'Users' => 'Users',
	);

	public function setUp()
	{
		$this->autoload();

		$this->mocks = new \stdClass;

		$this->mockConfig();
		$this->mockPlugins();
	}

	/**
	 * Mocks the Craft PluginsService
	 */
	public function mockPlugins()
	{
		$plugin = new PermissionFieldsPlugin;
		$this->mocks->plugins = m::mock('Craft\PluginsService[getPlugin]');

		$plugin->init();

		$this->mocks->plugins->shouldReceive('getPlugin')->with('permissionFields')->andReturn($plugin);

		$this->setComponent(craft(), 'plugins', $this->mocks->plugins);
	}

	/**
	 * Mocks the Craft ConfigService
	 */
	public function mockConfig()
	{
		$this->mocks->config = m::mock('Craft\ConfigService');

		$this->mocks->config->shouldReceive('usePathInfo')->andReturn(true);
		$this->mocks->config->shouldReceive('getIsInitialized')->andReturn(true);
		$this->mocks->config->shouldReceive('omitScriptNameInUrls')->andReturn(true);
		$this->mocks->config->shouldReceive('cacheMethod')->andReturn('file');

		$this->mocks->config->shouldReceive('get')->with('user', 'db')->andReturn('root');
		$this->mocks->config->shouldReceive('get')->with('password', 'db')->andReturn('secret');
		$this->mocks->config->shouldReceive('get')->with('database', 'db')->andReturn('plugin_craft_dev');
		$this->mocks->config->shouldReceive('get')->with('devMode')->andReturn(false);
		$this->mocks->config->shouldReceive('get')->with('cpTrigger')->andReturn('admincp');
		$this->mocks->config->shouldReceive('get')->with('baseCpUrl')->andReturn('http://plugin.craft.dev/');
 		$this->mocks->config->shouldReceive('get')->with('defaultCookieDomain')->andReturn('http://plugin.craft.dev/');
		$this->mocks->config->shouldReceive('get')->with('pageTrigger')->andReturn('p');
		$this->mocks->config->shouldReceive('get')->with('actionTrigger')->andReturn('api');
		$this->mocks->config->shouldReceive('get')->with('usePathInfo')->andReturn(true);
		$this->mocks->config->shouldReceive('get')->with('overridePhpSessionLocation')->andReturn(false);
		$this->mocks->config->shouldReceive('get')->with('translationDebugOutput')->andReturn(false);
		$this->mocks->config->shouldReceive('get')->with('defaultTemplateExtensions')->andReturn(array('html', 'twig', 'xml', 'json'));
		$this->mocks->config->shouldReceive('get')->with('indexTemplateFilenames')->andReturn(array('index'));
		$this->mocks->config->shouldReceive('get')->with('tokenParam')->andReturn('token');
		$this->mocks->config->shouldReceive('get')->with('cacheMethod')->andReturn('file');

		$this->mocks->config->shouldReceive('getLocalized')->with('loginPath')->andReturn('login');
		$this->mocks->config->shouldReceive('getLocalized')->with('logoutPath')->andReturn('logout');
		$this->mocks->config->shouldReceive('getLocalized')->with('setPasswordPath')->andReturn('setpassword');
		$this->mocks->config->shouldReceive('getLocalized')->with('siteUrl')->andReturn('http://plugin.craft.dev');

		$this->mocks->config->shouldReceive('getCpLoginPath')->andReturn('login');
		$this->mocks->config->shouldReceive('getCpLogoutPath')->andReturn('logout');
		$this->mocks->config->shouldReceive('getCpSetPasswordPath')->andReturn('setpassword');
		$this->mocks->config->shouldReceive('getResourceTrigger')->andReturn('resource');

		$this->mocks->config->shouldReceive('get')->with('slugWordSeparator')->andReturn('-');
		$this->mocks->config->shouldReceive('get')->with('allowUppercaseInSlug')->andReturn(false);
		$this->mocks->config->shouldReceive('get')->with('addTrailingSlashesToUrls')->andReturn(false);

		$this->setComponent(craft(), 'config', $this->mocks->config);
	}

	public function autoload()
	{
		$map = array(
			'\\Craft\\PermissionFieldsPlugin' => '../PermissionFieldsPlugin.php',
		);

		$fieldTypes = array();

		foreach($this->fieldTypes as $fieldType => $name)
		{
			$fieldTypes['\\Craft\\PermissionFields_'.$fieldType.'FieldType']
				= '../fieldtypes/PermissionFields_'.$fieldType.'FieldType.php';
		}

		$map = array_merge($map, $fieldTypes);

		foreach ($map as $classPath => $filePath)
		{
			if (!class_exists($classPath, false))
			{
				require_once $filePath;
			}
		}
	}
}