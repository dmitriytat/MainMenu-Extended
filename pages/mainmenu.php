<?

/**
 * @package     JohnCMS
 * @link        http://johncms.com
 * @copyright   Copyright (C) 2008-2011 JohnCMS Community
 * @license     LICENSE.txt (see attached file)
 * @version     VERSION.txt (see attached file)
 * @author      http://johncms.com/about
 */

defined('_IN_JOHNCMS') or die('Error: restricted access');

$mp = new mainpage();

/*
-----------------------------------------------------------------
Блок информации
-----------------------------------------------------------------
*/
echo $mp->news;

// MainMenu Extended
$m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='enabled' LIMIT 1;");
$m_set_n = mysql_fetch_array($m_set);
echo '<!-- MainMenu Extended 0.5 -->';
if ($m_set_n['val'] == 1) {
    $m_group = mysql_query("select * from cms_menu_group mode ORDER BY pos;");
    if ($m_group) {
        while ($m_group_n = mysql_fetch_array($m_group)) {
            if ($m_group_n['show'] == 1) {
                echo '<div class="phdr">';


                $filename = '';
                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
                $m_set_n = mysql_fetch_array($m_set);
                if ($m_set_n['val'] == 1)
                    $filename = './theme/' . $set_user['skin'] . "/";
                else
                    $filename = './';

                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
                $m_set_n = mysql_fetch_array($m_set);
                $filename = $filename . $m_set_n['val'] . "/" . $m_group_n['pic'];

                if (file_exists($filename) and $m_group_n['pic'] != '')
                    echo '<img class="mme_image" alt="" src="' . $filename . '" /> ';
                else
                    echo $m_group_n['sumbo'] . ' ';
                echo '<b>' . $m_group_n['name'] . '</b></div>';
                $m_link = mysql_query("select * from cms_menu_link mode ORDER BY pos;");
                if ($m_link) {
                    while ($m_link_n = mysql_fetch_array($m_link)) {
                        if ($m_link_n['show'] == 1) {
                            if ($m_group_n['id'] == $m_link_n['group']) {

                                $m_count = mysql_query("SELECT * FROM `cms_menu_count` WHERE `id`='" . $m_link_n['type'] .
                                    "' LIMIT 1;");
                                $m_count_n = mysql_fetch_array($m_count);
                                if ($m_link_n['type'] != 0) {
                                    if ($m_count_n['code'] == '$mp->newscount')
                                        $ehe = ' (' . $mp->newscount . ')';
                                    else
                                        $ehe = ' (' . call_user_func($m_count_n['code']) . ')';
                                } else
                                    $ehe = '';


                                echo '<div class="menu">';
                                $filename = '';
                                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_cat' LIMIT 1;");
                                $m_set_n = mysql_fetch_array($m_set);
                                if ($m_set_n['val'] == 1)
                                    $filename = './theme/' . $set_user['skin'] . "/";
                                else
                                    $filename = './';

                                $m_set = mysql_query("SELECT * FROM `cms_menu_settings` WHERE `key`='pic_path' LIMIT 1;");
                                $m_set_n = mysql_fetch_array($m_set);
                                $filename = $filename . $m_set_n['val'] . "/" . $m_link_n['pic'];

                                if (file_exists($filename) and $m_link_n['pic'] != '')
                                    echo '<img class="mme_image" alt="" src="' . $filename . '" /> ';
                                else
                                    echo $m_link_n['sumbo'] . ' ';

                                echo '<a href="' . $m_link_n['link'] . '">' . $m_link_n['name'] . '</a>' .
                                    $ehe . '</div>';
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo "<p><b>Error: " . mysql_error() . "</b><p>";
        exit();
    }
} else {
/*
-----------------------------------------------------------------
Блок общения
-----------------------------------------------------------------
*/
echo '<div class="phdr"><b>' . $lng['dialogue'] . '</b></div>';
// Ссылка на гостевую
if ($set['mod_guest'] || $rights >= 7)
    echo '<div class="menu"><a href="guestbook/index.php">' . $lng['guestbook'] . '</a> (' . counters::guestbook() . ')</div>';
// Ссылка на Форум
if ($set['mod_forum'] || $rights >= 7)
    echo '<div class="menu"><a href="forum/">' . $lng['forum'] . '</a> (' . counters::forum() . ')</div>';

/*
-----------------------------------------------------------------
Блок полезного
-----------------------------------------------------------------
*/    
echo '<div class="phdr"><b>' . $lng['useful'] . '</b></div>';
// Ссылка на загрузки
if ($set['mod_down'] || $rights >= 7)
    echo '<div class="menu"><a href="download/">' . $lng['downloads'] . '</a> (' . counters::downloads() . ')</div>';
// Ссылка на библиотеку
if ($set['mod_lib'] || $rights >= 7)
    echo '<div class="menu"><a href="library/">' . $lng['library'] . '</a> (' . counters::library() . ')</div>';
// Ссылка на библиотеку
if ($set['mod_gal'] || $rights >= 7)
    echo '<div class="menu"><a href="gallery/">' . $lng['gallery'] . '</a> (' . counters::gallery() . ')</div>';
if ($user_id || $set['active']) {
    echo '<div class="phdr"><b>' . $lng['community'] . '</b></div>' .
        '<div class="menu"><a href="users/index.php">' . $lng['users'] . '</a> (' . counters::users() . ')</div>' .
        '<div class="menu"><a href="users/album.php">' . $lng['photo_albums'] . '</a> (' . counters::album() . ')</div>';
}
echo '<div class="phdr"><a href="http://gazenwagen.com">Gazenwagen</a></div>';
}
?>
