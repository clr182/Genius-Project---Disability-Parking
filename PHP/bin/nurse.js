$(document).ready(function(){
$('input[type="button"]')
 .filter(function(){
   return ($ (this).val() === 'ADD+')
 })
 .on('click',function(){
   var napis= $('textarea').eq(0).val();
   $('p#cel').html(napis);
 })

