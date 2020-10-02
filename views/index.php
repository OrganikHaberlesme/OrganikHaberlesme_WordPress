<?php
$users = get_users();
?>
<input type="text" id="mesajkolik_nonce" name="mesajkolik_nonce" value="<?php echo wp_create_nonce("mesajkolik_nonce"); ?>" hidden />
<div class="container-fluid">

  <div class="card" style="max-width: initial;">
    <div class="row text-right d-flex flex-row-reverse">
      <div class="text-right logostyle">
        <a href="https://www.organikhaberlesme.com.tr/" target="_blank" alt="Organik Haberleşme">
          <img height="90" src="<?= plugins_url('includes/img/organik-logo.png', dirname(__FILE__)) ?>"/>
        </a>
      </div>
    </div>

    <div class="card-body">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link<?= $tab=='info' ? ' active' : '' ?>" id="pills-info-tab" data-toggle="pill" href="#pills-info" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='info' ? 'true' : 'false' ?>">Giriş</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $tab=='private' ? ' active' : '' ?>" id="pills-private-tab" data-toggle="pill" href="#pills-private" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='private' ? 'true' : 'false' ?>">Özel SMS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $tab=='bulk' ? ' active' : '' ?>" id="pills-bulk-tab" data-toggle="pill" href="#pills-bulk" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='bulk' ? 'true' : 'false' ?>">Toplu SMS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $tab=='auto' ? ' active' : '' ?>" id="pills-auto-tab" data-toggle="pill" href="#pills-auto-sms" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='auto' ? 'true' : 'false' ?>">Otomatik SMS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $tab=='contact' ? ' active' : '' ?>" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='contact' ? 'true' : 'false' ?>">Rehber Yedekle</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $tab=='settings' ? ' active' : '' ?>" id="pills-settings-tab" data-toggle="pill" href="#pills-settings" role="tab" aria-controls="pills-contact" aria-selected="<?= $tab=='settings' ? 'true' : 'false' ?>">Ayarlar</a>
        </li>
      </ul>
      <hr>
      <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade<?= $tab=='info' ? ' show active' : '' ?>" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
          <div class="row">
            <div class="col-md-12">
              <h4>Organik SMS</h4>
            </div>
          </div>
          <hr />
          <div class="row mb-4">
            <div class="col-sm-6">
              <input class="" id="mesajkolik_status" name="mesajkolik_status" value="1" type="checkbox" <?= ((get_option('mesajkolik_status')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" ">
              <label  class="col-form-label ml-2" style="font-weight:700;">Eklenti Durumu</label>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-sm-6">
              <b>Mevcut SMS Krediniz: </b> <?php print_r($balance); ?>
            </div>
          </div>
          <hr />
          <div class="row" >
            <div class="col-md-12">
              <span class="h6">
                Organik SMS Wordpress eklentisi ile müşterilerinize kolaylıkla erişebilir, tanımladığınız otomatik SMS’ler ile kolayca bilgilendirme mesajları gönderebilirsiniz.
              </span>
              <br /><br />
              <div class=" msgbox">
                <span class="h6">
                  <strong >Not:</strong> Bu eklentiyi kullanabilmek için <a href="https://www.organikhaberlesme.com.tr/">Organik Haberleşme</a> üyeliğine sahip olmalısınız. Bir hesabınız yoksa hemen <a href="https://www.organikhaberlesme.com.tr/" >organikhaberlesme.com.tr</a> üzerinden hızlı üyelik gerçekleştirebilirsiniz!
                </span>
              </div>
              <br />
              <p>
                <span class="h6">
                  Bir hesaba sahipseniz Organik Haberleşme üzerinden hesabınıza giriş yapıp API Kullanıcısı oluşturmalısınız. Bunun için aşağıdaki yönergeleri takip edebilirsiniz:
                </span>
              </p>
              <ul style="list-style-type:disc;" class="ml-5">
                <li>Giriş yaptıktan sonra sol menüden <strong>API</strong> başlığına tıklatın</li>
                <li>Açılan alt başlıklardan <strong>API Kullanıcısı Oluşturma</strong> menüsünü seçin</li>
                <li>Açılan sayfanın sağ tarafında API için bir <strong>Kullanıcı Adı</strong> ve <strong>Şifre</strong> belirleyin ardından kaydedin.</li>
                <li>Organik SMS Wordpress eklentisinde <strong>Ayarlar</strong> menüsüne oluşturduğunuz API kullanıcı bilgilerini girin.</li>
                <li>Giriş başarılı sonucu döndükten sonra <strong>SMS Başlığı</strong>nızı seçmeyi unutmayın.</li>

              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="https://www.organikhaberlesme.com.tr/" class="stretched-link">Organik Haberleşme Teknolojileri</a>
            </div>
          </div>
        </div>

        <div class="tab-pane fade <?= $tab=='private' ? ' show active' : '' ?>" id="pills-private" role="tabpanel" aria-labelledby="pills-private-tab">
          <form class="form_private_sms">
            <input type="text" name="action" value="mesajkolik_privatesms" hidden />
            <div class="form-group row">
              <label for="private-phone" class="col-sm-2 col-form-label">GSM Numarası :</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" name="gsm" placeholder="Mesaj Göndermek İstediğiniz Telefon Numaraları (Virgül ile birden fazla girebilirsiniz.)">
              </div>
            </div>
            <div class="form-group row">
              <label for="private-message" class="col-sm-2 col-form-label">Mesajınız :</label>
              <div class="col-sm-10">
                <textarea class="form-control form-control-sm" rows="3" name="message" placeholder="Göndermek İstediğiniz Mesaj içeriği"></textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Gönder</button>
          </form>
        </div>

        <div class="tab-pane fade <?= $tab=='bulk' ? ' show active' : '' ?>" id="pills-bulk" role="tabpanel" aria-labelledby="pills-bulk-tab">
          <div class="row">
            <form class="w-100" id="form-sms-bulk">
              <div class="col-sm-12">
                <table id="users-bulk-table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th style="width:10px;">
                            <div class="col-sm-2 m-1" >
                              <input id="toggle-select-all-users" type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" " data-size="small">
                            </div>
                          </th>
                          <th>Müşteri Adı</th>
                          <th>E posta</th>
                          <th>Telefon</th>
                          <th>Özel Mesaj</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $key2 = 0;
                      // $x = 1;
                      //
                      // while($x <= 2) {
                      //
                      //  $x++;


                      foreach ($users as $key => $user) {
                        $billing_phone = get_user_meta($user->ID, "billing_phone", true);
                        if (isset($billing_phone) && !empty($billing_phone)) { ?>
                          <tr>
                              <th>
                                <div class="col-sm-2 m-1">
                                  <input name="mesajkol_gsm[]" value="<?= $user->ID ?>" class="user-select-bulk" type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" " data-size="small">
                                </div>
                              </th>
                              <td>
                                <?php if (!empty($user->first_name)) {
                                    echo $user->first_name . " " . $user->last_name;
                                } else {
                                    echo $user->display_name;
                                } ?>
                              </td>
                              <td><?= $user->user_email ?></td>
                              <td><?= $billing_phone ?></td>
                              <td><button type="button" class="btn btn-primary btn-bulk-modal" data-toggle="modal" data-target="#bulkPrivateSmsModal" data-phone="<?= $user->ID ?>"><i class="fa fa-envelope"></i></button></td>
                          </tr>

                      <?php
                        }
                      }
                      // }
                    ?>
                  </tbody>
                </table>
                <div class="row mt-2">
                  <div class="col-sm-12">
                    <button type="button" class="btn btn-primary btn-bulk-modal" data-toggle="modal" data-target="#bulkPrivateSmsModal" data-phone="0" ><i class="fa fa-paper-plane"> Tümüne Gönder</i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="tab-pane fade <?= $tab=='auto' ? ' show active' : '' ?>" id="pills-auto-sms" role="tabpanel" aria-labelledby="pills-auto-tab">
          <form id="form-auto-sms" class="form-horizontal">
            <input type="text" name="action" value="mesajkolik_formautosms" hidden="">
            <input type="hidden" name="mesajkolik_optionstab" value="auto">
          <div class="row mesajkolik_option_row">
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Yeni üye olunca, belirlenen numaralara sms gönderilsin</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="1" name="mesajkolik_auto_1_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_1_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="1" style="display:<?= ((get_option('mesajkolik_auto_1_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text"  style="width: 100%;" id="span-input-1">Telefon</span>
                  </div>
                  <input type="text" name="mesajkolik_auto_1_phones" value="<?= esc_html_e(get_option("mesajkolik_auto_1_phones"),'') ?>" class="form-control" placeholder="Sms gönderilecek numaraları giriniz. Ör: 05555555555,05444444444" aria-label="Telefon" aria-describedby="span-input-1">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-1">Mesaj İçeriği</span>
                  </div>
                  <textarea name="mesajkolik_auto_1_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="[uye_adi] [uye_soyadi] üye oldu!" ><?= esc_html_e(get_option("mesajkolik_auto_1_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Yeni üye olunca, müşteriye sms gönderilsin</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="2" name="mesajkolik_auto_2_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_2_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="2" style="display:<?= ((get_option('mesajkolik_auto_2_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-2">Mesaj İçeriği</span>
                  </div>
                  <textarea  name="mesajkolik_auto_2_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="Üye olduğunuz için teşekkürler!"><?= esc_html_e(get_option("mesajkolik_auto_2_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Yeni sipariş geldiğinde, belirlenen numaralara sms gönderilsin</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="3" name="mesajkolik_auto_3_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_3_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="3" style="display:<?= ((get_option('mesajkolik_auto_3_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="span-input-3">Telefon</span>
                  </div>
                  <input  name="mesajkolik_auto_3_phones" value="<?= esc_html_e(get_option("mesajkolik_auto_3_phones"),'') ?>" type="text" class="form-control" placeholder="Sms gönderilecek numaraları giriniz. Ör: 05555555555,05444444444" aria-label="Telefon" aria-describedby="span-input-3">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-3">Mesaj İçeriği</span>
                  </div>
                  <textarea  name="mesajkolik_auto_3_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="Bir yeni sipariş verildi!"><?= esc_html_e(get_option("mesajkolik_auto_3_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_no]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_durum]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_tutar]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Yeni sipariş verildiğinde, Müşteriye bilgilendirme sms gönderilsin</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="4" name="mesajkolik_auto_4_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_4_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="4" style="display:<?= ((get_option('mesajkolik_auto_4_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-4">Mesaj İçeriği</span>
                  </div>
                  <textarea name="mesajkolik_auto_4_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="Siparişiniz alındı!"><?= esc_html_e(get_option("mesajkolik_auto_4_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_no]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_durum]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_tutar]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Ürünün sipariş durumu değiştiğinde müşteriye sms gönderilsin</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="5" name="mesajkolik_auto_5_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_5_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="5" style="display:<?= ((get_option('mesajkolik_auto_5_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-5">Mesaj İçeriği</span>
                  </div>
                  <textarea name="mesajkolik_auto_5_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="Sayın [uye_adi] [uye_soyadi], [siparis_no] numaralı sipariş durumunuz [siparis_durum] olarak güncellenmiştir."><?= esc_html_e(get_option("mesajkolik_auto_5_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_no]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_durum]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_tutar]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Sipariş iptal edildiğinde belirlediğim numaralı sms ile bilgilendir</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="6" name="mesajkolik_auto_6_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_6_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="6" style="display:<?= ((get_option('mesajkolik_auto_6_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group mb-3">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="span-input-3">Telefon</span>
                  </div>
                  <input name="mesajkolik_auto_6_phones" value="<?= esc_html_e(get_option("mesajkolik_auto_6_phones"),'') ?>" type="text" class="form-control" placeholder="Sms gönderilecek numaraları giriniz. Ör: 05555555555,05444444444" aria-label="Telefon" aria-describedby="span-input-3">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-6">Mesaj İçeriği</span>
                  </div>
                  <textarea name="mesajkolik_auto_6_message" class="form-control" aria-label="Mesaj İçeriği" placeholder="[siparis_no] numaralı sipariş iptal edilmiştir."><?= esc_html_e(get_option("mesajkolik_auto_6_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_telefon]</span>
                  <span class="mesajkolik_label text-monospace">[uye_eposta]</span>
                  <span class="mesajkolik_label text-monospace">[uye_kullaniciadi]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_no]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_durum]</span>
                  <span class="mesajkolik_label text-monospace">[siparis_tutar]</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row mesajkolik_option_row" style="display:none;" >
            <div class="col-sm-2 mesajkolik_title_container">
              <p>Ürün stoğa girdiğinde bekleme listesindekilere sms gönder (Wc Waitlist)</p>
            </div>
            <div class="col-sm-2 mb-1 mesajkolik_switch_container">
              <input class="mesajkolik_check" data-id="7" name="mesajkolik_auto_7_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_auto_7_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" "></div>
            <div class="col-sm-8 mesajkolik_text_container">
              <div class="mesajkolik_option" data-id="7" style="display:<?= ((get_option('mesajkolik_auto_7_toggle')) == 1) ? 'block' : 'none' ?>;">
                <div class="input-group">
                  <div class="input-group-prepend" style="width: 124px;">
                    <span class="input-group-text" style="width: 100%;" id="hidden-textarea-7">Mesaj İçeriği</span>
                  </div>
                  <textarea name="mesajkolik_auto_7_message" class="form-control" aria-label="Mesaj İçeriği"><?= esc_html_e(get_option("mesajkolik_auto_7_message"),'') ?></textarea>
                </div>
                <div class="input-group mesajkolik_parameters">
                  <span class="text-monospace">Parametreler: </span>
                  <span class="mesajkolik_label text-monospace">[uye_adi]</span>
                  <span class="mesajkolik_label text-monospace">[uye_soyadi]</span>
                </div>
              </div>
            </div>
          </div>


          <div class="row mt-3">
            <div class="col-sm-12 text-right">
              <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>
          </div>
        </form>
        </div>


        <div class="tab-pane fade <?= $tab=='contact' ? ' show active' : '' ?>" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="row">
              <div class="col-sm-12">
                <form id="form-group-name">
                  <div class="row mesajkolik_option_row mb-4" style="padding:24px 0px 24px 0px;">
                    <label for="contact-group-name" class="col-sm-3 col-form-label">
                        Kullanıcıları Organik SMS Rehberinize Aktarın
                    </label>
                  <div class="col-md-3">
                    <input type="text" name="action" value="mesajkolik_groupbackup" hidden="">
                    <input type="text" class="form-control-sm w-100" value="<?= esc_html_e(get_option("mesajkolik_lastgroup"),'') ?>" name="mesajkolik_lastgroup" id="contact-group-name" placeholder="Grup Adı">
                  </div>
                </div>

                <div class="row" >
                  <div class="col-sm-3 mb-1">
                    <input class="mesajkolik_check" data-id="8" name="mesajkolik_lastgroup_toggle" value="1" type="checkbox" <?= ((get_option('mesajkolik_lastgroup_toggle')) == 1) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" b data-offstyle="secondary" a data-on=" " data-off=" ">
                  </div>
                  <label for="contact-group-name" class="col-sm-8 col-form-label mb-4">
                      Yeni üye olunca, numarasını Organik Haberleşme rehberine ekle
                  </label>
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Kaydet</button>
                </form>
              </div>
            </div>
          </div>

        <div class="tab-pane fade <?= $tab=='settings' ? ' show active' : '' ?>" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
          <form action="options.php" method="post" id="form-module" class="form-horizontal" name="form-module">
            <?php settings_fields('mesajkolik_options'); ?>
            <?php do_settings_sections('mesajkolik_options'); ?>
            <input type="hidden" name="mesajkolik_optionstab" value="settings">

          <div class="form-group row">
            <label for="username-settings" class="col-sm-2 col-form-label">Kullanıcı Adı: </label>
            <div class="col-sm-6">
              <input type="text" class="form-control form-control-sm w-100" value="<?= esc_html_e(get_option("mesajkolik_user"),'') ?>" name="mesajkolik_user" placeholder="Kullanıcı Adınız">
            </div>
          </div>
          <div class="row">
            <label for="private-phone" class="col-sm-2 col-form-label">Şifre: </label>
            <div class="col-sm-6">
              <input type="password" class="form-control form-control-sm w-100" value="<?= esc_html_e(get_option("mesajkolik_pass"),'') ?>" name="mesajkolik_pass" placeholder="Şifreniz">
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-8">
              <div class="alert alert-<?php echo $check_login ? 'success' : 'danger'; ?>" role="alert">
                <?php echo $check_login ? 'Başarıyla giriş yaptınız!' : 'Api kullanıcı bilgilerinizi kontrol edin.'; ?>
              </div>
            </div>
          </div>
          <div class="row mesajkolik_row">
            <div class="col-md-2 mb-4">
              <button type="submit" class="btn btn-primary btn-sm">Giriş Yap</button>
            </div>
          </div>
          <div class="form-group row mt-4">
            <label for="head-settings" class="col-md-2 col-form-label">SMS Başlığı: </label>
            <div class="col-md-6">
              <select class="form-control w-100" name="mesajkolik_header" style="max-width: none;" <?= !$check_login ? 'disabled' : '' ?>>
                <option disabled selected >Lütfen SMS Başlığı Seçiniz</option>
                <?php foreach ($headers as $key){ ?>
                  <option value="<?= $key->name ?>"<?= get_option("mesajkolik_header") ==$key->name ? ' selected' : '' ?>><?= $key->name ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mesajkolik_row">
            <div class="col-sm-12 mb-4">
              <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
            </div>
          </div>

          <div class="form-group row mt-4">
            <label for="username-settings" class="col-sm-2 col-form-label">Telefon Meta Key: </label>
            <div class="col-sm-6">
              <input type="text" class="form-control form-control-sm w-100" value="<?= esc_html_e(get_option("mesajkolik_phone_column"),'') ?>" name="mesajkolik_phone_column" placeholder="Kişi Numaralarının Alınacağı Stun Adı">

            </div>
          </div>

          <div class="row mt-4">
            <div class="col-sm-2 mb-1 ">
              <input class="mesajkolik_check" data-id="1" name="mesajkolik_option_get_phone" value="1" type="checkbox" <?= (get_option('mesajkolik_option_get_phone') != 0) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" ">
            </div>
            <label for="head-settings" class="col-md-8 col-form-label">Üye kayıt sayfasında telefon numarası alınsın</label>
          </div>

          <div class="row mt-4">
            <div class="col-sm-2 mb-1 ">
              <input class="mesajkolik_check" data-id="1" name="mesajkolik_option_phone_required" value="1" type="checkbox" <?= (get_option('mesajkolik_option_phone_required') != 0) ? 'checked' : 'unchecked' ?> data-toggle="toggle" data-onstyle="success" data-offstyle="secondary" data-on=" " data-off=" ">
            </div>
            <label for="head-settings" class="col-md-8 col-form-label">Üye olurken telefon numarası zorunlu</label>
          </div>

          <div class="row">
            <div class="col-sm-12 mb-2 mt-4">
              <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
            </div>
          </div>

        </form>
        </div>

      </div>

      </div>
</div>
</div>
</div>


<div id="bulk-modal">
  <div class="modal fade" id="bulkPrivateSmsModal" tabindex="-1" role="dialog" aria-labelledby="bulkPrivateSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkPrivateSmsModalLabel">Özel Mesaj Gönder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body ">
          <form class="form_private_sms">
            <input type="text" name="action" value="mesajkolik_bulksms" hidden />
            <div class="form-group">
              <input type="text" class="form-control" name="id" id="recipient-name" hidden>
            </div>
            <div class="form-group mesajkolik_option" id="parent-modal-bulk" data-id="100">
              <label for="message-text" class="col-form-label">Mesajınız:</label>
              <textarea class="form-control" name="message" id="message-text" placeholder="Göndermek İstediğiniz Mesaj içeriği"></textarea>
              <div class="input-group mesajkolik_parameters mb-4">
                <span class="text-monospace">Parametreler: </span>
                <span class="mesajkolik_label_bulk text-monospace">[uye_adi]</span>
                <span class="mesajkolik_label_bulk text-monospace">[uye_soyadi]</span>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
              <button type="submit" class="btn btn-primary btn-sm">Gönder</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<div id="alert-modal-mesajkolik">
  <div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="warning-modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="warning-modalTitle">Organik SMS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <i class="mesajkolik_alert_success fa fa-check"></i>
            <i class="mesajkolik_alert_danger fa fa-times" style="display:none"></i>
          </div>
          <h5 id="alert-modal-desc" class="text-center"></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Tamam</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-responser-parent">
  <div class="modal fade" id="modal-responser" tabindex="-1" role="dialog" aria-labelledby="modalResponserTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <div class="text-center">
          <h5 class="modal-title" id="modalResponserTitle">Organik SMS</h5>
        </div>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <!-- <i class="mesajkolik_alert_response fa fa-clock-o fa-6"></i> -->
          <img height="45" src="<?= plugins_url('includes/img/spinner-2x.gif', dirname(__FILE__)) ?>"/>
          <br /> <br />
          <span>Lütfen Bekleyiniz…</span>
        </div>
        <h5 class="text-center"></h5>
      </div>
    </div>
  </div>
</div>
</div>
<script>
var noncewp = "<?php echo wp_create_nonce("mesajkolik_nonce"); ?>";
</script>
