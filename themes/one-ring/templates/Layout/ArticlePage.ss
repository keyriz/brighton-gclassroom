<% include Breadcrumb %>

<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-8">

				<h1 class="blog-title mb-4">$Title</h1>

				<div id="post-author" class="mb-4">By $Author</div>

				<div class="blog-main-image mb-4">
                    <% if $Photo %>
                        <% with $Photo.CroppedImage(765,362) %>
							<img src="$URL" width="$Width" height="$Height" alt=""/>
                        <% end_with %>
                    <% else %>
						<img src="http://placehold.co/765x362" alt=""/>
                    <% end_if %>
					<div class="tag"><i class="fa fa-file-text"></i></div>
				</div>

				<div class="flex gap-2 mb-4">
					<span><i class="fa fa-calendar"></i> $Date.Long</span> |
					<span><i class="fa fa-comments-o"></i> 2</span> |
					<span><i class="fa fa-tags"></i> <% loop $Categories %>$Title<% if not $Last %>,<% end_if %><% end_loop %></span>
				</div>

				<div class="post-content">
					<p>
                        <% if $Content %>
                            $Content
                        <% else %>
                            $Teaser
                        <% end_if %>
					</p>
				</div>

				<div class="share-wraper col-sm-12 clearfix">
					<h5>Share:</h5>
					<ul class="social-networks">
						<li><a target="_blank"
						       href="http://www.facebook.com/sharer.php?s=100&amp;p%5Burl%5D=http%3A%2F%2Fwww.wiselythemes.com%2Fhtml%2Fcozy%2Fblog-detail.html%3Ffb%3Dtrue&amp;p%5Bimages%5D%5B0%5D=http%3A%2F%2Fwww.wiselythemes.com%2Fhtml%2Fcozy%2Fimages%2Fnews-img1.jpg&amp;p%5Btitle%5D=Cozy%20Blog%20Post"><i
								class="fa fa-facebook"></i></a></li>
						<li><a target="_blank"
						       href="https://twitter.com/intent/tweet?url=http://www.wiselythemes.com/html/cozy/blog-detail.html&amp;text=Cozy%20Blog%20Post"><i
								class="fa fa-twitter"></i></a></li>
						<li><a target="_blank"
						       href="https://plus.google.com/share?url=http://www.wiselythemes.com/html/cozy/blog-detail.html"><i
								class="fa fa-google"></i></a></li>
						<li><a target="_blank"
						       href="http://pinterest.com/pin/create/button/?url=http://www.wiselythemes.com/html/cozy/blog-detail.html&amp;description=Cozy%20Blog%20Post&amp;media=http%3A%2F%2Fwww.wiselythemes.com%2Fhtml%2Fcozy%2Fimages%2Fnews-img1.jpg"><i
								class="fa fa-pinterest"></i></a></li>
						<li><a
								href="mailto:?subject=Check%20out%20this%20blog%20post%20from%20Cozy%20Real%20Estate!&amp;body=http://www.wiselythemes.com/html/cozy/blog-detail.html"><i
								class="fa fa-envelope"></i></a></li>
					</ul>

					<a class="print-button" href="javascript:window.print();">
						<i class="fa fa-print"></i>
					</a>
				</div>

                <% if $Brochure %>
					<div class="col-sm-12" style="padding: unset">
						<a href="$Brochure.URL" class="download-button btn btn-warning btn-block" target="_blank">
							<i class="fa fa-download"></i> Download Brochure ($BrochureExtension) [$FormattedBrochureSize]
						</a>
					</div>
                <% end_if %>

				<h1 class="section-title">Comments</h1>

				<div class="comments">
                    <% if $Comments %>
						<ul>
                            <% loop $Comments %>
								<li>
									<img src="$ImageDir/themes/one-ring/images/comment-man.jpg" alt=""/>
									<div class="comment">
										<a href="#" class="btn btn-default-color mt-0">Reply</a>
										<h3>$Name<small>$Created.Format('j F, Y')</small></h3>
										<p>$Comment</p>
									</div>
								</li>
                            <% end_loop %>
						</ul>
                    <% else %>
						<p class="mb-8">Comment is Empty.</p>
                    <% end_if %>

					<div class="comments-form" style="padding: unset">
						<h3>Leave a Reply</h3>
						<p>Your email address will no be published. Required fields are marked*</p>

                        $CommentForm
					</div>
				</div>

			</div>
			<!-- closing main content -->

            <% include SideBar %>

		</div>
	</div>
</div>
<!-- closing content wrapper -->