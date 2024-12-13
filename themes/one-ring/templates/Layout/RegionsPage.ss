<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-8">

				<!-- open blog listing -->
				<div class="grid-style1 clearfix">
                    <% loop $Regions %>
						<div class="item col-md-12"><!-- set width to 4 columns for grid view mode only -->
							<div class="image image-large">
								<a href="$Link">
									<span class="btn btn-default"><i class="fa fa-file-o"></i> Read More</span>
								</a>
                                <% if $Photo %>
                                    $Photo.CroppedImage(420,282)
                                <% else %>
									<img src="http://placehold.co/420x282" alt=""/>
                                <% end_if %>
							</div>
							<div class="info-blog">
								<h3>
									<a href="$Link">$Title</a>
								</h3>
                                $Description.FirstParagraph
							</div>
						</div>
                    <% end_loop %>
				</div>
				<!-- closing blog listing -->

				<!-- open pagination -->
				<div class="pagination">
					<ul id="previous">
						<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
					</ul>
					<ul>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
					</ul>
					<ul id="next">
						<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
					</ul>
				</div>
				<!-- closing pagination -->

			</div>
			<!-- closing main content -->

			<!-- open sidebar -->
			<div class="sidebar gray col-sm-4">

				<!-- open latest news -->
				<h2 class="section-title">Popular articles</h2>
				<ul class="latest-news">
					<li class="col-md-12">
						<div class="image">
							<a href="blog-detail.html"></a>
							<img src="http://placehold.it/100x100" alt=""/>
						</div>
						<ul class="top-info">
							<li><i class="fa fa-calendar"></i> 30 July 2014</li>
						</ul>
						<h4><a href="#">It's all about the Northeast</a></h4>
					</li>
					<li class="col-md-12">
						<div class="image">
							<a href="blog-detail.html"></a>
							<img src="http://placehold.it/100x100" alt=""/>
						</div>
						<ul class="top-info">
							<li><i class="fa fa-calendar"></i> 20 July 2014</li>
						</ul>
						<h4><a href="#">Southwest: Best ever</a></h4>
					</li>
					<li class="col-md-12">
						<div class="image">
							<a href="blog-detail.html"></a>
							<img src="http://placehold.it/100x100" alt=""/>
						</div>
						<ul class="top-info">
							<li><i class="fa fa-calendar"></i> 10 July 2014</li>
						</ul>
						<h4><a href="#">I went to the Northwest and stole from and old lady</a></h4>
					</li>
				</ul>
				<!-- closing latest news -->

			</div>
			<!-- closing sidebar -->

		</div>
	</div>
</div>
<!-- closing content wrapper -->
