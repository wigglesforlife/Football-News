// Generated by CoffeeScript 1.6.3
(function() {
  var ROOT_URL, footballNews;

  ROOT_URL = 'fn/public/';

  footballNews = angular.module('footballNews', []);

  footballNews.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%=');
    return $interpolateProvider.endSymbol('%>');
  });

  footballNews.controller('StoriesController', function($scope, $timeout, $http) {
    $scope.offset = 0;
    $scope.stories = [];
    $scope.getStories = function() {
      $http.get('stories/' + $scope.offset).success($scope.storiesSuccessCB);
    };
    $scope.storiesSuccessCB = function(data) {
      $scope.stories = $scope.stories.concat(data);
      $scope.offset += 20;
    };
    return $scope.getStories();
  });

}).call(this);
