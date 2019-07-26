<?php
/**
 * General Settings template
 */

?>
<div id="tab-activate" class="col cols panel whpf-panel">
    <div class="inner-panel">
        <h3>General Settings</h3>
        <form id="whpf-panel" method="post" action="options.php">
            <?php
            settings_fields( 'whpf_general' );
            do_settings_sections( 'whpf_panel_general' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
</div>
