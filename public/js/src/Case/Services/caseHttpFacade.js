(function(angular, $) {
    var caseModule = angular.module('case');
    caseModule.factory(
        'caseHttpFacade',
        [
            '$http',
            '$q',
            function($http, $q) {
                var _processSuccessResponse = function(response) {
                    if(response.status === 200 && typeof response.data === 'object' && response.data.status === 'success') {
                        return response.data.data;
                    }
                    if(response.data.status === 'fail') {
                        return $q.reject(response.data.data);
                    }
                };

                var _processErrorResponse = function(response) {
                    return $q.reject(response.data.data)
                }

                //todo: while retrieving slides id should be retrieved
                var _getCases = function(categoryId) {
                    categoryId = parseInt(categoryId, 10);
                    return $http.get('/api/cases/category/' + categoryId, {cache: true})
                        .then(_processSuccessResponse, _processErrorResponse);
                };

                //todo: while retrieving slides id should be retrieved
                var _getCase = function(caseId) {
                    caseId = parseInt(caseId, 10);
                    return $http.get('/api/cases/' + caseId)
                        .then(_processSuccessResponse, _processErrorResponse);
                };

                var _save = function(virtualCase) {
                    var data = {
                        'clinical_data': virtualCase.clinicalData,
                        'virtual_slide_provider_id': virtualCase.virtualSlideProviderId,
                        'category_id': virtualCase.categoryId,
                        'url': [],
                        'stain': []
                    };

                    angular.forEach(virtualCase.slides, function(slide) {
                        data.url.push(slide.url);
                        data.stain.push(slide.stain);
                    });

                    if(virtualCase.id === undefined) {
                        return _saveCase(data);
                    }

                    data.slide_id = [];
                    angular.forEach(virtualCase.slides, function(slide) {
                        data.slide_id.push(slide.id);
                    });

                    return _updateCase(virtualCase.id, data);
                };

                var _saveCase = function(data) {
                    var postData = $.param(data);

                    return $http({
                        method: 'POST',
                        url: '/api/cases',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: postData
                    }).then(_processSuccessResponse, _processErrorResponse);
                };

                // todo: While updating slides id should also be passed
                var _updateCase = function(id, data) {
                    var postData = $.param(data);
                    var id = parseInt(id, 10);

                    return $http({
                        method: 'PUT',
                        url: '/api/cases/' + id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: postData
                    }).then(_processSuccessResponse, _processErrorResponse);
                };

                var _delete = function(id) {
                    return $http.delete('/api/cases/' + id)
                        .then(_processSuccessResponse, _processErrorResponse);
                }

                return {
                    getCases: _getCases,
                    getCase: _getCase,
                    save: _save,
                    delete: _delete
                };
            }
        ]
    );
}(angular, window.jQuery));