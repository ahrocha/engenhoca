<h2>V 20190911</h2>

<pre>
<?php

if (isset($numeros) && is_array($numeros)) {
    extract($numeros);
    
    echo implode(' ', $linhaA).'<br />';
    echo implode(' ', $linhaB).'<br />';
    echo implode(' ', $linhaC).'<br />';
    echo implode(' ', $linhaD).'<br />';

}

?>
</pre>
