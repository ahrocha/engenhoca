<?php

echo 'ALLOWED_IPS : '.getenv('ALLOWED_IPS');
echo '<br />';
echo 'Este IP : '. $_SERVER['REMOTE_ADDR'];
