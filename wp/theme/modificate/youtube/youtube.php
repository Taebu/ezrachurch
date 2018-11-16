<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once('../head.php');


//print_r($_SERVER);

?>



    <!-- Page Content -->
	<div class="container">
 <script src="js/jquery.js"></script>

 <style>
 /* Source: http://bootsnipp.com/snippets/featured/responsive-youtube-player */
 .vid {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px; height: 0; overflow: hidden;
}
 
.vid iframe,
.vid object,
.vid embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
 </style>


 
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
        <div class="row">
            <div class="col-lg-12 text-center">
              
			  
                <div id="youtube-gallery"></div>

				<script>
				//Load video list
				$("#youtube-gallery").load('list/youtube_video.php?pr_list=<?php echo $pr_list;?>');
//				$("#youtube-gallery").load('ist/index.php?pr_list=<?php echo $pr_list;?>');

				</script>
				
				
            </div>
			
			
			
        </div>
        <!-- /.row -->

		
    </div>
    <!-- /.container -->


<?php
include_once(G5_PATH.'/tail.php');
?>