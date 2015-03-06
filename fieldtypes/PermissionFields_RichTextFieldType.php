<?php
namespace Craft;

/**
 * Permission Fields Rich Text Field Type class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.fieldtypes
 * @since     1.0.0
 */
class PermissionFields_RichTextFieldType extends RichTextFieldType
{
	public function getName()
	{
		return Craft::t('Permission Rich Text');
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