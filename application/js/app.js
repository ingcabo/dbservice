var app = angular.module('App',[]);
    app.controller("FirstController",function($scope,$http){
			$scope.posts = [];
			$scope.newStudent = {};
							
			$scope.Filtrado = function(){
			//alert($scope.idtext2);	
			$scope.student_get();
			};
			$scope.student_get = function(){
			
		
		    $scope.url = "http://127.0.0.1/apiRestCodeigniter/index.php/Myrest/student/";
			$http.get($scope.url+$scope.idtext2)
				.success(function(data){
				console.log(data);
				$scope.posts = data;
				
				
				})
				.error(function(data){
				alert('ss');
				console.log(data);
				$scope.posts = data;
				});
			};
    			
				
			$scope.AddPost = function(){
			
			$scope.paramt = {
			'email_addres' : $scope.newStudent.email_addres,
			'password':      $scope.newStudent.password,
			'first_name' :   $scope.newStudent.first_name,
			'last_name' : 	 $scope.newStudent.last_name,
			'phone_number' : $scope.newStudent.phone_number,
			'ip_address' :   $scope.newStudent.ip_address
			};
			
			//console.log($scope.paramt.email_addres + $scope.paramt.password);
			$scope.id= 8;
			$scope.url = "http://127.0.0.1/apiRestCodeigniter/index.php/Myrest/student/";
			$http.post($scope.url+$scope.id,$scope.paramt)
			.success(function(data,status,headers,config){
			
			
			$scope.AddPost ={};
			$scope.newStudent={};
			})
			.error(function(error,status,headers,config){
			
			console.log(error);
			});
			
			
			} 
		
		
});

