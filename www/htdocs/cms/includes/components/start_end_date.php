 <p class="name">
    <input class="date_picker" type="text" name="content[<?php echo $iSectionId ?>][component_start_date][]" value="<?php echo $sStartDate ?>"/>
    <select name="content[<?php echo $iSectionId ?>][component_start_time][]"  value="<?php echo $sStartTime ?>" id="start_time" class="start_time">
        <option value="00:00:00"<?php if('00:00:00'==$sStartTime):?> selected="selected"<?php endif?>>midnight</option>
        <option value="00:01:00"<?php if('00:01:00'==$sStartTime):?> selected="selected"<?php endif?>>1 minute after midnight</option>
        <?php for ($h=0; $h<24; $h++):?>
        <?php $sAMPM = ($h < 12)?'AM':'PM'; ?>
        <?php $sShowHour = ($h >12)?$h-12:$h?>
        <?php for ($m=0; $m<60; $m+= 5):?>
        <?php if ($m == 0 && $h ==0){continue;} ?>
        <?php $sTimeValue = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ':00' ?>
        <option value="<?php echo str_pad($h, 2, '0', STR_PAD_LEFT)?>:<?php echo str_pad($m, 2, '0', STR_PAD_LEFT)?>:00"<?php if($sTimeValue==$sStartTime):?> selected="selected"<?php endif?>><?php echo str_pad($sShowHour, 2, '0', STR_PAD_LEFT). ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ' ' . $sAMPM?></option>
        <?php endfor;?>
        <?php endfor;?>
        <option value="23:59:00"<?php if('23:59:00'==$sStartTime):?> selected="selected"<?php endif?>>one minute before midnight</option>
</select>
    <label for="start_timestamp">Show</label>
</p>
<p class="name">
    <input class="date_picker" type="text" name="content[<?php echo $iSectionId ?>][component_end_date][]" value="<?php echo $sEndDate ?>"/>
    <select name="content[<?php echo $iSectionId ?>][component_end_time][]"  value="<?php echo $sEndTime ?>" id="end_time" class="end_time">
        <option value="00:00:00"<?php if('00:00:00'==$sEndTime):?> selected="selected"<?php endif?>>midnight</option>
        <option value="00:01:00"<?php if('00:01:00'==$sEndTime):?> selected="selected"<?php endif?>>1 minute after midnight</option>
        <?php for ($h=0; $h<24; $h++):?>
        <?php $sAMPM = ($h < 12)?'AM':'PM'; ?>
        <?php $sShowHour = ($h >12)?$h-12:$h?>
        <?php for ($m=0; $m<60; $m+= 5):?>
            <?php if ($m == 0 && $h ==0){continue;} ?>
        <?php $sTimeValue = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ':00' ?>
        <option value="<?php echo str_pad($h, 2, '0', STR_PAD_LEFT)?>:<?php echo str_pad($m, 2, '0', STR_PAD_LEFT)?>:00"<?php if($sTimeValue==$sEndTime):?> selected="selected"<?php endif?>><?php echo str_pad($sShowHour, 2, '0', STR_PAD_LEFT). ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ' ' . $sAMPM?></option>
        <?php endfor;?>
        <?php endfor;?>
        <option value="23:59:00"<?php if('23:59:00'==$sEndTime):?> selected="selected"<?php endif?>>one minute before midnight</option>
</select>
    <label for="end_timestamp">Hide</label>
</p>
       