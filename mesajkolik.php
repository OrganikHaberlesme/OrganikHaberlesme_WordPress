<?php
/**
* Plugin Name: Mesajkolik
* Plugin URI: https://www.organikhaberlesme.com.tr/
* Description: Organik Haberlesme Toplu SMS Eklentisi
* Version: 1.0
* Author: Organik Haberleşme
* Author URI: https://www.organikhaberlesme.com.tr
**/

// - MESAJKOLIK PHP API CLASS
require_once dirname(__FILE__). '/includes/mesajkolikapi.php';

// - ACTIONS
add_action('admin_menu', 'mesajkolik_menus');
add_action('admin_init', 'mesajkolik_options');
add_action('admin_enqueue_scripts', 'mesajkolik_assets');

add_action('wp_ajax_mesajkolik_privatesms', 'mesajkolik_privatesms');
add_action('wp_ajax_mesajkolik_bulksms', 'mesajkolik_bulksms');
add_action('wp_ajax_mesajkolik_formautosms', 'mesajkolik_formautosms');
add_action('wp_ajax_mesajkolik_groupbackup', 'mesajkolik_groupbackup');
add_action('wp_ajax_mesajkolik_status_change', 'mesajkolik_status_change');

add_action('user_register', 'mesajkolik_trigger_register', 10, 1);
//add_action('woocommerce_payment_complete', 'mesajkolik_trigger_checkout', 10, 1);
add_action('woocommerce_thankyou', 'mesajkolik_trigger_checkout', 10,1);
add_action('register_form', 'mesajkolik_register_phone');
add_filter('registration_errors', 'mesajkolik_register_errors', 10, 3);
add_action('user_register', 'mesajkolik_user_register');
add_action('woocommerce_register_form_start', 'mesajkolik_user_register_woo');
add_action('woocommerce_order_status_changed','mesajkolik_order_stat',10,4);
add_action('woocommerce_order_status_cancelled','mesajkolik_order_stat_canceled');

function mesajkolik_menus(){
  $page_title = 'Organik SMS';
  $menu_title = 'Organik SMS';
  $capability = 'manage_options';
  $menu_slug  = 'mesajkolik';
  $function   = 'mesajkolik_page_info';
  $icon_url   = plugins_url('mesajkolik/includes/img/logo-menu.png');
  $position   = null; //1;
  add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
}

// - PAGE
function mesajkolik_page_info(){
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  $balance = $mesajkolik->getBalance();
  $check_login = $balance!==false;
  $headers = $mesajkolik->getHeaders();
  $tab = empty(get_option("mesajkolik_optionstab")) ? 'info' : get_option("mesajkolik_optionstab");
  if (!$check_login) {
    update_option('mesajkolik_optionstab', 'settings');
    $tab = 'settings';
  }

  require_once ('views/index.php');

  update_option('mesajkolik_optionstab', '');
  update_option('mesajkolik_phone_column', 'billing_phone');

}

function mesajkolik_nonce($vals)
{
  if (!wp_verify_nonce($vals['mesajkolik_nonce'], "mesajkolik_nonce")) {
    echo json_encode(['result' => false, 'message' => "Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin."],JSON_UNESCAPED_UNICODE);
    wp_die();
  }
}

function mesajkolik_status_change() {
  global $wpdb;
  mesajkolik_nonce($_REQUEST);
    if (isset($_POST['mesajkolik_status'])) {
      update_option('mesajkolik_status', sanitize_text_field($_POST['mesajkolik_status']));
      echo json_encode(['result' => true, 'message' => "İşlem başarılı."]);
    }else {
      echo json_encode(['result' => false, 'message' => "İşlem gerçekleştirilemedi."]);
    }
  wp_die();
}

function mesajkolik_assets($hook){
  // - LOAD CSS
  $plugin_url = plugin_dir_url( __FILE__ );
  wp_enqueue_style( 'bootstrapcss',  plugins_url('mesajkolik/includes/css/bootstrap.min.css'));
  wp_enqueue_style( 'mesajkolikcss',  plugins_url('mesajkolik/includes/css/mesajkolik.css'));
  wp_enqueue_style( 'mesajkolikdtcss',  plugins_url('mesajkolik/includes/css/dataTables.bootstrap4.min.css'));
  wp_enqueue_style( 'mesajkolikfontawesome',   plugins_url('mesajkolik/includes/awesome/css/font-awesome.min.css'));


  wp_register_script('bootstrapminjs', plugins_url('bootstrap.min.js', dirname(__FILE__).'/includes/js/1/'));
  wp_enqueue_script('bootstrapminjs');

  wp_register_script('tooglejs', plugins_url('bootstrap-toggle.min.js', dirname(__FILE__).'/includes/js/1/'));
  wp_enqueue_script('tooglejs');

  wp_register_script('datatablesjs', plugins_url('jquery.dataTables.min.js', dirname(__FILE__).'/includes/js/1/'));
  wp_enqueue_script('datatablesjs');

  wp_register_script('datatablebtjs', plugins_url('dataTables.bootstrap4.min.js', dirname(__FILE__).'/includes/js/1/'));
  wp_enqueue_script('datatablebtjs');

  wp_register_script('mesajkolikjs', plugins_url('mesajkolik.js', dirname(__FILE__).'/includes/js/1/'));
  wp_enqueue_script('mesajkolikjs');
}

// - SET KEYS
function mesajkolik_options(){
  register_setting('mesajkolik_status', 'mesajkolik_status');
  register_setting('mesajkolik_options', 'mesajkolik_user');
  register_setting('mesajkolik_options', 'mesajkolik_pass');
  register_setting('mesajkolik_options', 'mesajkolik_header');
  register_setting('mesajkolik_options', 'mesajkolik_balance');
  register_setting('mesajkolik_options', 'mesajkolik_optionstab');
  register_setting('mesajkolik_group', 'mesajkolik_lastgroup');
  register_setting('mesajkolik_group', 'mesajkolik_lastgroup_toggle');


  // Auto-SMS
  register_setting('mesajkolik_autosms', 'mesajkolik_autosmstab');
  //Yeni üye olunca, belirlenen numaralara sms gönderilsin
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_1_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_1_phones');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_1_message');
  //Yeni üye olunca, müşteriye sms gönderilsin
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_2_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_2_message');
  //Yeni sipariş geldiğinde, belirlenen numaralara sms gönderilsin
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_3_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_3_phones');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_3_message');
  //Yeni üye olunca, müşteriye sms gönderilsin
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_4_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_4_message');
  //Ürünün sipariş durumu değiştiğinde müşteriye sms gönderilsin
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_5_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_5_message');
  //Sipariş iptal edildiğinde belirlediğim numaralı sms ile bilgilendir
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_6_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_6_phones');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_6_message');
  //Ürün stoğa girdiğinde bekleme listesindekilere sms gönder (Wc Waitlist)
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_7_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_7_message');
  //Yeni üye olunca, numarasını Organik Haberleşme rehberine ekle
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_8_toggle');
  register_setting('mesajkolik_autosms', 'mesajkolik_auto_8_group');

  // Settings
  register_setting('mesajkolik_options', 'mesajkolik_option_get_phone');
  register_setting('mesajkolik_options', 'mesajkolik_option_phone_required');
  register_setting('mesajkolik_options', 'mesajkolik_phone_column');
}

function mesajkolik_formautosms(){
  global $wpdb;
  mesajkolik_nonce($_REQUEST);
  update_option('mesajkolik_optionstab', sanitize_text_field($_POST['mesajkolik_optionstab']));
  //Yeni üye olunca, belirlenen numaralara sms gönderilsin
  update_option('mesajkolik_auto_1_toggle', sanitize_text_field($_POST['mesajkolik_auto_1_toggle']));
  update_option('mesajkolik_auto_1_phones', sanitize_text_field($_POST['mesajkolik_auto_1_phones']));
  update_option('mesajkolik_auto_1_message', sanitize_text_field($_POST['mesajkolik_auto_1_message']));
  //Yeni üye olunca, müşteriye sms gönderilsin
  update_option('mesajkolik_auto_2_toggle', sanitize_text_field($_POST['mesajkolik_auto_2_toggle']));
  update_option('mesajkolik_auto_2_message', sanitize_text_field($_POST['mesajkolik_auto_2_message']));
  //Yeni sipariş geldiğinde, belirlenen numaralara sms gönderilsin
  update_option('mesajkolik_auto_3_toggle', sanitize_text_field($_POST['mesajkolik_auto_3_toggle']));
  update_option('mesajkolik_auto_3_phones', sanitize_text_field($_POST['mesajkolik_auto_3_phones']));
  update_option('mesajkolik_auto_3_message', sanitize_text_field($_POST['mesajkolik_auto_3_message']));
  //Yeni üye olunca, müşteriye sms gönderilsin
  update_option('mesajkolik_auto_4_toggle', sanitize_text_field($_POST['mesajkolik_auto_4_toggle']));
  update_option('mesajkolik_auto_4_message', sanitize_text_field($_POST['mesajkolik_auto_4_message']));
  //Ürünün sipariş durumu değiştiğinde müşteriye sms gönderilsin
  update_option('mesajkolik_auto_5_toggle', sanitize_text_field($_POST['mesajkolik_auto_5_toggle']));
  update_option('mesajkolik_auto_5_message', sanitize_text_field($_POST['mesajkolik_auto_5_message']));
  //Sipariş iptal edildiğinde belirlediğim numaralı sms ile bilgilendir
  update_option('mesajkolik_auto_6_toggle', sanitize_text_field($_POST['mesajkolik_auto_6_toggle']));
  update_option('mesajkolik_auto_6_phones', sanitize_text_field($_POST['mesajkolik_auto_6_phones']));
  update_option('mesajkolik_auto_6_message', sanitize_text_field($_POST['mesajkolik_auto_6_message']));
  //Ürün stoğa girdiğinde bekleme listesindekilere sms gönder (Wc Waitlist)
  update_option('mesajkolik_auto_7_toggle', sanitize_text_field($_POST['mesajkolik_auto_7_toggle']));
  update_option('mesajkolik_auto_7_message', sanitize_text_field($_POST['mesajkolik_auto_7_message']));
  //Yeni üye olunca, numarasını Organik Haberleşme rehberine ekle
  update_option('mesajkolik_auto_8_toggle', sanitize_text_field($_POST['mesajkolik_auto_8_toggle']));
  update_option('mesajkolik_auto_8_group', sanitize_text_field($_POST['mesajkolik_auto_8_group']));
  // echo true;
  // foreach ($_POST as $param_name => $param_val) {
  //     update_option($param_name, $param_val);
  // }
  echo json_encode(['result' => true, 'message' => 'İşlem Başarılı.']);
  wp_die();
}

function mesajkolik_privatesms(){
  global $wpdb;
  mesajkolik_nonce($_REQUEST);
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  if(isset($_POST['gsm']) && isset($_POST['message'])){
    $send = $mesajkolik->sendsms(str_replace('+', '', sanitize_text_field($_POST['gsm'])), sanitize_text_field($_POST['message']), get_option("mesajkolik_header"));
    echo json_encode($send);
  }
  wp_die();
}

// Toplu sms Sekmesi
function mesajkolik_bulksms(){
  global $wpdb;
  mesajkolik_nonce($_REQUEST);
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  if(!isset($_POST['id']) || !isset($_POST['message'])){
    echo json_encode(['result' => false, 'message' => 'Toplu sms gönderebilmek için numara seçmeli ve bir mesaj içeriği girmelisiniz.']);
  }
  $postId = sanitize_text_field($_POST['id']);
  $user = is_array($postId) ? array_filter($postId) : array_filter(explode(',', $postId));
  $sended = [];
  $sms = [];

  foreach ($user as $key) {
    $billing_phone = get_user_meta($key, "billing_phone", true);
    if(!empty($billing_phone) && !in_array($billing_phone,$sended)){
      $sended[] = $billing_phone;
      $sms[] = [
        'gsm' => str_replace('+', '', $billing_phone),
        'message' => mesajkolik_label_clear(sanitize_text_field($_POST['message']), $key)
      ];
    }
  }
  $send = $mesajkolik->advancedsms($sms, get_option("mesajkolik_header"));
  echo json_encode($send);
  wp_die();
}

function mesajkolik_groupbackup(){
  global $wpdb;
  mesajkolik_nonce($_REQUEST);
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  $postLastGroup = sanitize_text_field($_POST['mesajkolik_lastgroup']);
  $groupname = isset($postLastGroup) ? $postLastGroup : get_option('mesajkolik_lastgroup');
  if(!empty($groupname)){
    if(isset($_POST['mesajkolik_lastgroup'])){
      update_option('mesajkolik_lastgroup', sanitize_text_field($groupname));
      update_option('mesajkolik_lastgroup_toggle', sanitize_text_field($_POST['mesajkolik_lastgroup_toggle']));
    }
    $groupadd = $mesajkolik->groupadd($groupname);
    if($groupadd->result == 0){
      echo isset($_POST['mesajkolik_lastgroup']) ? json_encode(['result' => false, 'message' => 'Grup eklenemedi.']) : '';
      wp_die();
      return false;
    }
    $groupid = ((array)($groupadd->data))[0]->id;

    $users = get_users();
    $persons = [];
     foreach ($users as $key => $user) {
       $billing_phone = get_user_meta($user->ID, "billing_phone", true);
       $personname = "";
       $personsurname="";
       if (!empty($user->first_name) && !empty($user->first_name)) {
           $personname = $user->first_name;
           $personsurname = $user->last_name;
       } else {
           $personname = $user->display_name;
       }
       if (isset($billing_phone) && !empty($billing_phone)) {
         $obj = new stdClass();
         $obj->name = $personname;
         $obj->surname = $personsurname;
         $obj->gsm = str_replace('+','',$billing_phone);
         $obj->group_id = $groupid;
         $persons[] = $obj;
       }
     }
    $add = $mesajkolik->personadd($persons, $groupid);
    echo isset($_POST['mesajkolik_lastgroup']) ? json_encode(['result' => $add->result, 'message' => ($add->result ? count($add->data).' kişi '.htmlentities($_POST['mesajkolik_lastgroup']).' rehberinize eklendi' : 'Kişileri eklerken bir problem oluştu')]) : '';
  }
  if(isset($_POST['mesajkolik_lastgroup'])){
    wp_die();
  }
}

// - FUNCTIONS
function mesajkolik_label_clear($message, $userid, $order_id=0){
  //sipariş durum değişimi
  if ($order_id!==0) {
  $allStat = array(
      "pending" => "Ödeme bekleniyor",
      "processing" => "İşleniyor",
      "on-hold" => "Beklemede",
      "completed" => "Tamamlandı",
      "cancelled" => "İptal Edildi",
      "refunded" => "İade edildi",
      "failed" => "Başarısız",
  );

  $order = wc_get_order($order_id);
  $user_id = $order->get_user_id();
  $orderStatNew = $order->status;
  $orderOrderId = $order_id;
  $billingFirstName = $order->data['billing']['first_name'];
  $billingLastName = $order->data['billing']['last_name'];
  $billingPhone = $order->data['billing']['phone'];
  $billingEmail = $order->data['billing']['email'];
  $billingPrice = $order->data['total'];
  $orderStatus = $allStat[$orderStatNew];

  }

  return str_replace([
    '[uye_adi]',
    '[uye_soyadi]',
    '[uye_telefon]',
    '[uye_eposta]',
    '[uye_kullaniciadi]',
    '[siparis_durum]',
    '[siparis_no]',
    '[siparis_tutar]'
  ], [
    (!empty($order_id) ? ucfirst($billingFirstName) : get_user_meta($userid, "first_name", true)), // uye_adi
    (!empty($order_id) ? ucfirst($billingLastName) : get_user_meta($userid, "last_name", true)), // uye_soyadi
    (!empty($order_id) ? $billingPhone : get_user_meta($userid, "billing_phone", true)), // uye_telefon
    (!empty($order_id) ? $billingEmail : get_user_meta($userid, "billing_email", true)), // uye_email
    (get_user_meta($userid, "nickname", true)), // uye_kullaniciadi
    (!empty($order_id) ? $orderStatus : ''), // siparis_durum
    (!empty($order_id) ? $orderOrderId : ''), //siparis no
    (!empty($order_id) ? $billingPrice : '')
  ], $message);
}
function mesajkolik_status($v = null){
  return get_option("mesajkolik_status") == 1 && ($v === null || get_option($v) == 1);
}

// - TRIGGERS
function mesajkolik_trigger_register($id){
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  $sms = [];
  if(mesajkolik_status("mesajkolik_auto_1_toggle")){
    $message = empty(get_option("mesajkolik_auto_1_message")) ? "[uye_adi] [uye_soyadi] üye oldu!" : get_option("mesajkolik_auto_1_message");
    $sms[] = [
      'gsm' => str_replace('+', '', get_option("mesajkolik_auto_1_phones")),
      'message' => mesajkolik_label_clear($message, $id)
    ];
  }
  if(mesajkolik_status("mesajkolik_auto_2_toggle")){
    $message = empty(get_option("mesajkolik_auto_2_message")) ? "Üye olduğunuz için teşekkürler!" : get_option("mesajkolik_auto_2_message");
    $sms[] = [
      'gsm' => str_replace('+', '', (empty(get_user_meta($id, "billing_phone", true)) ? sanitize_text_field($_POST['billing_phone']) : get_user_meta($id, "billing_phone", true))),
      'message' => mesajkolik_label_clear($message, $id)
    ];
  }
  $send = count($sms)>0 ? $mesajkolik->advancedsms($sms, get_option("mesajkolik_header"), 0) : false;
}
function mesajkolik_trigger_checkout($order_id){
  $order = wc_get_order($order_id);
  $user_id = $order->get_user_id();
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));
  $sms = [];
  if(mesajkolik_status('mesajkolik_auto_3_toggle')){
    $message = empty(get_option("mesajkolik_auto_3_message")) ? "Bir yeni sipariş verildi!" : get_option("mesajkolik_auto_3_message");
    $sms[] = [
      'gsm' => str_replace('+', '', get_option("mesajkolik_auto_3_phones")),
      'message' => mesajkolik_label_clear($message, $user_id)
    ];
  }
  if(mesajkolik_status('mesajkolik_auto_4_toggle')){
    $message = empty(get_option("mesajkolik_auto_4_message")) ? "Siparişiniz alındı!" : get_option("mesajkolik_auto_4_message");
    $sms[] = [
      'gsm' => str_replace('+', '', (empty(get_user_meta($user_id, "billing_phone", true)) ? sanitize_text_field($_POST['billing_phone']) : get_user_meta($user_id, "billing_phone", true))),
      'message' => mesajkolik_label_clear($message, $user_id)
    ];
  }
  $send = count($sms)>0 ? $mesajkolik->advancedsms($sms, get_option("mesajkolik_header"), 0) : false;
}

// ORDER STATUS
function mesajkolik_order_stat($order_id, $order_stat_old, $order_stat_new, $instance){

  $order = wc_get_order($order_id);
  $user_id = $order->get_user_id();
  $billingPhone = $order->data['billing']['phone'];
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));

  if(mesajkolik_status("mesajkolik_auto_5_toggle")){
    $message = empty(get_option("mesajkolik_auto_5_message")) ? "Sayın [uye_adi] [uye_soyadi], [siparis_no] numaralı sipariş durumunuz [siparis_durum] olarak güncellenmiştir." : get_option("mesajkolik_auto_5_message");
    $send = $mesajkolik->sendsms(str_replace('+', '', $billingPhone), mesajkolik_label_clear($message, $id, $order_id), get_option("mesajkolik_header"));
  }


}

function mesajkolik_order_stat_canceled($order_id){
  $order = wc_get_order($order_id);
  $user_id = $order->get_user_id();
  $billingPhone = $order->data['billing']['phone'];//sipariş verenin numarası
  $mesajkolik = new MesajkolikApi(get_option("mesajkolik_user"), get_option("mesajkolik_pass"));

  if(mesajkolik_status("mesajkolik_auto_6_toggle")){
    $message = empty(get_option("mesajkolik_auto_6_message")) ? "[siparis_no] numaralı sipariş iptal edilmiştir." : get_option("mesajkolik_auto_6_message");
    $send = $mesajkolik->sendsms(str_replace('+', '', get_option("mesajkolik_auto_6_phones")), mesajkolik_label_clear($message, $id, $order_id), get_option("mesajkolik_header"));
  }
}

// - REGISTER ELEMENTS
function mesajkolik_register_phone(){
  if(!mesajkolik_status('mesajkolik_option_get_phone')){ return false; }
  $billing_phone = (!empty( $_POST['billing_phone'])) ? sanitize_text_field( $_POST['billing_phone']) : '';
  ?>
  <p>
    <label for="billing_phone"><?php _e('Cep Telefonu', 'mesajkolik') ?><br />
      <input type="text" name="billing_phone" id="billing_phone" class="input" value="<?php echo esc_attr($billing_phone); ?>" size="25" <?php if(get_option('mesajkolik_option_phone_required')=='1'){ ?> required<?php } ?>/>
    </label>
  </p>
  <?php

}

function mesajkolik_register_errors($errors, $sanitized_user_login, $user_email){
  if(!mesajkolik_status('mesajkolik_option_get_phone')){ return $errors; }
  if((!is_numeric($_POST['billing_phone']) && !empty($_POST['billing_phone'])) || (empty($_POST['billing_phone']) && get_option('mesajkolik_option_phone_required')=='1')){
    $errors->add('billing_phone_error', sprintf('<strong>%s</strong>: %s',__('Hata', 'mesajkolik'),__('Lütfen geçerli bir telefon numarası giriniz.', 'mesajkolik')));
  }
  return $errors;
}

function mesajkolik_user_register($user_id){
  if(!mesajkolik_status('mesajkolik_option_get_phone')){ return false; }
  if(is_numeric($_POST['billing_phone']) && !empty($_POST['billing_phone'])){
    update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    if (mesajkolik_status('mesajkolik_lastgroup_toggle')) {
      mesajkolik_groupbackup();
    }
  }
}

function mesajkolik_user_register_woo(){
  if(!mesajkolik_status('mesajkolik_option_get_phone')){ return false; }  ?>
  <p class="form-row form-row-wide">
    <label for="billing_phone"><?php _e('Cep Telefonu', 'mesajkolik'); if(get_option('mesajkolik_option_phone_required')=='1'){ ?> <span class="required">*</span><?php } ?></label>
    <input type="text" class="input-text" name="billing_phone" id="billing_phone" value="<?php esc_attr_e($_POST['billing_phone']); ?>" <?php if(get_option('mesajkolik_option_phone_required')=='1'){ ?> required<?php } ?>/>
  </p>
  <div class="clear"></div>
  <?php
 }
