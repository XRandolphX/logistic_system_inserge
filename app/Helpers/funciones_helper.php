<?php
function generarcombo($data, $textodefecto)
{
    $comb = array();
    foreach ($data as $obj) {
        $comb[$obj['v1']] = $obj['v2'];
    }
    $comb[''] = $textodefecto;
    return $comb;
}
