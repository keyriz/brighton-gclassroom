<% include Breadcrumb %>

<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-8">
                $Content
				<div id="blog-listing" class="list-style clearfix">
					<div class="row">
                        <% if $PaginatedList.Exists %>
                            <% loop $PaginatedList %>
                                <% include BlogSearchResults %>
                                <%--                                <% include PostSummary %>--%>
                            <% end_loop %>
                        <% else %>
							<p><%t Blog.NoPosts 'There are no posts' %></p>
                        <% end_if %>
					</div>
				</div>
			</div>
			<!-- closing main content -->

			<div class="sidebar gray col-sm-4">
                <% include BlogSideBar %>
			</div>
		</div>
	</div>
</div>
<!-- closing content wrapper -->
