<?php
if(!empty($field['config']['placeholder'])){
    $field_placeholder = 'placeholder="'.$field['config']['placeholder'].'"';
}
?>
<?php echo $wrapper_before; ?>
<?php echo $field_label; ?>
<?php echo $field_before; ?>
<?php if($form['editable']): ?>
    <div class="search-active-directory-container">
        <div class="container-1 clearfix">
            <span class="search-icon"><i class="fa fa-search"></i></span>
            <span class="loading-icon"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></span>
            <input <?php echo $field_placeholder; ?> type="text" <?php echo $mask; ?> data-field="<?php echo $field_base_id; ?>" class="<?php echo $field_class; ?> search-active-directory" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>">
        </div>
        <?php
        $dataOptions = '';
        $dataKeys = '';
        if(!empty($field['config']['option'])){
            foreach($field['config']['option'] as $option_key=>$option){
                $dataKeys .= (empty($dataKeys) ? '' : ';').$option_key;
                $fieldId = cfSearchActiveDirectory::searchFieldIdFromSlug($form['fields'], $option['label'])."_{$current_form_count}";
                $dataOptions .= " data-{$option_key}fieldad='".$option['value']."' data-{$option_key}fieldcf='".$option['label']."' data-{$option_key}fieldcfid='".$fieldId."'";
            }
        }
        ?>
        <div class="search-active-directory-results" id="search-active-directory-results-<?php echo $field_id; ?>" data-keys="<?php echo $dataKeys; ?>" <?php echo $dataOptions; ?>></div>
    </div>
<?php endif; ?>
<?php echo $field_caption; ?>
<?php echo $field_after; ?>
<?php echo $wrapper_after; ?>