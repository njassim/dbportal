<!doctype html>
<html lang="en" ng-app id="ng-app">
<head>
<title>Page Title</title>
<script src="js/angular.js"></script>
<script>
function PostsCtrlAjax($scope, $http)
{
$http({method: 'POST', url: 'js/posts.json'}).success(function(data)
{
$scope.posts = data; // response data 
});
}
</script>
</head>
<body>
<div id="ng-app" ng-app ng-controller="PostsCtrlAjax">
 
<div ng-repeat="post in posts" >
<h2>
<a href='{{post.url}}'>{{post.title}}</a>
</h2>
<div class='time'>{{post.time}} - {{post.author}} </div>
<p>{{post.description}}</p>
<img ng-src="{{post.banner}}" />
</div>
   
</div>
</body>
</html>