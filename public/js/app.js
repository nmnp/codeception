//Define an angular module for our app
var app = angular.module('codeceptionDemo', []);

app.controller('tasksController', function ($scope, $http) {
    getTask(); // Load all available tasks
    function getTask() {
        $http.post("/task/getTask").success(function (data) {
            $scope.tasks = data;
        });
    };
    $scope.addTask = function (task) {
        $http.post("/task/addTask?task=" + task).success(function (data) {
            getTask();
            $scope.taskInput = "";
        });
    };
    $scope.deleteTask = function (task) {
        if (confirm("Are you sure to delete this line?")) {
            $http.post("/task/deleteTask?taskID=" + task).success(function (data) {
                getTask();
            });
        }
    };

    $scope.deleteTaskWithoutPopup = function (task) {
            $http.post("/task/deleteTask?taskID=" + task).success(function (data) {
                getTask();
            });
    };

    $scope.toggleStatus = function (item, status, task) {
        if (status == '2') {
            status = '0';
        } else {
            status = '2';
        }
        $http.post("/task/updateTask?taskID=" + item + "&status=" + status).success(function (data) {
            getTask();
        });
    };

});
