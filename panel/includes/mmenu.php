<?php

/**
* @package     JohnCMS
* @link        http://johncms.com
* @copyright   Copyright (C) 2008-2011 JohnCMS Community
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      http://johncms.com/about
*/

defined('_IN_JOHNADM') or die('Error: restricted access');

// Проверяем права доступа
if ($rights < 7) {
    header('Location: http://johncms.com/?err');
    exit;
}
switch ($_GET['from']) {

    default:
?>
<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | Редактор меню</div>
<div class="menu"><a href="index.php?act=mmenu&amp;from=addgroup">Добавить группу</a></div>
<div class="menu"><a href="index.php?act=mmenu&amp;from=addlink">Добавить ссылку</a></div>
<div class="menu"><a href="index.php?act=mmenu&amp;from=count">Добавить счетчик</a></div>
<div class="gmenu"><a href="index.php?act=mmenu&amp;from=edit">Редактировать меню</a></div>
<div class="gmenu"><a href="index.php?act=mmenu&amp;from=edco">Редактировать счетчики</a></div>
<div class="menu"><a href="index.php?act=mmenu&amp;from=set">Настройки модуля</a></div>
<div class="menu"><a href="index.php?act=mmenu&amp;from=about">О модуле</a></div>
<?php
        break;
    case 'about':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | О модуле</div>';
        echo '<div class="menu"><b>Название:</b> MainMenu Extended</div>';
        echo '<div class="menu"><b>Версия:</b> 0.5</div>';
        echo '<div class="menu"><b>Автор:</b> Dimko<a href="http://dimkos.ru/"></a></div>';
        echo '<div class="menu"><b>Сайт поддержки:</b> <a href="http://dimkos.ru/">Dimkos.ru</a></div>';
        echo '<div class="menu"><b>Предназначение:</b> переход от ручного труда, к машинному.</div>';
        echo '<div class="menu">По всем вопросам связанным с использованием модуля пишите или на сайт поддержки, или на JohnCMS</div>';
        break;

    case 'edco':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Редактирование счетчиков</div>';


        $m_count = mysql_query("select * from cms_menu_count mode ORDER BY id;");
        if ($m_count) {
            while ($m_count_n = mysql_fetch_array($m_count)) {
                echo '<div class="menu">';
                echo $m_count_n['name'] . '<br/>';
                echo '<small><a href="index.php?act=mmenu&amp;from=editco&amp;id=' . $m_count_n['id'] .
                    '">Изм.</a> | 
          <a href="index.php?act=mmenu&amp;from=delco&amp;id=' . $m_count_n['id'] .
                    '">Удал.</a>';
                echo '</small></div>';
            }
        }

        break;

    case 'editco':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edco"><b>Редактирование счетчиков</b></a> | Редактирование счетчика</div>';

        if ($_GET['m'] != 1) {
            $m_count = mysql_query("SELECT * FROM `cms_menu_count` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_count_n = mysql_fetch_array($m_count);
            echo ' <form action="index.php?act=mmenu&amp;from=editco&amp;m=1&amp;id=' . $_GET['id'] .
                '" method="post">
 <div class="menu">
 <b>Название:</b><br />
 <input type="text" name="name" value="' . $m_count_n['name'] . '"/></div>';
            echo '<div class="menu">
 <b>Функция (Без скобочек):</b><br />
 <input type="text" name="code" value="' . $m_count_n['code'] . '"/></div>';
            echo '<div class="phdr">
     <input type="submit" name="submit" value="Изменить" />
   </div>
 </form>';
        } else {

            mysql_query("UPDATE `cms_menu_count` SET `name`='" . $_POST['name'] .
                "', `code`='" . $_POST['code'] . "' WHERE `id`='" . $_GET['id'] . "';");
            echo '<div class="menu">Счетчик успешно изменен.</div>';

        }

        break;

    case 'delco':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edco"><b>Редактирование счетчиков</b></a> | Удаление счетчика</div>';
        mysql_query("DELETE FROM `cms_menu_count` WHERE `id`='" . $_GET['id'] . "';");
        mysql_query("UPDATE `cms_menu_link` SET `type`='0' WHERE `type`='" . $_GET['id'] .
            "';");
        echo '<div class="menu">Счетчик успешно удален.</div>';
        break;

    case 'count':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Добавление счетчика</div>';

        if ($_GET['m'] != 1) {
            echo ' <form action="index.php?act=mmenu&amp;from=count&amp;m=1" method="post">
 <div class="menu">
 <b>Название:</b><br />
 <input type="text" name="name" value="от гостевой"/></div>';
            echo '<div class="menu">
 <b>Функция (Без скобочек):</b><br />
 <input type="text" name="code" value="gbook"/></div>';
            echo '<div class="phdr">
     <input type="submit" name="submit" value="Добавить" />
   </div>
 </form>';
        } else {
            mysql_query("INSERT INTO `cms_menu_count` SET  `name`='" . $_POST['name'] .
                "', `code`='" . $_POST['code'] . "';");
            echo '<div class="menu">Счетчик успешно добавлен.</div>';

        }

        break;

    case 'set':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Настройки модуля</div>';

        if ($_GET['m'] != 1) {

            echo '<form action="index.php?act=mmenu&amp;from=set&amp;m=1" method="post">';
            echo '<div class="menu">Модуль:<br/>';
            echo '<input type="radio" name="enabled" value="1"';
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='enabled' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            if ($m_set_n['val'] == 1)
                echo ' checked="checked"';
            echo '/> Вкл.<br/>';
            echo '<input type="radio" name="enabled" value="0"';
            if ($m_set_n['val'] == 0)
                echo ' checked="checked"';
            echo ' /> Выкл.<br/></div>';

            echo '<div class="menu">Каталог с иконками:<br/>';
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);

            echo '<input type="radio" name="pic_cat" value="1" ';
            if ($m_set_n['val'] == 1)
                echo ' checked="checked"';
            echo '/> В каталоге с темой.<br/>';
            echo '<input type="radio" name="pic_cat" value="0"';
            if ($m_set_n['val'] == 0)
                echo ' checked="checked"';
            echo '/> В корне сайта.<br/></div>';
            echo '<div class="menu">Имя каталога иконок:<br/>';
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            echo '<input type="text" name="pic_path" value="' . $m_set_n['val'] . '"/>';
            echo '</div>';
            echo '<div class="phdr">
     <input type="submit" name="submit" value="Сохранить" />
   </div>
 </form>';
        } else {
            mysql_query("UPDATE `cms_menu_settings` SET `val`='" . $_POST['enabled'] .
                "' WHERE `key`='enabled';");
            mysql_query("UPDATE `cms_menu_settings` SET `val`='" . $_POST['pic_cat'] .
                "' WHERE `key`='pic_cat';");
            mysql_query("UPDATE `cms_menu_settings` SET `val`='" . $_POST['pic_path'] .
                "' WHERE `key`='pic_path';");
            echo '<div class="menu">Настройки успешно сохранены.</div>';
        }
        break;

    case 'addgroup':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Добавить группу</div>';
        if ($_GET['m'] != 1) {
?>
 <form action="index.php?act=mmenu&amp;from=addgroup&amp;m=1" method="post">
 <div class="menu">
 <b>Название:</b><br />
 <input type="text" name="name"/></div>
  <div class="menu">
 <b>Иконка группы:</b><br />
 <input type="radio" name="pic" value="" checked="checked"/> без иконки<br/>
 <?php
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            if ($m_set_n['val'] == 1)
                $filename = '../theme/' . $set_user['skin'] . "/";
            else
                $filename = '../';

            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            $filename = $filename . $m_set_n['val'] . "/";


            $pic_list = glob($filename . "*.png");
            foreach ($pic_list as $file) {
                $file = basename($file);
                echo '<input type="radio" name="pic" value="' . $file . '" /> ';
                echo '<img class="mme_image" alt="" src="' . $filename . $file . '" /> ' . $file .
                    '<br/>';
            }

?>
</div>
<div class="menu">
 <b>Если не картинка, то символ:</b><br />
 <input type="text" name="sumbo" value="&rArr;" /></div>
   <div class="phdr">
     <input type="submit" name="submit" value="Добавить" />
   </div>
 </form>
<?php
        } else {
            $m_group = mysql_query("select count(1) from `cms_menu_group` ");
            $m_group_n = mysql_fetch_array($m_group);
            $max = $m_group_n[0];

            mysql_query("INSERT INTO `cms_menu_group` SET `show`='1', `pos`='" . ($max + 1) .
                "' , `pic`='" . $_POST['pic'] . "', `sumbo`='" . $_POST['sumbo'] . "', `name`='" .
                $_POST['name'] . "';");

            echo '<div class="menu">Группа успешно добавлена.</div>';
        }
        break;

    case 'addlink':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Добавить ссылку</div>';
        if ($_GET['m'] != 1) {
?>
 <form action="index.php?act=mmenu&amp;from=addlink&amp;m=1" method="post">
 <div class="gmenu">
 <b>Название:</b><br />
 <input type="text" name="name"/></div>
 <div class="menu">
 <b>URL:</b><br />
 <input type="text" name="link" value="http://" /></div>
 <div class="menu">
 <b>Группа:</b><br />
<?php
            $m_group = mysql_query("select * from cms_menu_group mode ORDER BY id;");
            if ($m_group) {
                while ($m_group_n = mysql_fetch_array($m_group)) {
                    echo '<input type="radio" name="group" value="' . $m_group_n['id'] . '" /> ' . $m_group_n['name'] .
                        '<br/>';
                }
            }
?>
 </div>
 <div class="menu">
 <b>+ счетчик:</b><br />
 <input type="radio" name="type" value="0" checked="checked" /> без счетчика<br/>
 <?php

            $m_count = mysql_query("select * from cms_menu_count mode ORDER BY id;");
            if ($m_count) {
                while ($m_count_n = mysql_fetch_array($m_count)) {
                    echo '<input type="radio" name="type" value="' . $m_count_n['id'] . '" /> ' . $m_count_n['name'] .
                        '<br/>';
                }
            }


?>
 </div>
 
   <div class="menu">
 <b>Иконка ссылки:</b><br />
 <input type="radio" name="pic" value="" checked="checked"/> без иконки<br/>
 <?php
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            if ($m_set_n['val'] == 1)
                $filename = '../theme/' . $set_user['skin'] . "/";
            else
                $filename = '../';

            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            $filename = $filename . $m_set_n['val'] . "/";


            $pic_list = glob($filename . "*.png");
            foreach ($pic_list as $file) {
                $file = basename($file);
                echo '<input type="radio" name="pic" value="' . $file . '" /> ';
                echo '<img class="mme_image" alt="" src="' . $filename . $file . '" /> ' . $file .
                    '<br/>';
            }

?>
</div>
<div class="menu">
 <b>Если не картинка, то символ:</b><br />
 <input type="text" name="sumbo" value="&rArr;" /></div>

   <div class="phdr">
     <input type="submit" name="submit" value="Добавить" />
   </div>
 </form>
<?php
        } else {

            $m_link = mysql_query("select count(1) from `cms_menu_link` where `group`='" . $_POST['group'] .
                "'");
            $m_link_n = mysql_fetch_array($m_link);
            $max = $m_link_n[0];

            mysql_query("INSERT INTO `cms_menu_link` SET `type`='" . $_POST['type'] .
                "', `pos`='" . ($max + 1) . "' , `sumbo`='" . $_POST['sumbo'] . "', `pic`='" . $_POST['pic'] .
                "', `show`='1', `name`='" . $_POST['name'] . "', `link`='" . $_POST['link'] .
                "', `group`='" . $_POST['group'] . "' ;");


            echo '<div class="menu">Ссылка успешно добавлена.</div>';
        }
        break;

    case 'edit':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | Редактирование</div>';


        $m_group = mysql_query("select * from cms_menu_group mode ORDER BY pos;");
        if ($m_group) {
            while ($m_group_n = mysql_fetch_array($m_group)) {
                if ($m_group_n['show'] == 1)
                    echo '<div class="phdr">';
                else
                    echo '<div class="footer">';

                $filename = '';
                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
                $m_set_n = mysql_fetch_array($m_set);
                if ($m_set_n['val'] == 1)
                    $filename = '../theme/' . $set_user['skin'] . "/";
                else
                    $filename = '../';

                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
                $m_set_n = mysql_fetch_array($m_set);
                $filename = $filename . $m_set_n['val'] . "/" . $m_group_n['pic'];
                if (file_exists($filename) and $m_group_n['pic'] != '')
                    echo '<img class="mme_image" alt="" src="' . $filename . '" /> ';
                else
                    echo $m_group_n['sumbo'] . ' ';
                echo '<b>' . $m_group_n['name'] . '</b><br />';
                echo '<small><a href="index.php?act=mmenu&amp;from=editg&amp;id=' . $m_group_n['id'] .
                    '">Изм.</a> | 
           <a href="index.php?act=mmenu&amp;from=delg&amp;id=' . $m_group_n['id'] .
                    '">Удал.</a> | ';
                if ($m_group_n['show'] == 1)
                    echo '<a href="index.php?act=mmenu&amp;from=tog&amp;id=' . $m_group_n['id'] .
                        '">Скрыть</a> ';
                else
                    echo '<a href="index.php?act=mmenu&amp;from=shg&amp;id=' . $m_group_n['id'] .
                        '">Показать</a> ';
                echo '| <a href="index.php?act=mmenu&amp;from=upg&amp;id=' . $m_group_n['id'] .
                    '">Вверх</a> | 
          <a href="index.php?act=mmenu&amp;from=downg&amp;id=' . $m_group_n['id'] .
                    '">Вниз</a>';
                echo '</small></div>';
                $m_link = mysql_query("select * from cms_menu_link mode ORDER BY pos;");
                if ($m_link) {
                    while ($m_link_n = mysql_fetch_array($m_link)) {
                        if ($m_group_n['id'] == $m_link_n['group']) {
                            if ($m_group_n['show'] == 1 && $m_link_n['show'] == 1)
                                echo '<div class="menu">';
                            else
                                echo '<div class="list1">';

                            $filename = '';
                            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
                            $m_set_n = mysql_fetch_array($m_set);
                            if ($m_set_n['val'] == 1)
                                $filename = '../theme/' . $set_user['skin'] . "/";
                            else
                                $filename = '../';

                            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
                            $m_set_n = mysql_fetch_array($m_set);
                            $filename = $filename . $m_set_n['val'] . "/" . $m_link_n['pic'];

                            if (file_exists($filename) and $m_link_n['pic'] != '')
                                echo '<img class="mme_image" alt="" src="' . $filename . '" /> ';
                            else
                                echo $m_link_n['sumbo'] . ' ';
                            echo '<a href="' . $m_link_n['link'] . '">' . $m_link_n['name'] .
                                '</a><br />';
                            echo '<small><a href="index.php?act=mmenu&amp;from=editl&amp;id=' . $m_link_n['id'] .
                                '">Изм.</a> | 
                   <a href="index.php?act=mmenu&amp;from=dell&amp;id=' . $m_link_n['id'] .
                                '">Удал.</a> | ';
                            if ($m_group_n['show'] == 1 && $m_link_n['show'] == 1)
                                echo '<a href="index.php?act=mmenu&amp;from=tol&amp;id=' . $m_link_n['id'] .
                                    '">Скрыть</a> ';
                            else
                                echo '<a href="index.php?act=mmenu&amp;from=shl&amp;id=' . $m_link_n['id'] .
                                    '">Показать</a> ';
                            echo '| <a href="index.php?act=mmenu&amp;from=upl&amp;id=' . $m_link_n['id'] .
                                '">Вверх</a> | ';
                            echo ' <a href="index.php?act=mmenu&amp;from=downl&amp;id=' . $m_link_n['id'] .
                                '">Вниз</a>';
                            echo '</small></div>';
                        }
                    }
                }
            }
        } else {
            echo "<p><b>Error: " . mysql_error() . "</b><p>";
            exit();
        }

        break;

    case 'tog':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Скрыть/Показать</div>';
        mysql_query("UPDATE `cms_menu_group` SET `show`='0' WHERE `id`='" . $_GET['id'] .
            "';");
        echo '<div class="menu">Группа успешно скрыта.</div>';
        break;

    case 'tol':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Скрыть/Показать</div>';
        mysql_query("UPDATE `cms_menu_link` SET `show`='0' WHERE `id`='" . $_GET['id'] .
            "';");
        echo '<div class="menu">Ссылка успешно скрыта.</div>';
        break;

    case 'shg':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Скрыть/Показать</div>';
        mysql_query("UPDATE `cms_menu_group` SET `show`='1' WHERE `id`='" . $_GET['id'] .
            "';");
        echo '<div class="menu">Группа успешно показана.</div>';
        break;

    case 'shl':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Скрыть/Показать</div> ';
        mysql_query("UPDATE `cms_menu_link` SET `show`='1' WHERE `id`='" . $_GET['id'] .
            "';");
        echo '<div class="menu">Ссылка успешно показана.</div>';
        break;

    case 'delg':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Удаление группы</div> ';
    $m_set = mysql_query("SELECT * FROM `cms_settings` WHERE `key`='impote' LIMIT 1;");
    $m_set_n = mysql_fetch_array($m_set); 
    $dead=round((($m_set_n['val']+1728000) - time())/60/60/24);
    
       if ($_GET['id']!=4 || $dead<=0) {
        mysql_query("DELETE FROM `cms_menu_group` WHERE `id`='" . $_GET['id'] . "';");
        mysql_query("DELETE FROM `cms_menu_link` WHERE `group`='" . $_GET['id'] . "';");
        echo '<div class="menu">Группа успешно удалена.</div>';
        } else {
             
    echo display_error('Вы не можете удалять эту ссылку еще '. $dead .' дней!');
  
    require_once ('../incfiles/end.php');
    exit;
        }
        break;

    case 'dell':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Удаление ссылки</div> ';
        mysql_query("DELETE FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] . "';");
        echo '<div class="menu">Ссылка успешно удалена.</div>';
        break;


    case 'editl':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Редактировать ссылку</div>';
        if ($_GET['m'] != 1) {

            $m_link = mysql_query("SELECT * FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_link_n = mysql_fetch_array($m_link);
            echo '
 <form action="index.php?act=mmenu&amp;from=editl&amp;m=1&amp;id=' . $_GET['id'] .
                '" method="post">
 <div class="gmenu">
 <b>Название:</b><br />
 <input type="text" name="name" value="' . $m_link_n['name'] . '"/></div>
 <div class="menu">
 <b>URL:</b><br />
 <input type="text" name="link" value="' . $m_link_n['link'] . '" /></div>
 <div class="menu">
 <b>Группа:</b><br />';

            $m_group = mysql_query("select * from cms_menu_group;");
            if ($m_group) {
                while ($m_group_n = mysql_fetch_array($m_group)) {
                    if ($m_link_n['group'] == $m_group_n['id'])
                        echo '<input type="radio" name="group" value="' . $m_group_n['id'] .
                            '" checked="checked" /> ' . $m_group_n['name'] . '<br/>';
                    else
                        echo '<input type="radio" name="group" value="' . $m_group_n['id'] . '" /> ' . $m_group_n['name'] .
                            '<br/>';
                }
            }


?>
 </div>
 <div class="menu">
 <b>+ счетчик:</b><br />
 <input type="radio" name="type" value="0" checked="checked" /> без счетчика<br/>
 <?php

            $m_count = mysql_query("select * from cms_menu_count mode ORDER BY id;");
            if ($m_count) {
                while ($m_count_n = mysql_fetch_array($m_count)) {
                    echo '<input type="radio" name="type" value="' . $m_count_n['id'] . '" /> ' . $m_count_n['name'] .
                        '<br/>';
                }
            }


?>
 </div>
 
   <div class="menu">
 <b>Иконка ссылки:</b><br />
 <input type="radio" name="pic" value="" checked="checked"/> без иконки<br/>
 <?php
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            if ($m_set_n['val'] == 1)
                $filename = '../theme/' . $set_user['skin'] . "/";
            else
                $filename = '../';

            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            $filename = $filename . $m_set_n['val'] . "/";


            $pic_list = glob($filename . "*.png");
            foreach ($pic_list as $file) {
                $file = basename($file);
                echo '<input type="radio" name="pic" value="' . $file . '" /> ';
                echo '<img class="mme_image" alt="" src="' . $filename . $file . '" /> ' . $file .
                    '<br/>';
            }

?>
</div>
<div class="menu">
 <b>Если не картинка, то символ:</b><br />
 <input type="text" name="sumbo" value="<?php echo $m_link_n['sumbo']; ?>" /></div>
   <div class="phdr">
     <input type="submit" name="submit" value="Сохранить" />
   </div>
 </form>
<?php
        } else {

            $m_link = mysql_query("select count(1) from `cms_menu_link` where `group`='" . $_POST['group'] .
                "'");
            $m_link_n = mysql_fetch_array($m_link);
            $max = $m_link_n[0];
            $m_link = mysql_query("SELECT * FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_link_n = mysql_fetch_array($m_link);
            if ($_POST['group'] == $m_link_n['group'])
                mysql_query("UPDATE `cms_menu_link` SET `type`='" . $_POST['type'] .
                    "', `pic`='" . $_POST['pic'] . "', `show`='1', `sumbo`='" . $_POST['sumbo'] . "', `name`='" . $_POST['name'] .
                    "', `link`='" . $_POST['link'] . "', `group`='" . $_POST['group'] .
                    "' WHERE `id`='" . $_GET['id'] . "';");
            else
                mysql_query("UPDATE `cms_menu_link` SET `type`='" . $_POST['type'] .
                    "', `pic`='" . $_POST['pic'] . "', `pos`='" . ($max + 1) .
                    "', `show`='1', `sumbo`='" . $_POST['sumbo'] . "', `name`='" . $_POST['name'] . "', `link`='" . $_POST['link'] .
                    "', `group`='" . $_POST['group'] . "' WHERE `id`='" . $_GET['id'] . "';");

            echo '<div class="menu">Ссылка успешно изменена.</div>';
        }
        break;

    case 'editg':
        echo '<div class="phdr"><a href="index.php"><b>Админ панель</b></a> | <a href="index.php?act=mmenu"><b>Редактор меню</b></a> | <a href="index.php?act=mmenu&amp;from=edit"><b>Редактирование</b></a> | Редактировать группу</div>';
        
         $m_set = mysql_query("SELECT * FROM `cms_settings` WHERE `key`='impote' LIMIT 1;");
    $m_set_n = mysql_fetch_array($m_set); 
    
    $dead=round((($m_set_n['val']+1728000) - time())/60/60/24);
            if ($_GET['m'] != 1) {

            $m_group = mysql_query("SELECT * FROM `cms_menu_group` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_group_n = mysql_fetch_array($m_group);
           
      
            if ($m_group_n['id']!=4 || $m_group_n['name']!='[url=http://dimkos.ru]Dimko`s blog[/url]' || $dead<=0) {
?>
 <form action="index.php?act=mmenu&amp;from=editg&amp;m=1&amp;id=<?php echo $_GET['id']; ?>" method="post">
 <div class="menu">
 <b>Название:</b><br />
 <input type="text" name="name" value="<?php echo $m_group_n['name']; ?>" /></div>
 
 <div class="menu">
 <b>Иконка группы:</b><br />
 <input type="radio" name="pic" value="" checked="checked"/> без иконки<br/>
 <?php
            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            if ($m_set_n['val'] == 1)
                $filename = '../theme/' . $set_user['skin'] . "/";
            else
                $filename = '../';

            $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
            $m_set_n = mysql_fetch_array($m_set);
            $filename = $filename . $m_set_n['val'] . "/";


            $pic_list = glob($filename . "*.png");
            foreach ($pic_list as $file) {
                $file = basename($file);
                echo '<input type="radio" name="pic" value="' . $file . '" /> ';
                echo '<img class="mme_image" alt="" src="' . $filename . $file . '" /> ' . $file .
                    '<br/>';
            }

?>
</div>
<div class="menu">
 <b>Если не картинка, то символ:</b><br />
 <input type="text" name="sumbo" value="<?php echo $m_group_n['sumbo']; ?>" /></div>
   <div class="phdr">
     <input type="submit" name="submit" value="Сохранить" />
   </div>
 </form>
<?php

} else {
    

    echo display_error('Вы не можете изменять эту ссылку еще '. $dead .' дней!');
    
    require_once ('../incfiles/end.php');
    exit;
        }
        
        } else {
            if ($_GET['id']!=4 || $dead<=0) {
            mysql_query("UPDATE `cms_menu_group` SET `show`='1', `pic`='" . $_POST['pic'] .
                "', `sumbo`='" . $_POST['sumbo'] . "', `name`='" . $_POST['name'] . "' WHERE `id`='" . $_GET['id'] . "';");
            echo '<div class="menu">Группа успешно изменена.</div>';
            } else {
                   
    echo display_error('Вы не можете изменять эту ссылку еще '. $dead .' дней!');
  
    require_once ('../incfiles/end.php');
    exit;
        }
        }
        
        
        break;


    case 'upg':

        $m_group = mysql_query("SELECT * FROM `cms_menu_group` WHERE `id`='" . $_GET['id'] .
            "' LIMIT 1;");
        $m_group_n = mysql_fetch_array($m_group);

        if ($m_group_n['pos'] > '1') {
            $m_group = mysql_query("SELECT * FROM `cms_menu_group` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_group_n = mysql_fetch_array($m_group);

            mysql_query("UPDATE `cms_menu_group` SET `pos`='-1' WHERE `pos`='" . ($m_group_n['pos'] -
                1) . "';");
            mysql_query("UPDATE `cms_menu_group` SET `pos`='" . ($m_group_n['pos'] - 1) .
                "' WHERE `pos`='" . ($m_group_n['pos']) . "';");
            mysql_query("UPDATE `cms_menu_group` SET `pos`='" . ($m_group_n['pos']) .
                "' WHERE `pos`='-1';");
        }

        echo '<script language="JavaScript">window.location.href = "index.php?act=mmenu&amp;from=edit"</script>';

        break;

    case 'downg':

        $m_group = mysql_query("SELECT * FROM `cms_menu_group` mode ORDER BY `pos` DESC LIMIT 1;");
        $m_group_n = mysql_fetch_array($m_group);
        $max = $m_group_n['pos'];

        $m_group = mysql_query("SELECT * FROM `cms_menu_group` WHERE `id`='" . $_GET['id'] .
            "' LIMIT 1;");
        $m_group_n = mysql_fetch_array($m_group);

        if ($m_group_n['pos'] < $max) {

            mysql_query("UPDATE `cms_menu_group` SET `pos`='-1' WHERE `pos`='" . ($m_group_n['pos'] +
                1) . "';");
            mysql_query("UPDATE `cms_menu_group` SET `pos`='" . ($m_group_n['pos'] + 1) .
                "' WHERE `pos`='" . ($m_group_n['pos']) . "';");
            mysql_query("UPDATE `cms_menu_group` SET `pos`='" . ($m_group_n['pos']) .
                "' WHERE `pos`='-1';");
        }

        echo '<script language="JavaScript">window.location.href = "index.php?act=mmenu&amp;from=edit"</script>';

        break;

    case 'upl':

        $m_link = mysql_query("SELECT * FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] .
            "' LIMIT 1;");
        $m_link_n = mysql_fetch_array($m_link);

        if ($m_link_n['pos'] > '1') {
            $m_link = mysql_query("SELECT * FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] .
                "' LIMIT 1;");
            $m_link_n = mysql_fetch_array($m_link);

            mysql_query("UPDATE `cms_menu_link` SET `pos`='-1' WHERE `pos`='" . ($m_link_n['pos'] -
                1) . "' AND `group`='" . $m_link_n['group'] . "';");
            mysql_query("UPDATE `cms_menu_link` SET `pos`='" . ($m_link_n['pos'] - 1) .
                "' WHERE `pos`='" . ($m_link_n['pos']) . "' AND `group`='" . $m_link_n['group'] .
                "';");
            mysql_query("UPDATE `cms_menu_link` SET `pos`='" . ($m_link_n['pos']) .
                "' WHERE `pos`='-1' AND `group`='" . $m_link_n['group'] . "';");
        }

        echo '<script language="JavaScript">window.location.href = "index.php?act=mmenu&amp;from=edit"</script>';

        break;

    case 'downl':

        $m_link = mysql_query("SELECT * FROM `cms_menu_link` mode ORDER BY `pos` DESC LIMIT 1;");
        $m_link_n = mysql_fetch_array($m_link);
        $max = $m_link_n['pos'];

        $m_link = mysql_query("SELECT * FROM `cms_menu_link` WHERE `id`='" . $_GET['id'] .
            "' LIMIT 1;");
        $m_link_n = mysql_fetch_array($m_link);

        if ($m_link_n['pos'] < $max) {

            mysql_query("UPDATE `cms_menu_link` SET `pos`='-1' WHERE `pos`='" . ($m_link_n['pos'] +
                1) . "' AND `group`='" . $m_link_n['group'] . "';");
            mysql_query("UPDATE `cms_menu_link` SET `pos`='" . ($m_link_n['pos'] + 1) .
                "' WHERE `pos`='" . ($m_link_n['pos']) . "' AND `group`='" . $m_link_n['group'] .
                "';");
            mysql_query("UPDATE `cms_menu_link` SET `pos`='" . ($m_link_n['pos']) .
                "' WHERE `pos`='-1' AND `group`='" . $m_link_n['group'] . "';");
        }

        echo '<script language="JavaScript">window.location.href = "index.php?act=mmenu&amp;from=edit"</script>';

        break;
}
?>
<!-- MainMenu Extended 0.5 -->
<p>MainMenu Extended 0.5</p>
<p><a href="index.php">Админ-панель</a></p>
