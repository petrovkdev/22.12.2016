<?

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.smsgate.smsgate_message"));

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;
    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);
    header('Location: ?path=modules&install=check');
    return $action;
}

// ��������� ������� ��������
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������";
    $PHPShopGUI->size="800,600";

    $PHPShopGUI->includeJava.='
    <style>
      .smsgate .btn {
        margin: 3px;
        color: #fff;
      }
      
      .smsgate textarea {
        margin-top: 10px;
      }
      
    </style>
    <script type="text/javascript">

        $.fn.extend({
            insertAtCaret: function(myValue){
                return this.each(function(i) {
                    if (document.selection) {
                        // ��� ��������� ���� Internet Explorer
                        this.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    }
                    else if (this.selectionStart || this.selectionStart == "0") {
                        // ��� ��������� ���� Firefox � ������ Webkit-��
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }
                })
            }
        });
        
        
        function ShablonAdd(area,snippet){
          $("#"+area).insertAtCaret(snippet);
        }    

    </script>';

    // �������
    $data = $PHPShopOrm->select();
    extract($data);


    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'SMS ������'","���������",
        $PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    // ���������� �������� 1
    $Tab1 =$PHPShopGUI->setText("������ API (�� ��������� phpshop4.incore1.ru): ")
        .$PHPShopGUI->setInput('text','domen_api_new',$domen_api,false,'97%','');

    $Tab1.=$PHPShopGUI->setText("����� API:")
        .$PHPShopGUI->setInput('text','login_api_new',$login_api,false,'97%','');

    $Tab1.=$PHPShopGUI->setText("������ API:")
        .$PHPShopGUI->setInput('password','password_api_new',$password_api,false,'97%','');

    $Tab1.=$PHPShopGUI->setText("������� �������������� �������� ��� ��������� ����������� (����� ������� ��������� ���������, ���������� �� ����� �������):")
        .$PHPShopGUI->setInput('text','admin_phone_new',$admin_phone,false,'97%','','','','(� �������: 71234567890)');

    $Tab1.=$PHPShopGUI->setText("��� ����������� (�� ��������� INCORE). ��� ������������� � ��� ����������� ����� ����������� ���������� ������������ � ����� ����������.:")
        .$PHPShopGUI->setInput('text','sender_new',$sender,false,'97%','','','','');

    $Tab1.=$PHPShopGUI->setLink("https://".$domen_api."/ru/reg.html", '������� �� ������ � ������������������', '_blank', 'margin:5px;display:inline-block;');

    $Tab1.=$PHPShopGUI->setLink("https://".$domen_api."/ru/cabinet.html", '������� �� ������ �  ��������������', '_blank', 'margin:5px;display:inline-block;');

    // ���������� �������� 2
    $Tab2 = $PHPShopGUI->setText("<h3>������ '����� �����' ��� ���������: </h3>",'',false)
            .$PHPShopGUI->setInput("button","","�������� ��������-��������","","","ShablonAdd('order_template_sms_new','��������-������� - @NameShop@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������������� ������","","","ShablonAdd('order_template_sms_new','��� ����� ������ - @OrderNum@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������ ������","","","ShablonAdd('order_template_sms_new','������ ������ ������ - @OrderStatus@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������ ������","","","ShablonAdd('order_template_sms_new','������ ������:".'\r\n'."@Order@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setTextarea('order_template_sms_new',$order_template_sms,false,'97%',150);

    $Tab2.= $PHPShopGUI->setText("<h3>������ '��������� ������� ������': </h3>",'',false)
        .$PHPShopGUI->setInput("button","","�������� ��������-��������","","","ShablonAdd('change_status_order_template_sms_new','��������-������� - @NameShop@')","btn-sm btn-primary","","","")
        .$PHPShopGUI->setInput("button","","������������� ������","","","ShablonAdd('change_status_order_template_sms_new','��� ����� ������ - @OrderNum@')","btn-sm btn-primary","","","")
        .$PHPShopGUI->setInput("button","","������ ������","","","ShablonAdd('change_status_order_template_sms_new','������ ������ ������ ������� �� - @OrderStatus@')","btn-sm btn-primary","",
            "","")
        .$PHPShopGUI->setTextarea('change_status_order_template_sms_new',$change_status_order_template_sms,false,'97%',150);

    // ���������� �������� 3
    $Info = '<div>
      <h2>������</h2>
      <p>��� ������ ������ � ������������� ������� "InCore Dev: SMS-�����������" ���������� ������ <a href="https://'.$domen_api.'/ru/reg.html" target="_blank">�����������</a>
      �� ������� InCore Dev � ��������� ��������� ��������, ������� ���������� � ������������ �� ������� � 9.00 �� 18.00 ��
      ����������� �������.</p>
      <p>��������� ��� � ������ ����������� �������������� - 1,5 ���. ��������� ��� ��� ����� ����������� - 1 ���.</p>
      <p>��� ������������� � ��� ����������� ����� ����������� ���������� ������������ � ����� ���������� �������
      InCore Dev.</p>
      <p>��� �������� SMS-����������� ������������ ������
      <a href="#" onclick="window.open(\'http://incoredevelopment.com\')">InCore Dev.</a></p>
      <h2>������ "����� �����" ��� ��������������</h2>
      <p>������������� ��� �������������� �����. ������ ��������� ����� ��������� ����� ���������� ������ ������.</p>
      <h2>������ "����� �����" ��� ���������</h2>
      <p>������������� ��� ����������� ��������� � ����������� ������.</p>
      <h2>������ "��������� ������� ������"</h2>
      <p>������������� ��� ����������� ��������� �� ��������� ������� ������.</p>
      <h2>������ � �������� ����� ��������� ����� -> <input type="button" value="������" class="btn btn-sm btn-primary"></h2>
      <p>������ ������ ��������� � ��������� ���� ����������� ���������� ��� ������������ ��������� ��������� ����� ��������� �����������. ����� �������� ���������� � ��������� ����, ������ ��������� ������ � ������ ����� ���� � �������� �� ������ � ������ ���������.</p>
      </div>
    ';
    
    $Tab3 = $PHPShopGUI->setInfo($Info, '', '95%');

    // ���������� �������� 4
    $Tab4 = $PHPShopGUI->setPay('',false);
    
    // ���������� �������� 5
    $Tab5.= $PHPShopGUI->setInfo('<div><p>������ <a href="http://www.webvk.ru" target="_blank">WEBVK</a>,</p><p>E-mail: <a href="mailto:mail@webvk">mail@webvk.ru</a></p></div>', '', '99%');

    // ���������� �������� 6
    $Tab6 = $PHPShopGUI->setText("<h3>������ '����� �����' ��� ��������������: </h3>",'',false)
            .$PHPShopGUI->setInput("button","","�������� ��������-��������","","","ShablonAdd('order_template_admin_sms_new','��������-������� - @NameShop@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������������� ������","","","ShablonAdd('order_template_admin_sms_new','�������� ����� ����� �@OrderNum@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","��� ���������","","","ShablonAdd('order_template_admin_sms_new','��� - @UserFio@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������� ���������","","","ShablonAdd('order_template_admin_sms_new','������� - @UserPhone@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","E-mail ���������","","","ShablonAdd('order_template_admin_sms_new','E-mail - @UserMail@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","��������","","","ShablonAdd('order_template_admin_sms_new','������ �������� - @UserDelivery@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������","","","ShablonAdd('order_template_admin_sms_new','������ - @UserCountry@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������","","","ShablonAdd('order_template_admin_sms_new','������ - @UserState@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","�����","","","ShablonAdd('order_template_admin_sms_new','����� - @UserCity@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","�������� ������","","","ShablonAdd('order_template_admin_sms_new','�������� ������ - @UserIndex@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","�����","","","ShablonAdd('order_template_admin_sms_new','����� - @UserStreet@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","���","","","ShablonAdd('order_template_admin_sms_new','��� - @UserHouse@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","�������","","","ShablonAdd('order_template_admin_sms_new','������� - @UserPorch@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","��� ��������","","","ShablonAdd('order_template_admin_sms_new','��� �������� - @UserDoorPhone@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","��������","","","ShablonAdd('order_template_admin_sms_new','�������� - @UserFlat@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","����� ��������","","","ShablonAdd('order_template_admin_sms_new','����� �������� - @UserDelivtime@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","���. ����","","","ShablonAdd('order_template_admin_sms_new','���. ���� - @UserDopInfo@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","������ ������","","","ShablonAdd('order_template_admin_sms_new','������ ������:".'\r\n'."@Order@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setInput("button","","�������� ����� ����� ������","","","ShablonAdd('order_template_admin_sms_new','����� ����� ������: @CommonSumOrder@')","btn-sm btn-primary","",
            "","")
            .$PHPShopGUI->setTextarea('order_template_admin_sms_new',$order_template_admin_sms,false,'',500);
    
    
    // ���������� �������� 7
    $Tab7 = $PHPShopGUI->setInfo('
      <div>
      <p><b>������ ���������</b></p>

      <p>������ ������: � 10:00 �� 19:00<br>(���������, ����� ��������)</p>
      
      <p>���.: <a href="tel:8-800-550-17-89">8-800-550-17-89</a></p>
      <p><a href="mailto:support@incore1.ru">support@incore1.ru</a></p>
      </div>
    ', '', '95%');
    
    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,300),array("������� ��� ��������������",'<div class="smsgate">'.$Tab6.'</div>',''),array("������� ��� ���������",'<div class="smsgate">'.$Tab2.'</div>',''),array("����������",$Tab3,''),array("� ������",$Tab4,''),array("�����������",$Tab5,''),array("���������",$Tab7,''));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("submit","saveID","��","right",70,"","but","actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ��������� �������
$PHPShopGUI->getAction();

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['saveID'],'actionStart');


?>


