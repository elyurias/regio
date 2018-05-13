angular.module("regio",[,"ngRoute",'ngResource'])
    .config(
        function($routeProvider){
            $routeProvider.
                when("/",{
                    controller: "MainController",
                    templateUrl:"vista/vistashtml/home.html"
                }).
                when('/login',{
                    controller: "LoginController",
                    templateUrl:"vista/vistashtml/login.html"
                }).
                otherwise({
                    redirect: '/'
                });;
        }
);