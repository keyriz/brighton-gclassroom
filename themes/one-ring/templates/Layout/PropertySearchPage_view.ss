<!-- open content wrapper -->
<div class="content">
	<div class="container">
		<div class="row">

			<!-- open main content -->
			<div class="main col-sm-12">

				<div class="property-image position-relative mb-8">
					<span class="property-category badge badge-lg badge-primary text-base">$Property.Category.Title</span>
                    <% if $Property.PrimaryPhoto %>
                        <% with $Property.PrimaryPhoto %>
							<img src="$URL" alt="property-image"/>
                        <% end_with %>
                    <% else %>
						<img src="https://placehold.co/1280x400" class="property-image" alt="property-image"/>
                    <% end_if %>
				</div>

				<div class="row grid">
					<div class="col-sm-8 property-info">
						<h1 class="property-title">$Title</h1>
						<p class="property-summary mb-8">$Property.Summary</p>
						<div class="mb-8">
							<h4 class="mb-4">Details Property</h4>
							<div class="row">
								<div class="col-xs-6"><p>Bedrooms</p></div>
								<div class="col-xs-6"><strong>$Property.Bedrooms</strong></div>
								<div class="col-xs-6"><p>Bathrooms</p></div>
								<div class="col-xs-6"><strong>$Property.Bathrooms</strong></div>
								<div class="col-xs-6"><p>LandArea</p></div>
								<div class="col-xs-6"><strong>$Property.LandArea</strong></div>
								<div class="col-xs-6"><p>BuildingArea</p></div>
								<div class="col-xs-6"><strong>$Property.BuildingArea</strong></div>
							</div>
						</div>
						<div class="property-description mb-8">
							<h4 class="mb-4">Facilities</h4>
							<div class="flex gap-2">
                                <% if $Property.Facilities %>
                                    <% loop $Property.Facilities %>
										<div class="badge badge-primary text-sm">$Title</div>
                                    <% end_loop %>
                                <% else %>
									<p>No Facilities</p>
                                <% end_if %>
							</div>
						</div>
						<div class="property-description mb-8">
							<h4 class="mb-4">Description</h4>
                            $Property.Description
						</div>
						<div class="mb-8">
							<h4 class="mb-4">Address</h4>
                            $Property.getAddressCensored
						</div>
					</div>
					<div class="col-sm-4 property-price">
						<div class="card mb-8 float-right flex flex-col items-end max-w-72 shadow-lg bg-primary">
							<div class="font-bold text-lg flex gap-2"><% loop $Property.Types %><p>For $Title</p><% if not $Last %> / <% end_if %><% end_loop %></div>
							<h2>$Property.getFormattedPrice</h2>
							<p class="text-sm">/ Per Night</p>
						</div>
					</div>
					<div class="col-sm-4 property-agent">
						<div class="card mb-8 float-right flex flex-col items-center max-w-72 shadow-lg bg-warning">
							<img class="img-responsive img-circle" width="100" src="$ThemeDir/images/comment-man.jpg">
							<p class="text-lg">$Property.Agent.Title</p>
							<a href="https://wa.me/$Property.Agent.getPhoneWhatsapp" target="_blank" class="text-lg">$Property.Agent.Phone</a>
						</div>
					</div>
                    <%--                                                <div class="position-relative" style="width: 100%; height: 800px">--%>
                    <%--                                                    <div class="sticky w-full">--%>
                    <%--                                                    </div>--%>
                    <%--                                                </div>--%>
				</div>
			</div>
			<!-- closing main content -->

		</div>
	</div>
</div>
<!-- closing content wrapper -->