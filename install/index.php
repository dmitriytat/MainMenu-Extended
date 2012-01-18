<?php
define('_IN_JOHNCMS', 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Установка MainMenu Extended 0.5</title>
<style type='text/css'>
body {font-family: Calibri, Arial, Helvetica, sans-serif; font-size: small; color: #4E4E4E; background-color: #FFFFFF; width: 360px;}
h2{ margin: 0; padding: 0; padding-bottom: 4px; color: #363636; }
ul{ margin:0; padding-left:20px; }
li { padding-bottom: 6px; }
.red { color: #FF0000; font-weight: bold; }
.green{ color: #009933; font-weight: bold; }
.gray{ color: #999999; font: small; }
hr{ color: #B9B9B9; text-align: left;}
a { color: #548569; text-decoration: none;}
</style>
</head><body>
<h2>Установка MainMenu Extended 0.5 fix 0.1 для JohnCMS 4.4.0</h2>
<hr /><br />
<?php

switch ($_GET['act']) {

        // Начало работы
    default:
?>
    <b>Если вы видите эту страницу, значит вы уже сделали подготовительную работу.</b>
    <p>Теперь дело остается за малым, создать таблицы в базе данных.</p>
    Информация о модуле и создателях: <a href="../readmme.txt">readmme.txt</a></p>
    <b><a class="green" href="index.php?act=set">Установка</a></b><br />
    <b><a class="green" href="index.php?act=fix">Исправление для 0.5 fix 0.1</a></b><br />
    <b><a class="green" href="index.php?act=update">Обновление с 0.3 до 0.5</a></b>
    <?php
        break;

        // исправление
    case 'fix':
    require_once ("../incfiles/db.php");
    $connect = mysql_connect($db_host, $db_user, $db_pass) or die('cannot connect to server</div></body></html>');
        mysql_select_db($db_name) or die('cannot connect to db</div></body></html>');
        mysql_query("SET NAMES 'utf8'", $connect);
        mysql_query("ALTER TABLE `cms_menu_count` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
        mysql_query("ALTER TABLE `cms_menu_group` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
        mysql_query("ALTER TABLE `cms_menu_link` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
        mysql_query("ALTER TABLE `cms_menu_settings` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
echo '<span class="green">Oк</span> - Пофиксили! закончено!<br />Незабудте удалить папку install';

        break;
        
        // обновление
    case 'update':
    require_once ("../incfiles/db.php");
    $connect = mysql_connect($db_host, $db_user, $db_pass) or die('cannot connect to server</div></body></html>');
        mysql_select_db($db_name) or die('cannot connect to db</div></body></html>');
        mysql_query("SET NAMES 'utf8'", $connect);
            mysql_query("ALTER TABLE cms_menu_group ADD sumbo text NOT NULL;");
            mysql_query("ALTER TABLE cms_menu_link ADD sumbo text NOT NULL;");
            mysql_query("INSERT INTO `cms_settings` SET `key`='impote', `val`='".(time() - 1728000)."';");
echo '<span class="green">Oк</span> - Обнавление закончено!<br />Незабудте удалить папку install';

        break;

        // Установка
    case 'set':

        require_once ("../incfiles/db.php");
        $connect = mysql_connect($db_host, $db_user, $db_pass) or die('cannot connect to server</div></body></html>');
        mysql_select_db($db_name) or die('cannot connect to db</div></body></html>');
        mysql_query("SET NAMES 'utf8'", $connect);
        $error = '';
        @set_magic_quotes_runtime(0);
        // Читаем SQL файл и заносим его в базу данных
        $query = fread(fopen('data/install.sql', 'r'), filesize('data/install.sql'));
        $pieces = split_sql($query);
        for ($i = 0; $i < count($pieces); $i++) {
            $pieces[$i] = trim($pieces[$i]);
            if (!empty($pieces[$i]) && $pieces[$i] != "#") {
                if (!mysql_query($pieces[$i])) {
                    $error = $error . mysql_error() . '<br />';
                }
            }
        }
        if (empty($error))
        echo "Все ОК!";
        else
        echo "Что-то пошло не так!";
        break;

}

?>
<hr /><br />
<b><a href="http://dimkos.ru">Модуль изготовил: Дмитрий aka dimko</a></b>
</body></html>

<?php
function split_sql($sql)
{
    $sql = trim($sql);
    $sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);
    $buffer = array();
    $ret = array();
    $in_string = false;
    for ($i = 0; $i < strlen($sql) - 1; $i++) {
        if ($sql[$i] == ";" && !$in_string) {
            $ret[] = substr($sql, 0, $i);
            $sql = substr($sql, $i + 1);
            $i = 0;
        }
        if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
            $in_string = false;
        } elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) ||
        $buffer[0] != "\\")) {
            $in_string = $sql[$i];
        }
        if (isset($buffer[1])) {
            $buffer[0] = $buffer[1];
        }
        $buffer[1] = $sql[$i];
    }
    if (!empty($sql)) {
        $ret[] = $sql;
    }
    return ($ret);
}

?>
