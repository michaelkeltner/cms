<?php

?>
<div class="ahpsite_menu">
    <ul>
        <li><a href="<?php echo SITE_URL?>schoollist"<?php if (isInUrl('schoollist')):?> class="current"<?php endif;?>>School List</a></li>
        <li><a href="<?php echo SITE_URL?>suggest"<?php if (isInUrl('suggest')):?> class="current"<?php endif;?>>E-Suggest</a></li>
        <li><a href="<?php echo SITE_URL?>changes"<?php if (isInUrl('changes')):?> class="current"<?php endif;?>>Changes</a></li>
        <li><a href="<?php echo SITE_URL?>filetransfer"<?php if (isInUrl('filetransfer')):?> class="current"<?php endif;?>>File Transfer</a></li>
        <li><a href="<?php echo SITE_URL?>faq"<?php if (isInUrl('faq')):?> class="current"<?php endif;?>>FAQ</a></li>
        <li><a href="<?php echo SITE_URL?>cms"<?php if (isInUrl('cms')):?> class="current"<?php endif;?>>CMS</a></li>
    </ul>
    <br style="clear:left"/>
</div>
