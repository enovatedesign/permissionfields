<?php
namespace Craft;

/**
 * Permission Fields Field Manager Controller class
 *
 * @author    Mike Pepper, Enovate Design Ltd <mike.pepper@enovate.co.uk>
 * @copyright Copyright (c) 2015, Enovate Design, Ltd.
 * @license   MIT
 * @package   craft.plugins.permissionfields.controllers
 * @since     1.1.0
 */
class PermissionFields_FieldManagerController extends BaseController
{
	public function actionIndex(array $variables = array())
	{
		$variables['supportedFieldTypes'] = craft()->permissionFields->getSupportedFieldTypes();

		$variables['allSupportedFieldTypes'] = array_merge(
			array_keys($variables['supportedFieldTypes']),
			array_values($variables['supportedFieldTypes'])
		);

		$variables['fields'] = craft()->permissionFields->getFieldsByFieldType($variables['allSupportedFieldTypes']);

		$this->renderTemplate('permissionFields/manager', $variables);
	}

	public function actionEnableField(array $variables = array())
	{
		$fieldId   = craft()->request->getRequiredPost('fieldId');
		$fieldType = craft()->request->getRequiredPost('fieldType');

		if (craft()->permissionFields->updateFieldTypeByFieldId($fieldId, 'PermissionFields_'.$fieldType))
		{
			craft()->permissionFields->getUserPermissions(true);
			craft()->userSession->setNotice('Permission field enabled.');
		}
		else
		{
			craft()->userSession->setError(Craft::t('Couldn’t enable permission field.'));
		}

		$this->redirectToPostedUrl();
	}

	public function actionDisableField(array $variables = array())
	{
		$fieldId   = craft()->request->getRequiredPost('fieldId');
		$fieldType = craft()->request->getRequiredPost('fieldType');

		if (craft()->permissionFields->updateFieldTypeByFieldId($fieldId, str_replace('PermissionFields_', '', $fieldType)))
		{
			craft()->permissionFields->getUserPermissions(true);
			craft()->userSession->setNotice('Permission field disabled.');
		}
		else
		{
			craft()->userSession->setError(Craft::t('Couldn’t disable permission field.'));
		}


		$this->redirectToPostedUrl();
	}
}