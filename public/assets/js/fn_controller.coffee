ROOT_URL = 'fn/public/'

footballNews = angular.module('footballNews', [])

footballNews.config(($interpolateProvider) ->
	$interpolateProvider.startSymbol '<%='
	$interpolateProvider.endSymbol '%>'
)	

footballNews.controller('StoriesController', ($scope, $timeout, $http) ->
	$scope.offset = 0
	$scope.stories = []

	# Requests new stories.
	$scope.getStories = ->
		$http.get('stories/'+$scope.offset).success($scope.storiesSuccessCB)
		return

	# Callback on successfull stories request.
	$scope.storiesSuccessCB = (data) ->
		$scope.stories = $scope.stories.concat(data)
		$scope.offset +=20
		return

	$scope.getStories()	
)