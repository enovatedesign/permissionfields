# Permission Fields plugin for Craft

Granular permissions for individual fields in Craft CMS.

## Field Types

This plugin allows you to create fields that are protected by Craft's user permissions system, so
only users with permission can view or update the contents of those fields.

Most of Craft's built-in field types are supported:

* Assets
* Categories
* Checkboxes
* Color
* Date
* Dropdown
* Entries
* Lightswitch
* Multi Select
* Number
* Plain Text
* Position Select
* Radio Buttons
* Rich Text
* Table
* Tags
* Users

Sorry, no Matrix fields.

## Field Convertor

Although it is safe to go to the field settings and change a **Plain Text** field in to a
**Permission Plain Text** field, in that there would be no data loss, you would have to input all
the settings again. To save the trouble, in the plugin settings there is a tool for migrating fields
back and forth.

## Todo

* Matrix field support.
* Permissions for whole field groups.
* An option for permission to view, but not edit fields.

## License

MIT