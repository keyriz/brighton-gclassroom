<% include Breadcrumb %>

<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="main col-sm-8">
                <% with $Region %>
                    <div class="blog-main-image">
                        <% if $Photo %>
                            $Photo.CroppedImage(750,500)
                        <% else %>
                            <img src="http://placehold.co/750x500" alt=""/>
                        <% end_if %>
                    </div>
                    <p>$Description</p>
                <% end_with %>
            </div>

            <div class="sidebar gray col-sm-4">
                <h2 class="section-title">Region</h2>
                <ul class="categories subnav">
                    <% loop $Regions %>
                        <li class="$LinkingMode"><a class="$LinkingMode" href="$Link">$Title</a></li>
                    <% end_loop %>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->