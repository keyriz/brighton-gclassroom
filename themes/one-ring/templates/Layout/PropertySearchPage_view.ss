<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-12">

				<div class="property-image">
					<span class="property-category badge badge-lg badge-primary">$Property.Category.Title</span>
                    <% if $Property.PrimaryPhoto %>
                        <% with $Property.PrimaryPhoto %>
							<img src="$URL" alt="property-image"/>
                        <% end_with %>
                    <% else %>
						<img src="https://placehold.co/1280x400" class="property-image" alt="property-image"/>
                    <% end_if %>
				</div>

				<div class="row">
					<div class="col-sm-8">
						<div class="property-info">
							<h1 class="property-title">$Title</h1>
                            <%--                            <div class="property-tags">--%>
                            <%--                                <% loop $Property.Types %>--%>
                            <%--                                    <span class="badge badge-primary badge-md">$Title</span>--%>
                            <%--                                <% end_loop %>--%>
                            <%--                            </div>--%>
							<p class="property-summary">$Property.Summary</p>
							<div class="property-details">
								<h4>Details Property</h4>
								<div class="row">
									<div class="col-sm-6"><p>Bedrooms</p></div>
									<div class="col-sm-6"><strong>$Property.Bedrooms</strong></div>
									<div class="col-sm-6"><p>Bathrooms</p></div>
									<div class="col-sm-6"><strong>$Property.Bathrooms</strong></div>
									<div class="col-sm-6"><p>LandArea</p></div>
									<div class="col-sm-6"><strong>$Property.LandArea</strong></div>
									<div class="col-sm-6"><p>BuildingArea</p></div>
									<div class="col-sm-6"><strong>$Property.BuildingArea</strong></div>
								</div>
							</div>
							<div class="property-description">
								<h4>Description Property</h4>
                                $Property.Description
							</div>
						</div>
					</div>
					<div class="col-sm-4 ">
						Place for Price
                        <%--                        <div class="position-relative" style="width: 100%; height: 800px">--%>
                        <%--                            <div class="sticky w-full">--%>
                        <%--                            </div>--%>
                        <%--                        </div>--%>
					</div>
				</div>
			</div>
			<!-- closing main content -->

		</div>
	</div>
</div>
<!-- closing content wrapper -->