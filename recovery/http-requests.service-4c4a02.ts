import {
  Injectable
} from '@angular/core';
import {
  Http,
  Headers,
  RequestOptions,
  Response
} from '@angular/http';
import {
  HttpClient,
  HttpParams,
  HttpHeaders
} from '@angular/common/http';



@Injectable()
export class HttpRequestsService {

  createAuthorizationHeader() {
    let headers = new HttpHeaders();
    // headers=headers.append('Content-Type' , 'application/x-www-form-urlencoded; charset=UTF-8')
    headers = headers.set('Content-Type', 'application/json; charset=utf-8');
    headers = headers.append('Api-Key', localStorage.getItem('api_key'));
    return headers;
  }
<<<<<<< HEAD
    createAuthorizationUploadHeader() {
        let headers = new HttpHeaders();
        headers=headers.append("Api-Key", localStorage.getItem('api_key'));
        return headers;
    }
  sereverUrl:any='http://192.168.0.118/';

  Routing(param){

    var url="http://192.168.0.118:3000/json"
    var urlBack="http://192.168.0.118/api/v1"

    var obj={
      login:url+'/login',
      register:urlBack+'/register',
      get_all_countries:urlBack+'/get_all_countries',
      logout:urlBack+'/logout',
      ligin_success:urlBack+'/login_success',

      get_user:urlBack+'/get_user',

      get_girls_home_page:urlBack+'/get_girls_home_page',
      get_general_info:urlBack+'/general_edit_account_info',
      get_general_info_search:url+'/general_edit_account_info',
      get_regions:urlBack+'/get_regions',
      get_cities:urlBack+'/get_cities',
      get_account_info:urlBack+'/get_account_info',
      save_account_info:urlBack+'/save_account_info',
      get_online_ledies_chat:urlBack+'/get_online_ledies_chat',
      get_contact_list:urlBack+"/get_contact_list",
      get_contact_list_search:url+"/get_contact_list",
      get_chat_messages:urlBack+"/get_chat_messages",
      get_chat_id:urlBack+"/get_chat_id",
      get_my_profile:urlBack+"/get_my_profile",
      get_my_profile_test:url+"/get_my_profile",
      get_payment:url+"/get_payment",
        get_upload_image:urlBack+"/get_upload_image",
        delete_image:urlBack+"/delete_image",
        upload_image:urlBack+"/upload_image",
        upload_avatar:urlBack+"/upload_avatar",
        remove_avatar:urlBack+"/delete_avatar",
        save_password:urlBack+"/save_password",

        //get_faworite_girls:url+"/get_faworite_girls",
        get_inbox_letters:urlBack+"/get_conversations",
        get_all_letters:urlBack+"/get_all_letters",
        read_letter:urlBack+"/read_letter",
        get_girl_info_letter:urlBack+"/get_girl_info_letter",
        upload_image_letter:urlBack+"/upload_image_letter",
        delete_image_letter:url+"/delete_image",
        send_letter:urlBack+"/send_letter",
        delete_chanel_letter:urlBack+"/delete_letters_chanel",
        delete_letter:urlBack+"/delete_letter",

      get_profile:urlBack+"/get_girl_profile",



        get_faworite_girls:urlBack+"/get_faworite_girls",
        add_to_favorite:urlBack+"/add_to_favorite",
        remove_from_favorite:urlBack+"/remove_from_favorite"


    }
=======
  createAuthorizationUploadHeader() {
    let headers = new HttpHeaders();
    headers = headers.append('Api-Key', localStorage.getItem('api_key'));
    return headers;
  }
  // tslint:disable-next-line:member-ordering
  sereverUrl: any = 'http://192.168.0.120/';

  Routing(param) {

    const url = 'http://localhost:3003/json';
    const urlBack = 'http://192.168.0.120/api/v1';

    const obj = {
      login: url + '/login',
      register: urlBack + '/register',
      get_all_countries: urlBack + '/get_all_countries',
      logout: urlBack + '/logout',
      ligin_success: urlBack + '/login_success',

      get_user: urlBack + '/get_user',

      get_girls_home_page: urlBack + '/get_girls_home_page',
      get_general_info: urlBack + '/general_edit_account_info',
      get_general_info_search: url + '/general_edit_account_info',
      get_regions: urlBack + '/get_regions',
      get_cities: urlBack + '/get_cities',
      get_account_info: urlBack + '/get_account_info',
      save_account_info: urlBack + '/save_account_info',
      get_online_ledies_chat: urlBack + '/get_online_ledies_chat',
      get_contact_list: urlBack + '/get_contact_list',
      get_contact_list_search: url + '/get_contact_list',
      get_chat_messages: urlBack + '/get_chat_messages',
      get_chat_id: urlBack + '/get_chat_id',
      get_my_profile: urlBack + '/get_my_profile',
      get_my_profile_test: url + '/get_my_profile',
      get_payment: url + '/get_payment',
      get_upload_image: urlBack + '/get_upload_image',
      delete_image: urlBack + '/delete_image',
      upload_image: urlBack + '/upload_image',
      upload_avatar: urlBack + '/upload_avatar',
      remove_avatar: urlBack + '/delete_avatar',
      save_password: urlBack + '/save_password',
      search_models: urlBack + '/search_models',
      recommended_models: urlBack + '/recommended_models',
      open_chat: urlBack + '/open_chat',
      close_chat: urlBack + '/close_chat',
      is_favorite: urlBack + '/is_favorite',
      get_gifts: urlBack + '/get_gifts',
      refill_balance: urlBack + '/refill_balance',
      add_gift: urlBack + '/add_gift',

      // get_faworite_girls:url+'/get_faworite_girls',
      get_inbox_letters: urlBack + '/get_conversations',
      get_all_letters: urlBack + '/get_all_letters',
      read_letter: urlBack + '/read_letter',
      get_girl_info_letter: urlBack + '/get_girl_info_letter',
      upload_image_letter: urlBack + '/upload_image_letter',
      delete_image_letter: url + '/delete_image',
      send_letter: urlBack + '/send_letter',
      delete_chanel_letter: urlBack + '/delete_letters_chanel',
      delete_letter: urlBack + '/delete_letter',

      get_profile: urlBack + '/get_girl_profile',



      get_faworite_girls: urlBack + '/get_faworite_girls',
      add_to_favorite: urlBack + '/add_to_favorite',
      remove_from_favorite: urlBack + '/remove_from_favorite'


    };
>>>>>>> fedoryshyn-o
    return obj[param];
  }

  constructor() {}

}
