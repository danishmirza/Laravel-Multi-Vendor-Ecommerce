<?php


function generateRandomNumber($digits){
   return rand(pow(10, $digits-1), pow(10, $digits)-1);
}