<?php

/** Status responses Codes */
define('RESPONSE_CODE_SUCCESS', 200); // OK
define('RESPONSE_BAD_REQUEST', 400); //  Bad Request
define('RESPONSE_UNAUTHORIZED_REQUEST', 401); //  Unauthorized
define('RESPONSE_FORBIDDEN_REQUEST', 403); //    Forbidden
define('RESPONSE_INTERNAL_SERVER_ERROR', 500); //    Internal Server Error
define('RESPONSE_NOT_LOGIN_USER', 1000); //    Internal Server Error

/** uploaded main folder name */
define('UPLOADED_FOLDER_NAME', '/uploaded/');

/** Image File Extension */
define('PNG_EXTENSION', '.png'); //

const ORDER_STATUS_COMPLETED = "COMPLETED";
const ORDER_STATUS_RUNNING = "RUNNING";
const ORDER_STATUS_CANCELED = "CANCELED";
const ORDER_STATUS_INCOMPLETE = "INCOMPLETE";
const ORDER_STATUS_PENDING = "PENDING";

/** SET DEFAULT DELIVERY CHARGE */
const DEFAULT_DELIVERY_CHARGE = 50;
const DEFAULT_EXCEPTED_DATE_DAY = 7;
