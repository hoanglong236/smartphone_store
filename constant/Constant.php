<?php
define("BASE_ADMIN_URL", "admin");
define("BASE_ADMIN_ROUTE_NAME", "admin");

// Admin: auth pages
define("ADMIN_LOGIN_URL", BASE_ADMIN_URL . "/login");
define("ADMIN_LOGIN_ROUTE", BASE_ADMIN_ROUTE_NAME . ".login");
define("ADMIN_LOGIN_AUTH_URL", BASE_ADMIN_URL . "/login-auth");
define("ADMIN_LOGIN_AUTH_ROUTE", BASE_ADMIN_ROUTE_NAME . ".login-auth");
define("ADMIN_REGISTER_URL", BASE_ADMIN_URL . "/register");
define("ADMIN_REGISTER_ROUTE", BASE_ADMIN_ROUTE_NAME . ".register");
define("ADMIN_REGISTER_AUTH_URL", BASE_ADMIN_URL . "/register-auth");
define("ADMIN_REGISTER_AUTH_ROUTE", BASE_ADMIN_ROUTE_NAME . ".register-auth");

// Admin: business pages
define("MANAGE_BRAND_URL", BASE_ADMIN_URL . "/brand");
define("MANAGE_CATEGORY_URL", BASE_ADMIN_URL . "/category");

// define($BASE_USER_URL, "user");




define("DTO_PATH", "../app/Dto");
