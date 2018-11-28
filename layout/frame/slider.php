<div id="slider-wrapper">
	<div id="slider-area" class="carousel slide" data-ride="carousel">
	   <!-- Indicators -->
	   <ol class="carousel-indicators">
		  <li data-target="#slider-area" data-slide-to="0" class="active"></li>
		  <li data-target="#slider-area" data-slide-to="1"></li>
		  <li data-target="#slider-area" data-slide-to="2"></li>
	   </ol>
	   <!-- Wrapper for slides -->
	   <div class="carousel-inner">
		  <div class="item active">
			 <img src="<?= getViewPath('images/slider/anh1.jpg') ?>" alt="Los Angeles">
		  </div>
		  <div class="item">
			 <img src="<?= getViewPath('images/slider/anh2.jpg') ?>" alt="Chicago">
		  </div>
		  <div class="item">
			 <img src="<?= getViewPath('images/slider/anh1.jpg') ?>" alt="New York">
		  </div>
	   </div>
	   <!-- Left and right controls -->
	   <a class="left carousel-control" href="#slider-area" data-slide="prev">
	   <span class="glyphicon glyphicon-chevron-left"></span>
	   <span class="sr-only">Previous</span>
	   </a>
	   <a class="right carousel-control" href="#slider-area" data-slide="next">
	   <span class="glyphicon glyphicon-chevron-right"></span>
	   <span class="sr-only">Next</span>
	   </a>
	</div>
</div>