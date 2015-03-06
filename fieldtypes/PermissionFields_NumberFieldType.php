<?php
namespace Craft;

/**
 * Permission Fields Number Field Type class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.fieldtypes
 * @since     1.0.0
 */
class PermissionFields_NumberFieldType extends NumberFieldType
{
	public function getName()
	{
		return Craft::t('Permission Number');
	}

	public function getInputHtml($name, $value)
	{
		if (craft()->userSession->checkPermission('editField:'.$this->model->id))
		{
			return parent::getInputHtml($name, $value);
		}
		else
		{
			craft()->templates->includeJs('$("#fields-'.$name.'-field").remove();');
		}
	}
}