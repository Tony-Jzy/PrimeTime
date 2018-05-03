export const BASE = 'https://api.shinji.io/api';

export const LOGIN = '/Account/login.php';
export const FETCH_MEDIA = '/Media/fetch.php';
export const FETCH_BY_LOGIN = '/Media/fetchByLogin.php';



export const ins_client_id = '05fceba239c642a0947a5bb58265e3ea';
export const ins_client_secret ='9635871cf6da445a9480dd2f711b36b9';
export const ins_grant_type = 'authorization_code';
export const ins_redirect_uri = 'https://primetime.shinji.io';
export const ins_response_type= 'code';

export const INS_AUTHORIZATION = 'https://api.instagram.com/oauth/authorize/?client_id=' + ins_client_id +'&redirect_uri='+ ins_redirect_uri + '&response_type='+ ins_response_type;
export const INS_TOKEN_REQUEST = 'https://api.instagram.com/oauth/access_token/';
