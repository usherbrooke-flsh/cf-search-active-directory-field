# cf-search-active-directory-field
This is a field for [Caldera Forms](https://github.com/CalderaWP/Caldera-Forms) to search Active directory and help set value of other fields.

To add to your `core.php` file
```
'search-ad' => array(
    "field"		=>	__("Search Active Directory"),
    "description" => __('Helper to fill fields with data from AD'),
    "file"		=>	CFCORE_PATH . "fields/search-active-directory/field.php",
    "category"	=>	__("Content", "caldera-forms"),
    "icon"		=>	CFCORE_URL . "fields/search-active-directory/icon.png",
    "capture"	=>	false,
    "setup"		=>	array(
        "preview"	=>	CFCORE_PATH . "fields/search-active-directory/preview.php",
        "template"	=>	CFCORE_PATH . "fields/search-active-directory/config_template.php",
        "scripts"	=>	array(
            CFCORE_URL . "fields/search-active-directory/assets/js/search-ad.js"
        ),
        "styles"	=> array(
            CFCORE_URL . "fields/search-active-directory/assets/css/search-ad.css"
        )
    )
),
```