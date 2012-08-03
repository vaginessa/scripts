<?php

//from http://www.hawkee.com/snippet/8185/

echo handle_pagination(100, (int)$_GET['p'], 10, '?p=');

function handle_pagination($total, $page, $shown, $url) {
  $pages = ceil( $total / $shown ); 
  $range_start = ( ($page >= 5) ? ($page - 3) : 1 );
  $range_end = ( (($page + 5) > $pages ) ? $pages : ($page + 5) );
  
  if ( $page >= 1 ) {
    $r[] = '<span><a href="'. $url .'">&laquo; first</a></span>';
    $r[] = '<span><a href="'. $url . ( $page - 1 ) .'">&lsaquo; previous</a></span>';
    $r[] = ( ($range_start > 1) ? ' ... ' : '' ); 
  }
  
  if ( $range_end > 1 ) {
    foreach(range($range_start, $range_end) as $key => $value) {
      if ( $value == ($page + 1) ) $r[] = '<span>'. $value .'</span>'; 
      else $r[] = '<span><a href="'. $url . ($value - 1) .'">'. $value .'</a></span>'; 
    }
  }
  
  if ( ( $page + 1 ) < $pages ) {
    $r[] = ( ($range_end < $pages) ? ' ... ' : '' );
    $r[] = '<span><a href="'. $url . ( $page + 1 ) .'">next &rsaquo;</a></span>';
    $r[] = '<span><a href="'. $url . ( $pages - 1 ) .'">last &raquo;</a></span>';
  }
  
  return ( (isset($r)) ? '<div>'. implode("\r\n", $r) .'</div>' : '');
}

?>
