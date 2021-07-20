<?php

function dump($data)
{
   echo '<div 
   style="
   display: inline-block;
   padding: 0 10px;
   border: 1px solid gray;
   background: lightgray;
   "
   >
   <pre>';
   print_r($data);
   echo '</pre>
   </div>';
}
