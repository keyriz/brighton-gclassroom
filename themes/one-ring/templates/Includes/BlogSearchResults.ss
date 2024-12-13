<div class="item col-sm-6">
	<div class="image">
		<a href="$Link">
			<span class="btn btn-default">Read More</span>
		</a>
        <% if $Photo %>
            $FeaturedImage.CroppedImage(240,180)
        <% else %>
			<img src="https://placehold.co/240x180" alt=""/>
        <% end_if %>
	</div>
	<div class="info-blog">
		<div class="top-info">
            <% include EntryMeta %>
		</div>
		<h3>
			<a href="$Link">
                <% if $MenuTitle %>$MenuTitle
                <% else %>$Title<% end_if %>
			</a>
		</h3>
        <% if $Summary %>
            $Summary
        <% else %>
			<p>$Excerpt</p>
        <% end_if %>
	</div>
</div>