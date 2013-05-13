
 </div><!-- #content --> 

 <div class="clear"></div>

<?php wp_footer(); ?>

<!-- Stats starts, add your stats in theme options -->

<?php
$analytics = get_option('clutterless_analytics');
if ($analytics != 'Paste code here') {
echo $analytics;}
else {
echo ("");};
?>

<!-- Stats end -->

</body>
</html>