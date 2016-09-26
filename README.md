# cf-search-active-directory-field
This is a field for [Caldera Forms](https://github.com/CalderaWP/Caldera-Forms) to search Active directory and help set value of other fields.

1. Copy all files under `caldera-forms/fields/search-active-directory` folder
2. Add this code to your `core.php` file
```
'search-ad' => array(
    "field"		=>	__("Search Active Directory"),
    "description" => __('Helper to fill fields with data from AD'),
    "file"		=>	CFCORE_PATH . "fields/search-active-directory/field.php",
    "functions" => 	CFCORE_PATH . "fields/search-active-directory/functions.php",
    "category"	=>	__("Special", "caldera-forms"),
    "icon"		=>	CFCORE_URL . "fields/search-active-directory/icon.png",
    "capture"	=>	false,
    "options"	=>	"single",
    "setup"		=>	array(
        "preview"	=>	CFCORE_PATH . "fields/search-active-directory/preview.php",
        "template"	=>	CFCORE_PATH . "fields/search-active-directory/config_template.php",
    ),
    "scripts"	=>	array(
        'jquery',
        CFCORE_URL . "fields/search-active-directory/assets/js/search-ad.js"
    ),
    "styles"	=> array(
        CFCORE_URL . "fields/search-active-directory/assets/css/search-ad.css",
        CFCORE_URL . "fields/search-active-directory/assets/font-awesome/css/font-awesome.min.css"
    )
),
```
3. Copy the `config/config.sample.php` file to `config/config.php` and set your configuration.
4. Add the field to your form and set the options as follows: 
- Value = Field value in LDAP / AD
- Title = Field slug in Caldera Forms