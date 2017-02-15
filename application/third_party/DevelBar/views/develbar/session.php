<img src="<?php echo $icon ?>"
     alt="<?php echo lang('session') ?>"
     title="<?php echo lang('session') ?>"/> <?php echo count($session) ? lang('session') : 'N/A' ?>
<?php if (count($session)): ?>
    <div class="detail config">
        <div class="scroll">
            <?php
            foreach ($session as $key => $val) {
                if (is_array($val) OR is_object($val)) {
                    $val = print_r($val, true);
                }
                echo '<p>';
                echo '<span class="left-col" style="width:45%"><strong>' . $key . ':</strong></span>';
                echo '<span class="right-col" style="width:55%"><pre>' . htmlentities($val) . '</pre></span>';
                echo '</p>';
            }
            ?>
        </div>
    </div>
<?php endif ?>
