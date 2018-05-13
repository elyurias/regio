angular.module("regio")
    .factory('UserData',[
        '$resource', function(r){
            var UrlServ = window.location.href.substring(0,window.location.href.indexOf("#!"));
            var user = r(UrlServ+"/controlador/login/",
                {
                    'get':    {method:'GET', isArray:false},
                    'save':   {method:'POST'},
                    'query':  {method:'GET', isArray:true},
                    'remove': {method:'DELETE'},
                    'delete': {method:'DELETE'} 
                }
            );
            return user;
        }
    ]
).run();//se tiene que correr el factory para tenerlo disponible