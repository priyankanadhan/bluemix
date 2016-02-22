<style>
.flexslider {
	margin-bottom: 10px;
}

.flex-control-nav {
	position: relative;
	bottom: auto;
}

.custom-navigation {
	display: table;
	width: 100%;
	table-layout: fixed;
}

.custom-navigation>* {
	display: table-cell;
}

.custom-navigation>a {
	width: 50px;
}

.custom-navigation .flex-next {
	text-align: right;
}
</style>
<body class="loading">
	<div class="panel panel-default"
		style="overflow: hidden; width: 93%; margin-left: 4%;">

		<div class="panel-heading">
			<div id="container" class="cf">


				<div id="main" role="main">

					<section class="slider1">
						<div class="flexslider">
							<ul class="slides">
          <?php foreach($tableValues as $values){?>
            <li><img src="<?php echo  "../uploads/".$values['name']?>"
									style="height: 400px"></li>
            <?php }?>
          </ul>
						</div>
					</section>


				</div>

			</div>
		</div>
	</div>
	<style>
.flex-direction-nav a:before {
	content: "<";
}

.flex-direction-nav a.flex-next:before {
	content: ">";
}

.flexslider .flex-next {
	opacity: 1;
	right: 5px;
}

.flexslider .flex-prev {
	opacity: 1;
	left: 5px;
	
}

.flex-direction-nav .flex-disabled {
	opacity: 1 !important;
}
</style>
	<!-- jQuery -->
	<script
		src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>


	<script type="text/javascript">
   
    $(window).load(function(){
      $('.flexslider').flexslider({
          controlNav: false ,
          slideshow: false,
          animationLoop: false,
        controlsContainer: $(".custom-controls-container"),
        customDirectionNav: $(".custom-navigation a"),
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    
    });
  </script>



</body>
