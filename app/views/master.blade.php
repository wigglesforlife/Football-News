<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Football News</title>
  <base href="<?=URL::to('public/')?>"></base>
  
  <link rel="stylesheet" href="assets/css/foundation.css">
  <link rel="stylesheet" type="text/css" href="assets/css/core.css">
  

  <script src="assets/js/vendor/custom.modernizr.js"></script>

</head>
<body ng-app="footballNews">

	<?=$body?>	

  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'assets/js/vendor/zepto' : 'assets/js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script src="assets/js/foundation.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
  <script src="assets/js/fn_controller.js"></script>

  
  <script>
    $(document).foundation();
  </script>
</body>
</html>