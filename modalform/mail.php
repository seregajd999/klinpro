<?php
require_once __DIR__ . '/recaptchalib.php';
// Введите свой секретный ключ
$secret = "6Ldhr6YZAAAAAMb2aHE5nRywFVTIEpxpmf2oIDRo";
// пустой ответ каптчи
$response = null;
// Проверка вашего секретного ключа
$reCaptcha = new ReCaptcha($secret);
if ($_POST["g-recaptcha-response"]) {
$response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['uname']) && (empty($_POST['uemail']) || empty($_POST['uphone']))){
    echo '<p class="fail">Ошибка. Вы заполнили не все обязательные поля!</p>';
  } else {
    if ($response != null && $response->success) {
    if (isset($_POST['uname'])) {
      $uname = strip_tags($_POST['uname']);
      $unameFieldset = "<b>Имя пославшего:</b>";
    }
    if (isset($_POST['uemail'])) {
      $uemail = strip_tags($_POST['uemail']);
      $uemailFieldset = "<b>Почта:</b>";
    }
    if (isset($_POST['uphone'])) {
      $uphone = strip_tags($_POST['uphone']);
      $uphoneFieldset = "<b>Телефон:</b>";
    }
    if (isset($_POST['formInfo'])) {
      $formInfo = strip_tags($_POST['formInfo']);
      $formInfoFieldset = "<b>Тема:</b>";
    }

    $to = "info@klin-pro.ru"; /*Укажите адрес, на который должно приходить письмо*/
    $sendfrom = "info@klin-pro.ru"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
    $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
    $headers .= "Content-Transfer-Encoding: 8bit \r\n";
    $subject = "$formInfo";
    $message = "$unameFieldset $uname<br>
                $uemailFieldset $uemail<br>
                $uphoneFieldset $uphone<br>
                $formInfoFieldset $formInfo";

    $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true') {
            echo '<p class="success">Спасибо за отправку вашего сообщения!</p>';
        } else {
          echo '<p class="fail"><b>Ошибка. Сообщение не отправлено!</b></p>';
        }
    } else {
      echo '<p class="success">Не пройдена каптча! Попробуйте еще раз!</p>';
    }
  }
} else {
  header ("Location: https://klin-pro.ru"); // главная страница вашего лендинга
}
