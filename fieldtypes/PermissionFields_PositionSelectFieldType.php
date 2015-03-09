<?php
namespace Craft;

/**
 * Permission Fields Position Select Field Type class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.fieldtypes
 * @since     1.0.0
 */
class PermissionFields_PositionSelectFieldType extends PositionSelectFieldType
{
	public function getName()
	{
		return Craft::t('Permission Position Select');
	}

	public function getInputHtml($name, $value)
	{
		if (craft()->userSession->checkPermission('permissionFields_editField:'.$this->model->id))
		{
			return parent::getInputHtml($name, $value);
		}
		else
		{
			craft()->templates->includeJs('$("#fields-'.$name.'-field").remove();');
		}
	}
}