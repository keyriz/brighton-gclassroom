<!-- open sidebar article -->
<div class="sidebar gray col-sm-4">

	<!-- open category accordion -->
	<h2 class="section-title">Categories</h2>
	<ul class="categories">
        <% loop $Categories %>
			<li><a href="$Link">$Title <span>($Articles.count)</span></a></li>
        <% end_loop %>
	</ul>
	<!-- closing category accordion -->

	<!-- open archives accordion -->
	<h2 class="section-title">Archives</h2>
	<div id="accordion" class="panel-group blog-accordion">

        <% loop $ArchiveDates %>
			<div class="panel">
				<div class="panel-heading">
					<div class="panel-title">
						<a data-parent="#accordion" href="$Link" class="collapsed">
							<i class="fa fa-chevron-right"></i> $MonthName $Year ($ArticleCount)
						</a>
					</div>
				</div>
			</div>
        <% end_loop %>

	</div>
	<!-- closing archives accordion -->

	<!-- open tags -->
	<h2 class="section-title">Tags</h2>
	<ul class="tags col-sm-12">
		<li><a href="#">Apartments</a></li>
		<li><a href="#">Residential</a></li>
		<li><a href="#">News</a></li>
		<li><a href="#">Real estate</a></li>
		<li><a href="#">Land</a></li>
		<li><a href="#">Business</a></li>
		<li><a href="#">Villas</a></li>
		<li><a href="#">Loans</a></li>
		<li><a href="#">Commercial</a></li>
		<li><a href="#">Rent</a></li>
	</ul>
	<!-- closing tags -->

	<!-- open regions -->
	<h2 class="section-title">Regions</h2>
	<ul class="categories">
        <% loop $Regions %>
			<li><a href="$ArticlesLink">$Title <span>($Articles.count)</span></a></li>
        <% end_loop %>
	</ul>
	<!-- closing regions -->

	<!-- open latest news -->
	<h2 class="section-title">Latest News</h2>
	<ul class="latest-news">
		<li class="col-md-12">
			<div class="image">
				<a href="#"></a>
				<img src="http://placehold.co/100x100" alt=""/>
			</div>

			<ul class="top-info">
				<li><i class="fa fa-calendar"></i> July 30, 2014</li>
			</ul>

			<h3><a href="#">How to get your dream property for the best price?</a></h3>
		</li>
		<li class="col-md-12">
			<div class="image">
				<a href="#"></a>
				<img src="http://placehold.co/100x100" alt=""/>
			</div>
			<ul class="top-info">
				<li><i class="fa fa-calendar"></i> July 24, 2014</li>
			</ul>
			<h3><a href="#">7 tips to get the best mortgage.</a></h3>
		</li>
		<li class="col-md-12">
			<div class="image">
				<a href="#"></a>
				<img src="http://placehold.co/100x100" alt=""/>
			</div>
			<ul class="top-info">
				<li><i class="fa fa-calendar"></i> July 05, 2014</li>
			</ul>
			<h3><a href="#">House, location or price: What's the most important factor?</a>
			</h3>
		</li>
	</ul>
	<!-- closing latest news -->

</div>
<!-- closing sidebar article -->