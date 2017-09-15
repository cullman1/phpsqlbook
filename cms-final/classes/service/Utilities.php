<?php

/**
 * Utilities short summary.
 *
 * Utilities description.
 *
 * @version 1.0
 * @author Chris
 */
class Utilities
{
  public static function createPagination($count, $show, $from) {
  $total_pages  = ceil($count / $show);       // Total matches
  $current_page = ceil($from / $show) + 1;    // Current page
  $result  = '<nav aria-label="Page navigation"><ul class="pagination">';
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      if ($i == $current_page) {
        $result .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
      } else {
        $result .= '<li class="page-item"><a class="page-link"  href="?show=' . $show . '&from=' . (($i-1) * $show) . '">';
        $result .= $i . '</a></li>';
       }
    }
  } 
  $result .= '</ul></nav>';
  return $result ;
}

  public static function createSlug($text) {
    $text = strtolower($text);
    $text = trim($text);
    $text = preg_replace('/[^A-z0-9 ]+/', '', $text);
    $text = preg_replace('/ /', '-', $text);
    return $text;
  }

}