<% include Breadcrumb %>

<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-8">
				<article>
					<h1 class="blog-title mb-4">$Title</h1>

                    <% if $FeaturedImage %>
						<p class="post-image">$FeaturedImage.setWidth(795)</p>
                    <% end_if %>

					<div class="content mb-8">$Content</div>

                    <% include EntryMeta %>
				</article>
			</div>
			<!-- closing main content -->

			<div class="sidebar gray col-sm-4">
                <% include BlogSideBar %>
			</div>
		</div>
	</div>
</div>
<!-- closing content wrapper -->
