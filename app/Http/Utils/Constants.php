<?php

namespace App\Http\Utils;

class Constants {

    // HTTP code status

    static $httpCodeOk = 200;
    static $httpCodeBadRequest = 400;
    static $httpCodeNotAllowed = 401;
    static $httpCodeNotFound = 404;
    static $httpCodeForbiden = 403;

    static $statusSuccess = "success";
    static $statusError = "error";

    static $errorGenericMessage = "Something went wrong!";
    static $errorNotAllowedMessage = "Operation not allowed!";

    // Tasks

    static $errorTaskNotFound = "Task not found!";

    static $messageTaskCreated = "Task created successfully!";
    static $messageTaskUpdated = "Task updated successfully!";
    static $messageTaskDeleted = "Task deleted successfully!";
    static $messageTaskCompleted = "Task completed successfully!";

    // Categories

    static $errorCategoryNotFound = "Category not found!";
    static $messageCategoryCreated = "Category created successfully!";
    static $messageCategoryUpdated = "Category updated successfully!";
    static $messageCategoryDeleted = "Category deleted successfully!";

}
