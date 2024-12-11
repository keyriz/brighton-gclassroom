<!-- open footer -->
<footer id="footer">
	<div id="footer-top" class="container">
		<div class="row">
			<div class="block col-sm-3">
				<a href="#"><img src="$ThemeDir/images/logo.png" alt="One Ring Rentals"/></a>
				<br><br>
				<p>$SiteConfig.FooterContent</p>
			</div>
			<div class="block col-sm-3">
				<h3>Helpful Links</h3>
				<ul class="footer-links">
					<li><a href="#">All rentals</a></li>
					<li><a href="#">List your rental</a></li>
					<li><a href="#">Read our FAQs</a></li>
				</ul>
			</div>
			<div class="block col-sm-6">
				<h3>Popular regions</h3>
				<div class="row">
					<div class="col-sm-6">
						<ul class="footer-listings">
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Rhovanion</a></p>
							</li>
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Eriador</a></p>
							</li>
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Bay of Belfalas</a></p>
							</li>
						</ul>
					</div>
					<div class="col-sm-6">
						<ul class="footer-listings">
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Mordor</a></p>
							</li>
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Arnor</a></p>
							</li>
							<li>
								<div class="image">
									<a href="properties-detail.html"><img src="http://placehold.co/760x670" alt=""/></a>
								</div>
								<p><a href="properties-detail.html">Forlindon</a></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- open copyright -->
	<div id="copyright">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					&copy; 2014 One Ring Rentals

					<!-- open social networks -->
					<ul class="social-networks">
                        <% with $SiteConfig %>
                            <% if $FacebookLink %>
								<li><a href="$FacebookLink"><i class="fa fa-facebook"></i></a></li>
                            <% end_if %>
                            <% if $TwitterLink %>
								<li><a href="$TwitterLink"><i class="fa fa-twitter"></i></a></li>
                            <% end_if %>
                            <% if $GoogleLink %>
								<li><a href="$GoogleLink"><i class="fa fa-instagram"></i></a></li>
                            <% end_if %>
                            <% if $YouTubeLink %>
								<li><a href="$YouTubeLink"><i class="fa fa-youtube"></i></a></li>
                            <% end_if %>
                        <% end_with %>
					</ul>
					<!-- closing social networks -->

				</div>
			</div>
		</div>
	</div>
	<!-- closing copyright -->

</footer>
<!-- closing footer -->
