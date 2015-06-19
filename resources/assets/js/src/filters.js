(function(angular){
    angular.module('app')
        .filter('exceptWithId', function() {
            return function(input, id) {
                var output = [];
                id = parseInt(id, 10);
                angular.forEach(input, function(item) {
                    if(id != item.id) {
                        output.push(item);
                    }
                });
                return output;
            }
        });
}(angular));