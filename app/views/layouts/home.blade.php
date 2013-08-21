<div class="container" ng-controller="StoriesController">
	<div class="row">
		<div class="large-12 columns">
			<h2>Welcome to Football News</h2>
			<p>Read all the headlines!</p>
			<hr />
		</div>
	</div>
	<div class="row story" ng-repeat="story in stories">
		<div class="large-4 small-12 columns">
			<%=story.team%>
		</div>
		<div class="large-4 small-12 columns">
			<%=story.story%>
		</div>
		<div class="large-4 small-12 columns">
			<a href="<%=story.source%>">View Story</a>
		</div>
	</div>
	<div class="row more-stories">
		<button class="more-stories-button" ng-click="getStories()">
			Load More Stories
		</button>
	</div>
</div>