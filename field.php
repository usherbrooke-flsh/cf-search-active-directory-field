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
        <div class="search-active-directory-results" id="search-active-directory-results-<?php echo $field_id; ?>"></div>
    </div>
<?php endif; ?>
<?php echo $field_caption; ?>
<?php echo $field_after; ?>
<?php echo $wrapper_after; ?>