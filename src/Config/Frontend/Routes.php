<?php

/**
 *DEFAULT ERROR Routes
 */
$routes[$controller['main'].'/'.$method['forbidden-access']] = 'Main/error403';
$routes[$controller['main'].'/'.$method['page-not-found']] = 'Main/error404';


/**
 *Main Routes
 */
$routes[$controller['main']] = 'Main/index';
$routes[$controller['main'].'/'.$method['dashboard']] = 'Main/dashboard';
$routes[$controller['main'].'/'.$method['set-idiom']] = 'Main/setIdiom';


/**
 * Address Routes
 */
$routes[$controller['address']] = 'Address/index';
$routes[$controller['address'].'/'.$method['show'].'/(:param)/(:param)'] = 'Address/show/(:param)/(:param)';


/**
 * Account Routes
 */
$routes[$controller['Account']] = 'Account/index';
$routes[$controller['Account'].'/'.$method['edit-multi']] = 'Account/editMulti';
$routes[$controller['Account'].'/'.$method['edit']] = 'Account/edit';
$routes[$controller['Account'].'/'.$method['create']] = 'Account/show';
$routes[$controller['Account'].'/'.$method['search']] = 'Account/search';
$routes[$controller['Account'].'/'.$method['show-result-by'].'/(:param)'] = 'Account/showResultBy/(:param)';
$routes[$controller['Account'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'Account/showResultBy/(:param)/(:param)';
$routes[$controller['Account'].'/'.$method['show'].'/(:param)'] = 'Account/show/(:param)';
$routes[$controller['Account'].'/'.$method['show'].'/(:param)/(:param)'] = 'Account/show/(:param)/(:param)';


/**
 * AccountTypes Routes
 */
$routes[$controller['AccountType']] = 'AccountType/index';
$routes[$controller['AccountType'].'/'.$method['edit-multi']] = 'AccountType/editMulti';
$routes[$controller['AccountType'].'/'.$method['edit']] = 'AccountType/edit';
$routes[$controller['AccountType'].'/'.$method['create']] = 'AccountType/show';
$routes[$controller['AccountType'].'/'.$method['search']] = 'AccountType/search';
$routes[$controller['AccountType'].'/'.$method['show-result-by'].'/(:param)'] = 'AccountType/showResultBy/(:param)';
$routes[$controller['AccountType'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'AccountType/showResultBy/(:param)/(:param)';
$routes[$controller['AccountType'].'/'.$method['show'].'/(:param)'] = 'AccountType/show/(:param)';
$routes[$controller['AccountType'].'/'.$method['show'].'/(:param)/(:param)'] = 'AccountType/show/(:param)/(:param)';


/**
 * Company Routes
 */
$routes[$controller['Company']] = 'Company/index';
$routes[$controller['Company'].'/'.$method['edit-multi']] = 'Company/editMulti';
$routes[$controller['Company'].'/'.$method['edit']] = 'Company/edit';
$routes[$controller['Company'].'/'.$method['new']] = 'Company/show';
$routes[$controller['Company'].'/'.$method['search']] = 'Company/search';
$routes[$controller['Company'].'/'.$method['show-result-by'].'/(:param)'] = 'Company/showResultBy/(:param)';
$routes[$controller['Company'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'Company/showResultBy/(:param)/(:param)';
$routes[$controller['Company'].'/'.$method['show'].'/(:param)'] = 'Company/show/(:param)';
$routes[$controller['Company'].'/'.$method['show'].'/(:param)/(:param)'] = 'Company/show/(:param)/(:param)';


/**
 * CompanyTypes Routes
 */
$routes[$controller['CompanyType']] = 'CompanyType/index';
$routes[$controller['CompanyType'].'/'.$method['edit-multi']] = 'CompanyType/editMulti';
$routes[$controller['CompanyType'].'/'.$method['edit']] = 'CompanyType/edit';
$routes[$controller['CompanyType'].'/'.$method['new']] = 'CompanyType/show';
$routes[$controller['CompanyType'].'/'.$method['search']] = 'CompanyType/search';
$routes[$controller['CompanyType'].'/'.$method['show-result-by'].'/(:param)'] = 'CompanyType/showResultBy/(:param)';
$routes[$controller['CompanyType'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'CompanyType/showResultBy/(:param)/(:param)';
$routes[$controller['CompanyType'].'/'.$method['show'].'/(:param)'] = 'CompanyType/show/(:param)';
$routes[$controller['CompanyType'].'/'.$method['show'].'/(:param)/(:param)'] = 'CompanyType/show/(:param)/(:param)';

/**
 * PriceTable Routes
 */
$routes[$controller['PriceTable']] = 'PriceTable/index';
$routes[$controller['PriceTable'].'/'.$method['edit-multi']] = 'PriceTable/editMulti';
$routes[$controller['PriceTable'].'/'.$method['edit']] = 'PriceTable/edit';
$routes[$controller['PriceTable'].'/'.$method['create']] = 'PriceTable/show';
$routes[$controller['PriceTable'].'/'.$method['search']] = 'PriceTable/search';
$routes[$controller['PriceTable'].'/'.$method['show-result-by'].'/(:param)'] = 'PriceTable/showResultBy/(:param)';
$routes[$controller['PriceTable'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'PriceTable/showResultBy/(:param)/(:param)';
$routes[$controller['PriceTable'].'/'.$method['show'].'/(:param)'] = 'PriceTable/show/(:param)';
$routes[$controller['PriceTable'].'/'.$method['show'].'/(:param)/(:param)'] = 'PriceTable/show/(:param)/(:param)';


/**
 * User Routes
 */
$routes[$controller['User']] = 'User/index';
$routes[$controller['User'].'/'.$method['do-login']] = 'User/doLogin';
$routes[$controller['User'].'/'.$method['do-logout']] = 'User/doLogout';
$routes[$controller['User'].'/'.$method['edit-multi']] = 'User/editMulti';
$routes[$controller['User'].'/'.$method['edit']] = 'User/edit';
$routes[$controller['User'].'/'.$method['create']] = 'User/show';
$routes[$controller['User'].'/'.$method['search']] = 'User/search';
$routes[$controller['User'].'/'.$method['show-result-by'].'/(:param)'] = 'User/showResultBy/(:param)';
$routes[$controller['User'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'User/showResultBy/(:param)/(:param)';
$routes[$controller['User'].'/'.$method['show'].'/(:param)'] = 'User/show/(:param)';
$routes[$controller['User'].'/'.$method['show'].'/(:param)/(:param)'] = 'User/show/(:param)/(:param)';

/**
 * UserGroup Routes
 */
$routes[$controller['UserGroup']] = 'UserGroup/index';
$routes[$controller['UserGroup'].'/'.$method['edit-multi']] = 'UserGroup/editMulti';
$routes[$controller['UserGroup'].'/'.$method['edit']] = 'UserGroup/edit';
$routes[$controller['UserGroup'].'/'.$method['create']] = 'UserGroup/show';
$routes[$controller['UserGroup'].'/'.$method['search']] = 'UserGroup/search';
$routes[$controller['UserGroup'].'/'.$method['show-result-by'].'/(:param)'] = 'UserGroup/showResultBy/(:param)';
$routes[$controller['UserGroup'].'/'.$method['show-result-by'].'/(:param)/(:param)'] = 'UserGroup/showResultBy/(:param)/(:param)';
$routes[$controller['UserGroup'].'/'.$method['show'].'/(:param)'] = 'UserGroup/show/(:param)';
$routes[$controller['UserGroup'].'/'.$method['show'].'/(:param)/(:param)'] = 'UserGroup/show/(:param)/(:param)';
