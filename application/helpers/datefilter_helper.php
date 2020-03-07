<?php 

function ddmmyytt($date){
    $date=explode("-",$date);
    $d=explode(" ",$date[2]);
    $yy=$date[0];
    $mm=$date[1];
    $dd=$d[0];
    $fdate= $dd.'-'.$mm.'-'.$yy;
    return $fdate;
}

function ddmmyy($date){
    $date=explode("-",$date);
    // $d=explode(" ",$date[2]);
    $yy=$date[0];
    $mm=$date[1];
    $dd=$date[2];
    $fdate= $dd.'-'.$mm.'-'.$yy;
    return $fdate;
}
