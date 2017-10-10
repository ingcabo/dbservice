
<html ng-app="App">
<head>
<title>Codeigniter with Angular.js</title>

<meta charset="utf-8" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/app.js"></script>


</head>
<body ng-controller="FirstController">
<div>

<h1>Code igniter + angular.js</h1>


email_addres    <input type="text" ng-model="newStudent.email_addres" ><br>
password        <input type="password" ng-model="newStudent.password" ><br>
first_name      <input type="text" ng-model="newStudent.first_name" ><br>
last_name       <input type="text" ng-model="newStudent.last_name" ><br>
phone_number    <input type="text" ng-model="newStudent.phone_number" ><br>
ip_address      <input type="text" ng-model="newStudent.ip_address" ><br>

<br><br>

<button ng-click="AddPost()"> boton registro </button>




<br>
<br>
<br>
<input type="text" ng-model="idtext2" >
<button ng-click="Filtrado()">boton </button>

<ul>

<li ng-repeat = "post in posts.message">
<strong>id estudiante:  </strong>{{post.student_id}} - <strong>nombre estudiante:  </strong>{{post.first_name}}  - <strong>Email estudiante:  </strong>{{post.email_addres}} 
{{post.error}}

</li>
</ul>




<br>






</div><!-- .container -->

</body>
</html>